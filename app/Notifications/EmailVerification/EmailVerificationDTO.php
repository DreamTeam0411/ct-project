<?php

namespace App\Notifications\EmailVerification;

class EmailVerificationDTO
{
    public function __construct(
        protected string $id,
        protected string $email,
    ) {
    }

    /**
     * User ID.
     * @return int
     */
    public function getKey(): int
    {
        return $this->id;
    }

    /**
     * Email for Hash.
     * @return string
     */
    public function getEmailForVerification(): string
    {
        return $this->email;
    }

    /**
     * Email for sending.
     * @return string
     */
    public function routeNotificationFor(): string
    {
        return $this->email;
    }
}
