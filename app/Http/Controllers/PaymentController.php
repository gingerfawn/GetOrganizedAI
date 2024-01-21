<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Obtain a payment detal
     * min:12 minimum payment
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function pay(Request $request)
    {
        $rules = [
            'value' => ['required', 'numeric', 'min:12'],
            'currency' => ['required', 'exists:currencies,iso'],
            'payment_platform' => ['required', 'exists:payment_platforms,id']
        ];

        $request->validate($rules);

        return $request->all();
    }

    public function approval( Request $request ){

    }

    public function cancelled( Request $request ){

    }
}
