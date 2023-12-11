<?php

namespace App\Services\Password;

use Exception;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Support\Facades\Password;

class CanResetPasswordService
{
    /**
     * @param string $email
     * @return CanResetPassword
     * @throws Exception
     */
    public function getUser(string $email): CanResetPassword
    {
        $user = Password::getUser([
            'email' => $email,
        ]);

        if ($user === null) {
            throw new Exception('The user is not exist.', 400);
        }

        return $user;
    }

    /**
     * @param CanResetPassword $user
     * @return string
     */
    public function createToken(CanResetPassword $user): string
    {
        return Password::createToken($user);
    }

    /**
     * @param CanResetPassword $user
     * @param string $token
     * @return bool
     */
    public function isTokenExists(CanResetPassword $user, string $token): bool
    {
        return Password::tokenExists($user, $token);
    }

    /**
     * @param CanResetPassword $user
     * @return void
     */
    public function deleteToken(CanResetPassword $user): void
    {
        Password::deleteToken($user);
    }
}
