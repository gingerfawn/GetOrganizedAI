<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentPlatform;
use App\Models\Plan;
use App\Models\Subscription;
use App\Resolvers\PaymentPlatformResolver;
use Carbon\Carbon;


class SubscriptionController extends Controller
{
    protected $paymentPlatformResolver;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PaymentPlatformResolver $paymentPlatformResolver)
    {
        // $this->middleware(['auth', 'unsubscribed']);
        $this->middleware(['auth']);


        $this->paymentPlatformResolver = $paymentPlatformResolver;
    }

    public function show(){
        
        $paymentPlatforms = PaymentPlatform::where('subscriptions_enabled', true)->get();

        return view('subscribe')->with([
            'plans' => Plan::all(),
            'paymentPlatforms' => $paymentPlatforms,
        ]);
    }

    public function store(Request $request){
        $rules = [
            'plan' => ['required', 'exists:plans,slug'],
            'payment_platform' => ['required', 'exists:payment_platforms,id'],
        ];

        $request->validate($rules);

        $paymentPlatform = $this->paymentPlatformResolver->resolveService($request->payment_platform);

        session()->put('subscriptionPlatformId', $request->payment_platform);

        return $paymentPlatform->handleSubscription($request);
    }

    public function approval(Request $request){
        $rules = [
            'plan' => ['required', 'exists:plans,slug'],
        ];

        $request->validate($rules);

        if(session()->has('subscriptionPlatformId')){
            $paymentPlatform = $this->paymentPlatformResolver->resolveService(session()->get('subscriptionPlatformId'));

            if($paymentPlatform->validateSubscription($request)){

                $plan = Plan::where('slug', $request->plan)->firstOrFail();
                $user = $request->user();
        
                $subscription = Subscription::create([
                    'active_until' => now()->addDays($plan->duration_in_days),
                    'user_id' => $user->id,
                    'plan_id' => $plan->id
                ]);
        
                return redirect()->route('subscribe.show')->withSuccess(['payment' => "Thanks, {$user->name}. You now have a {$plan->slug} subscription. Enjoy!"]);
            }
        }

        return redirect()->route('subscribe.show')->withErrors('We cannot verify your subscription. Please try again.');
    }

    public function cancelled(){
        return redirect()->route('subscribe.show')->withErrors('You cancelled. Come back whenever you are ready.');
    }
}
