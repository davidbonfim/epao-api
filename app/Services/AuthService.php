<?php

namespace App\Services;

use App\Models\User;

/**
 * Class AuthService.
 */
class AuthService
{
    public function login($data)
    {
        dd($data);
    }
    
    public function register($data)
    {
        User::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => encrypt($data['password']),
        ]);
    }
}
