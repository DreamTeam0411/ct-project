<?php

namespace App\Repositories\UserRepository\Iterators;

use Carbon\Carbon;

class SupportIterator
{
    protected int $id;
    protected string $firstName;
    protected string $lastName;
    protected string $email;

    public function __construct(object $data)
    {
        $this->id           = $data->id;
        $this->firstName    = $data->firstName;
        $this->lastName     = $data->lastName;
        $this->email        = $data->email;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
}
