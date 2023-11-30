<?php

namespace App\Services\EmailVerificationService;

class EmailVerifyDTO
{
    public function __construct(
        protected int $id,
        protected int $expires,
        protected string $hash,
        protected string $signature,
    ) {
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getExpires(): int
    {
        return $this->expires;
    }

    /**
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * @return string
     */
    public function getSignature(): string
    {
        return $this->signature;
    }
}
