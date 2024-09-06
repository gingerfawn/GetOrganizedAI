<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;


class Unsubscribed
{

    
    /**
     * Handle an incoming request.
     * 
     * 
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response): (\Symfony\Component\BrowserKit\HttpBrowser): (\Symfony\Component\HttpClient\HttpClient)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(optional($request->user())->hasActiveSubscription()){
            return redirect('/');
        }

        return $next($request);
    }
}
