<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminPanel
{
    public function handle($request, Closure $next)
    {

        if (Auth::check() && (Auth::user()->type === 'super_admin' || Auth::user()->type === 'admin_staff')) {
            return $next($request);
        }
        return redirect()->route('login')->with('error', 'Access denied.');
    }
}
