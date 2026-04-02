<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestrictApiAccess
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    $allowedDomain = config('app.api_allowed_domain');

    // if ($request->getHost() !== $allowedDomain) {
    //   return response()->json(['error' => 'Unauthorized domain access'], 403);
    // }
    $userAgent = $request->header('User-Agent');

    // Block common tool identifiers
    // if (preg_match('/(PostmanRuntime|curl|Wget)/i', $userAgent)) {
    //   return response()->json(['error' => 'Direct API access is disabled.'], 403);
    // }

    // if (!$request->ajax()) {
    //     return response()->json(['error' => 'Only AJAX requests allowed.'], 403);
    // }
    //     $allowedReferer = 'https://your-frontend-app.com';

    // if ($request->header('Referer') !== $allowedReferer) {
    //     return response()->json(['error' => 'Invalid request origin.'], 403);
    // }


    return $next($request);
  }
}
