<?php

namespace App\Services;

use App\Traits\ConsumesExternalServices;
use Illuminate\Http\Request;


class StripeService
{
    use ConsumesExternalServices;

    protected $baseUri;

    protected $key;

    protected $secret;

    public function __construct()
    {

        $this->baseUri = config('services.stripe.base_uri');
        $this->key = config('services.stripe.key');
        $this->secret = config('services.stripe.secret');
        $this->plans = config('services.stripe.plans');

    }

    public function resolveAuthorization(&$queryParams, &$formParams, &$headers){
        $headers['Authorization'] = $this->resolveAccessToken();
    }

    public function decodeResponse($response){
        return json_decode($response);
    }

    public function resolveAccessToken(){
        return "Bearer {$this->secret}";
    }

    public function handlePayment(Request $request){
        //dont forget there is no resolve factor
        $request->validate([
            'payment_method' => 'required',  
        ]);

        $intent = $this->createIntent($request->value, $request->currency, $request->payment_method);

        session()->put('paymentIntentId', $intent->id);

        return redirect()->route('approval');
    }

    public function handleApproval(){
        if(session()->has('paymentIntentId')){
            $paymentIntentId = session()->get('paymentIntentId');

            $confirmation = $this->confirmPayment($paymentIntentId);

            if($confirmation->status === 'requires_action'){
                $clientSecret = $confirmation->client_secret;

                return view('stripe.3d-secure')->with([
                    'clientSecret' => $clientSecret,
                ]);
            }

            if($confirmation->status === 'succeeded'){
                $currency = strtoupper($confirmation->currency);
                $amount = $confirmation->amount / 100;
            }

            return redirect()->route('home')->withSuccess(['payment' => "Thank you! We received your {$amount} {$currency} payment."]);

        }

        return redirect()->route('home')->withErrors('We are unable to confirm your payment. Please try again');

    }

    public function handleSubscription(Request $request){
        $customer = $this->createCustomer(
            $request->user()->name,
            $request->user()->email,
            $request->payment_method,
        );

        $subscription = $this->createSubscription(
            $customer->id,
            $request->payment_method,
            $this->plans[$request->plan],
        );


        if($subscription->status == 'active'){
            session()->put('subscriptionId', $subscription->id);

            return redirect()->route('subscribe.approval', [
                'plan' => $request->plan,
                'subscription_id' => $subscription->id
            ]);
        }

        $paymentIntent = $subscription->latest_invoice->payment_intent;

        if($paymentIntent->status === 'requires_action'){
            $clientSecret = $paymentIntent->client_secret;

            session()->put('subscriptionId', $subscription->id);

            return view('stripe.3d-secure-subscription')->with([
                'clientSecret' => $clientSecret, 
                'plan' => $request->plan,
                'paymentMethod' => $request->payment_method,
                'subscription_id' => $subscription->id
            ]);
        }

        return redirect()->route('subscribe.show')->withErrors('We were unable to ativate the subscription. Try again, please.');
    }

    public function validateSubscription(Request $request){
        if(session()->has('subscriptionId')){
            $subscriptionId = session()->get('subscriptionId');

            session()->forget('subscriptionId');

            return $request->subscription_id == $subscriptionId;
        }

        return false;
    }

    public function createIntent($value, $currency, $paymentMethod){

        return $this->makeRequest(
            'POST',
            '/v1/payment_intents',
            [],
            [
                'amount' => $value*100,
                'currency' => strtolower($currency),
                'payment_method' => $paymentMethod,
                'confirmation_method' => 'manual',
            ]
        );
    }

    public function confirmPayment($paymentIntentId){
        return $this->makeRequest(
            'POST',
            "/v1/payment_intents/{$paymentIntentId}/confirm",
            [],
            ['return_url' => env('APP_URL').'payments/approval']
        );
    }

    public function createCustomer($name, $email, $paymentMethod){
        return $this->makeRequest(
            'POST',
            '/v1/customers',
            [],
            [
                'name' => $name,
                'email' => $email,
                'payment_method' => $paymentMethod,
            ]
        );

    }

    public function createSubscription($customerId, $paymentMethod, $priceId){
        return $this->makeRequest(
            'POST',
            '/v1/subscriptions',
            [],
            [
                'customer' => $customerId,
                'items' => [['price' => $priceId]],
                'default_payment_method' => $paymentMethod,
                'expand' => ['latest_invoice.payment_intent'],
            ]
        );
    }
}