<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CompanyPanel
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && (Auth::user()->acc_type === 'company' || Auth::user()->acc_type === 'company-staff')) {
            return $next($request);
        }
        return redirect()->route('login')->with('error', 'Access denied.');
    }
}
