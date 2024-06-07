<?php

namespace App\Services;

use App\Models\User;
use App\Traits\ApiException;

/**
 * Class AuthService.
 */
class AuthService
{
    use ApiException;
    /**
     * Login user 
     * @param $data
     */
    public function login($data)
    {
            
    }
    
    /**
     * Register new user
     * @param $data
     */
    public function register($data)
    {
        if($this->verifyUniqueEmail($data)){
            $this->badRequestException(['error' => 'E-mail já cadastrado.']);
        }

        if($this->verifyUniquePhone($data)){
            $this->badRequestException(['error' => 'Telefone já cadastrado.']);
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => encrypt($data['password']),
            'phone' => strval($data['phone']),
        ]);

        return $user;
    }


    private function verifyUniqueEmail(array $data, User $user = null): bool
    {
        if (!isset($data['email'])) {
            return false;
        }
        $q = User::query();

        if (isset($data['email'])) {
            $q = $q->where('email', $data['email']);
        }

        if ($user) {
            $q = $q->where('id', '<>', $user->id);
        }


        return $q->exists();
    }

    private function verifyUniquePhone(array $data, User $user = null): bool
    {
        if (!isset($data['phone'])) {
            return false;
        }
        
        $q = User::query();
        
        if (isset($data['phone'])) {
            $q->where('phone', $data['phone']);
        }
        if ($user) {
            $q->where('id', '<>', $user->id);
        }
        return $q->exists();
    }
}
