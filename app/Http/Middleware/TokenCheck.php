<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Session;

class TokenCheck
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
            $token = User::where('remember_token', Auth::guard('web')->user()->remember_token)->value('remember_token');
            if ($token!==null) {
                return $next($request);
            } else {
                session()->flash('tokenNull', '請先登入帳號在結帳!');
                return \redirect('/cart/checkout');
            }
        } else {
            session()->flash('tokenNull', '請先登入帳號在結帳!');
            return \redirect('/cart/checkout');
        }
    }
}
