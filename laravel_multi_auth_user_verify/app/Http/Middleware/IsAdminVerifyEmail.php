<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class IsAdminVerifyEmail
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
     

        if (!Auth::guard('admin')->user()->is_email_verified) {
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login')
                    ->with('message', 'You need to confirm your account. We have sent you an activation code, please check your email.');

          }
        return $next($request);
    }
}