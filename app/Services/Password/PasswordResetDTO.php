<?php

namespace App\Services\Password;

class PasswordResetDTO
{
    /**
     * @param string $email
     * @param string $token
     */
    public function __construct(
        protected string $email,
        protected string $token,
    ) {
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }
}
