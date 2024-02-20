<?php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $response->header('Access-Control-Allow-Origin', 'https://scontent-ams1-1.cdninstagram.com');
        $response->header('Access-Control-Allow-Origin', 'https://scontent-ams2-1.cdninstagram.com');
        $response->header('Access-Control-Allow-Origin', 'https://scontent-ams3-1.cdninstagram.com');
        $response->header('Access-Control-Allow-Origin', 'https://scontent-ams4-1.cdninstagram.com');
        $response->header('Access-Control-Allow-Origin', 'https://scontent-ams1-2.cdninstagram.com');
        $response->header('Access-Control-Allow-Origin', 'https://scontent-ams1-3.cdninstagram.com');
        $response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');

        return $response;
    }
}