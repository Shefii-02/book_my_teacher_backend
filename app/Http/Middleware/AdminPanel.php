<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminPanel
{
    public function handle($request, Closure $next)
    {

        if (Auth::check() && (Auth::user()->acc_type === 'super_admin' || Auth::user()->acc_type === 'admin_staff')) {
            return $next($request);
        }
        return redirect()->route('login')->with('error', 'Access denied.');
    }
}
