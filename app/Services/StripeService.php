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

}