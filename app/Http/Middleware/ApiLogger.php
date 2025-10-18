<?php
namespace App\Http\Middleware;

use Closure;
use App\Models\ApiLog;
use Illuminate\Support\Facades\Auth;

class ApiLogger
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        try {
            ApiLog::create([
                'endpoint'      => $request->path(),
                'method'        => $request->method(),
                'headers'       => $request->headers->all(),
                'request_body'  => $request->except(['password', 'token']),
                'response_body' => json_decode($response->getContent(), true),
                'status_code'   => $response->status(),
                'user_id'       => Auth::id(),
                'ip_address'    => $request->ip(),
                'device_info'   => $request->header('User-Agent'),
            ]);
        } catch (\Exception $e) {
            \Log::error('API Logging Failed: ' . $e->getMessage());
        }

        return $response;
    }
}
