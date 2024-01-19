<?php

namespace App\Repositories\UserRepository\Iterators;

use Carbon\Carbon;

class UserIterator
{
    protected int $id;
    protected string $firstName;
    protected string $lastName;
    protected string $phoneNumber;
    protected string|null $address;
    protected string $email;
    protected Carbon $createdAt;

    public function __construct(object $data)
    {
        $this->id           = $data->id;
        $this->firstName    = $data->first_name;
        $this->lastName     = $data->last_name;
        $this->phoneNumber  = $data->phone_number;
        $this->address      = $data->address;
        $this->email        = $data->email;
        $this->createdAt    = new Carbon($data->created_at);
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

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return Carbon
     */
    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }
}
