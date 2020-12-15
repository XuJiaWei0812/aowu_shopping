<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class AuthLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('web')->check()) {
            if (Auth::guard('web')->user()->authority==0) {
                return redirect()->action('UserProductController@index');
            } elseif (Auth::guard('web')->user()->authority==1) {
                return redirect()->action('AdminProductController@index');
            }
        }

        return $next($request);
    }
}
