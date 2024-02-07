<?php

namespace App\Repositories\UserRepository\Iterators;

class AdminBusinessIterator
{
    protected int $id;
    protected string $lastName;
    protected string $firstName;
    protected string|null $service;
    protected string $email;
    protected string|null $address;
    protected string $phoneNumber;

    /**
     * @param object $data
     */
    public function __construct(object $data)
    {
        $this->id           = $data->id;
        $this->lastName     = $data->lastName;
        $this->firstName    = $data->firstName;
        $this->service      = $data->service;
        $this->email        = $data->email;
        $this->address      = $data->address;
        $this->phoneNumber  = $data->phoneNumber;
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
     * @return string|null
     */
    public function getService(): ?string
    {
        return $this->service;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }
}
