<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HmacAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('X-API-KEY');
        $signature = $request->header('X-SIGNATURE');
        $timestamp = $request->header('X-TIMESTAMP');

        $secret = env('HMAC_SECRET', 'my_secret_key');

        $payload = json_encode($request->all());

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
