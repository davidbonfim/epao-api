<?php

namespace App\Services;

use App\Models\User;

/**
 * Class AuthService.
 */
class AuthService
{
    /**
     * Login user 
     * @param $data
     */
    public function login($data)
    {
        dd($data);
    }
    
    /**
     * Register new user
     * @param $data
     */
    public function register($data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => encrypt($data['password']),
            'phone' => strval($data['phone']),
        ]);
        return $user;
    }
}
