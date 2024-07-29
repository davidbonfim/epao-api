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

        

        $user = User::find(Auth::user()->id);

        if ($user->status === UserStatus::INACTIVE) {
            return $this->badRequestException(['message' => 'Esse usuário está inativo. Por favor, entre em contato com o suporte.']);
        }

        if ($user->status === UserStatus::PENDING_CONFIRMATION && $user->created_by === 'backoffice') {
            $token = auth()->user()->createToken('consents-token', ['consents'])->plainTextToken;
            $membership = $user->currentMembership;
            return [
                'token' => $token,
                'user' => $user,
                'membership' => [
                    'quota' => $membership->quota,
                    'quota_trial' => $membership->quota_trial,
                    'price_api' => $membership->api_credentials ? $membership->price_api : null,
                    'plan' => [
                        'id' => $membership->plan->id,
                        'name' => $membership->plan->name,
                        'price' => $membership->plan->price,
                        'trial_period_days' => $membership->plan->trial_period_days,
                    ]
                ],
            ];
        }
        if ($user->status === UserStatus::EMAIL_PENDING_CONFIRMATION) {
            return $this->badRequestException(['message' => 'E-mail não verificado.']);
        }
        /*
        if (!$user->currentMembership || $user->hasPendingMembership) {
            return [
                'token' => null,
                'user' => $user,
            ];
        }
        */
        if ($user->status === UserStatus::ACTIVE) {
            $user = tap($user)->update([
                'token' => Crypt::encrypt(generateRandomCode(6)),
            ]);
            UserLoginEvent::dispatch($user);
        }

        if ($user->status === UserStatus::PENDING_CONFIRMATION) {
            $user = tap($user)->update([
                'token' => Crypt::encrypt(generateRandomCode(4)),
            ]);
            CreateUserEvent::dispatch($user);
        }

        $token = auth()->user()->createToken('otp-token', ['otp-verification'])->plainTextToken;

        $user = tap($user)->update(['block_count' => 0]);

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
