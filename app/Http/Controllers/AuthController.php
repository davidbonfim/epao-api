<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Facades\App\Services\AuthService;
use App\Http\Requests\LoginUserRequest;

class AuthController extends Controller
{
    public function login(LoginUserRequest $request)
    {
        $response = AuthService::login($request->validated());
        return $response;
    }
    public function register(Request $request)
    {
        $response = AuthService::register($request->validated());
        return $response;
    }
}
