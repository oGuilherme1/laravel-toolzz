<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Services\User\CreateUserService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CreateUserController extends Controller
{
    protected $createUserService;
    
    public function __construct(CreateUserService $createUserService)
    {
        $this->createUserService = $createUserService;
    }

    public function execute(CreateUserRequest $request): JsonResponse
    {
        $createUser = $this->createUserService->execute($request->validated());

        
        return response()->json([
            'user' => $createUser,
        ], Response::HTTP_OK);
    }

}
