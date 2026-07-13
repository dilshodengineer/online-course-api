<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }



    public function register (RegisterRequest $request)
    {
        $result = $this->authService->register($request->validated());

        return response()->json([
            'message' => "Siz ro'yxat muvaffaqiyatli o'tdingiz.",
            'user' => new UserResource($result['user']),
            'token' => $result['token'],
        ], 201);

    }

    public function login ()
    {}

    public function logout ()
    {}

    public function me ()
    {}
}
