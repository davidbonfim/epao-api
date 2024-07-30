<?php

namespace App\Services;

use App\Models\User;
use App\Traits\ApiException;
use Illuminate\Support\Facades\Auth;

/**
 * Class AuthService.
 */
class AuthService
{
    use ApiException;
    
    /**
     * login and token generation
     *
     * @param  array  $data
     * @return array
     */
    public function login(array $data): array
    {
        if (!Auth::attempt($data)) {
            $user = User::where('email', $data['email'])->first();

            if (!$user) {
                return $this->badRequestException(['message' => 'Email ou senha inválidos.']);
            }
        }

        $token = $user->createToken('otp-token', ['otp-verification'])->plainTextToken;        
        return [
            'token' => $token,
            'user' => $user,
        ];
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
