<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string  $role
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // If authenticated, check the role
            if (auth()->user()->role === $role) {
                // Role matches, continue with the request
                return $next($request);
            } else {
                // Role doesn't match, redirect to the appropriate dashboard
                if (auth()->user()->role === 'admin') {
                    return redirect()->route('admin.dashboard');
                } elseif (auth()->user()->role === 'officer') {
                    return redirect()->route('officer.dashboard');
                } elseif (auth()->user()->role === 'student') {
                    return redirect()->route('student.dashboard');
                }
            }
        }

        // If not authenticated, redirect to the login page
        return redirect('dashboard');
    }
}