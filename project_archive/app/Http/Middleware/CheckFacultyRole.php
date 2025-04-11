<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckFacultyRole
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
        // Check if user is authenticated and has faculty role
        if (Auth::check() && Auth::user()->role === 'faculty') {
            return $next($request);
        }

        // If not faculty, redirect to dashboard with message
        return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
    }
}