<?php

namespace App\Http\Controllers;

use Facades\App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $response = AuthService::login($request->all());
        return $response;
    }
}
