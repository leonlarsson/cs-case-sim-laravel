<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class EnsureUnboxerId
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Get existing unboxerId cookie if it exists
        $existingUnboxerId  = $request->cookie('unboxerId');

        // Generate a new UUID
        $newUnboxerId = Str::uuid();

        // Check if the existing unboxerId is a valid UUID
        if ($existingUnboxerId && Str::isUuid($existingUnboxerId)) {
            $newUnboxerId = $existingUnboxerId;
        }

        $cookie = cookie(
            'unboxerId',
            $newUnboxerId,
            60 * 24 * 365 // 1 year
        );

        // Adds it after, making it useless??
        Cookie::queue($cookie);

        return $response;
    }
}
