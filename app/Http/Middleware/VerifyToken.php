<?php

namespace App\Http\Middleware;

use App\Repositories\Auth\AuthRepository;
use App\Services\Auth\GenerateTokenService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        $authorizationHeader = $request->header('Authorization');
        if (!$authorizationHeader) {
            return response()->json(['error' => 'Token not provided.'], 401);
        }

        $token = str_replace('Bearer ', '', $authorizationHeader);

        $serviceToken = GenerateTokenService::create(new AuthRepository);

        if($serviceToken->isExpired($token)){
            return response()->json(['error' => 'Token is expired.'], 401);
        }

        return $next($request);
    }
}
