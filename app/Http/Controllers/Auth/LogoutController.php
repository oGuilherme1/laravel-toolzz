<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\Auth\LogoutService;
use Symfony\Component\HttpFoundation\Response;

class LogoutController extends Controller
{
    protected $logoutService;
    
    public function __construct(LogoutService $logoutService)
    {
        $this->logoutService = $logoutService;
    }

    public function execute(Request $request): JsonResponse
    {
        $authorizationHeader = $request->header('Authorization');
        $token = str_replace('Bearer ', '', $authorizationHeader);

        $this->logoutService->execute($token);

        return response()->json([
            'message' => 'Logout successfully',
        ], Response::HTTP_OK);
    }
}
