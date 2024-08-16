<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user->is_locked) {
            Auth::logout();
            return redirect('/login')->with('error', 'Your account is locked. You cannot access the dashboard.');
        }

        if (!$user->is_approved) {
            Auth::logout();
            return redirect('/login')->with('error', 'Your account is not approved yet. Please contact the admin.');
        }

        return $next($request);
    }
}
