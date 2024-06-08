<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\GenerateTokenService;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    protected $generateTokenService;
    
    public function __construct(GenerateTokenService $generateTokenService)
    {
        $this->generateTokenService = $generateTokenService;
    }

    public function execute(LoginRequest $request): JsonResponse
    {
        $token = $this->generateTokenService->execute($request->email, $request->password);
        
        return response()->json([
            'token' => $token,
        ], Response::HTTP_CREATED);
    }
}
