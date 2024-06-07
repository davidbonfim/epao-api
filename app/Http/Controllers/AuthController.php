<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use Facades\App\Services\AuthService;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserRegisterResource;
use App\Traits\ApiResponse;
use App\Traits\ApiException;

class AuthController extends Controller
{
    use ApiResponse, ApiException;

    public function login(AuthRequest $request)
    {
        $response = AuthService::login($request->validated());

        return $this->ok([
            'token' => $response['token'],
            'user' => new UserRegisterResource($response['user']),
        ]);
    }
    public function register(RegisterRequest $request)
    {
        $user = AuthService::register($request->validated());
        return $this->created(new UserRegisterResource($user));
    }
}
