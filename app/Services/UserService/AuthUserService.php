<?php

namespace App\Services\UserService;

use App\Models\User;
use Laravel\Passport\PersonalAccessTokenResult;
use Laravel\Passport\Token;
use Laravel\Passport\TransientToken;

class AuthUserService
{
    /**
     * @param array $data
     * @return bool
     */
    public function isUserDataValid(array $data): bool
    {
        return auth()->attempt($data);
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return auth()->id();
    }

    /**
     * @return int
     */
    public function getUserIdByApi(): int
    {
        return auth('api')->id();
    }

    /**
     * @return PersonalAccessTokenResult
     */
    public function createUserToken(): PersonalAccessTokenResult
    {
        return auth()->user()->createToken(config('app.name'));
    }

    /**
     * @return Token|TransientToken|null
     */
    public function getUserToken(): Token|TransientToken|null
    {
        return auth()->user()->token();
    }

    /**
     * Check if user's email is verified.
     * @return bool
     */
    public function isEmailVerified(): bool
    {
        /** @var User $user */
        $user = auth()->user();
        return $user->hasVerifiedEmail();
    }

    /**
     * Send verification mail on user's email.
     * @return void
     */
    public function sendEmailVerificationNotification(): void
    {
        /** @var User $user */
        $user = auth()->user();
        $user->sendEmailVerificationNotification();
    }
}
