<?php

namespace App\Repositories\UserRepository;

class ChangePasswordDTO
{
    protected string $email;
    protected string $token;
    protected string $password;

    public function __construct(array $data)
    {
        $this->email                = $data['email'];
        $this->token                = $data['token'];
        $this->password             = $data['password'];
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

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}
