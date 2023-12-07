<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use Facades\App\Services\AuthService;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserRegisterResource;

class AuthController extends Controller
{
    public function login(AuthRequest $request)
    {
        $response = AuthService::login($request->validated());
        return $response;
    }
    public function register(RegisterRequest $request)
    {
        $user = AuthService::register($request->validated());
        return new UserRegisterResource($user);
    }
}
