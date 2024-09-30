<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use App\Traits\ApiException;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use Facades\App\Services\AuthService;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserRegisterResource;

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

    public function logout(Request $request)
    {
        $user = AuthService::logout($request->user());
        return $this->ok("Usuário deslogado com sucesso.");
    }
}
