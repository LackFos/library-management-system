<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseHelper;
use App\Http\Helpers;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class Verified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!$request->user()->email_verified_at) {
            return ResponseHelper::throwUnauthorizedError('Please verify your email first');
        }
        
        return $next($request);
    }
}