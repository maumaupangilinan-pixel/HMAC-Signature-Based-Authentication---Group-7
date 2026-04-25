<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HmacAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey    = $request->header('X-API-KEY');
        $signature = $request->header('X-SIGNATURE');
        $timestamp = $request->header('X-TIMESTAMP');

        // Check if headers are missing
        if (!$apiKey || !$signature || !$timestamp) {
            return response()->json([
                'message' => 'Unauthorized (Missing Headers)'
            ], 401);
        }

        $secret  = env('HMAC_SECRET', '852963');
        $payload = $request->getContent() ?: '';

        $generatedSignature = hash_hmac(
            'sha256',
            $apiKey . $timestamp . $payload,
            $secret
        );

        if (!hash_equals($generatedSignature, $signature)) {
            return response()->json([
                'message' => 'Unauthorized (Invalid Signature)'
            ], 401);
        }

        return $next($request);
    }
}