<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->user() === null) {
            return redirect()->route('home')->with('error', 'You must be logged in to access this page.');
        }

        if($request->user()->role != 'admin') {
            session()->flash('error', 'Who do you think you are? You are not an admin!');
            return redirect()->route('account.profile');
        }
        return $next($request);
    }
}
