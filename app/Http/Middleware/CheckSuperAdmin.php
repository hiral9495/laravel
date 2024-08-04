<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckSuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->user_role != 'Super Admin') {
            if (Auth::user()->user_role =='Admin') {
                return redirect()->route('admin.dashboard');
            } elseif (Auth::user()->user_role =='Editor') {
                return redirect()->route('editor.dashboard');
            } elseif (Auth::user()->user_role =='Member') {
                return redirect()->route('member.dashboard');
            }

        }

        return $next($request);
    }
}
