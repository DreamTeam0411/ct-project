<?php

namespace App\Repositories\UserRepository\Iterators;

class BusinessIterator
{
    protected int $id;
    protected string $firstName;
    protected string $lastName;
    protected string $phoneNumber;
    protected string|null $address;

    /**
     * @param object $data
     */
    public function __construct(object $data)
    {
        $this->id           = $data->id;
        $this->firstName    = $data->firstName;
        $this->lastName     = $data->lastName;
        $this->phoneNumber  = $data->phoneNumber;
        $this->address      = $data->address;
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
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }
}
