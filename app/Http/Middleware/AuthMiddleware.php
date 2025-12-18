<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if token and email exist in headers
        $token = $request->header('Authorization');
        $email = $request->header('User-Email');

        if (!$token || !$email) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized - Token or Email missing'
            ], 401);
        }

        // Remove "Bearer " prefix if exists
        $token = str_replace('Bearer ', '', $token);

        // For simple testing, we just check if token exists
        // In production, you should validate the token properly
        if (empty($token)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized - Invalid token'
            ], 401);
        }

        return $next($request);
    }
}