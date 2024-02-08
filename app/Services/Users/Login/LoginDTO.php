<?php

namespace App\Services\Users\Login;

use App\Repositories\UserRepository\Iterators\UserIterator;
use Illuminate\Support\Collection;
use Laravel\Passport\PersonalAccessTokenResult;

class LoginDTO
{
    protected UserIterator $userIterator;
    protected PersonalAccessTokenResult $bearerToken;
    protected Collection $roles;

    public function __construct(
        protected string $email,
        protected string $password,
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
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return UserIterator
     */
    public function getUserIterator(): UserIterator
    {
        return $this->userIterator;
    }

    /**
     * @param UserIterator $userIterator
     */
    public function setUserIterator(UserIterator $userIterator): void
    {
        $this->userIterator = $userIterator;
    }

    /**
     * @return PersonalAccessTokenResult
     */
    public function getBearerToken(): PersonalAccessTokenResult
    {
        return $this->bearerToken;
    }

    /**
     * @param PersonalAccessTokenResult $bearerToken
     */
    public function setBearerToken(PersonalAccessTokenResult $bearerToken): void
    {
        $this->bearerToken = $bearerToken;
    }

    /**
     * @return Collection
     */
    public function getRoles(): Collection
    {
        return $this->roles;
    }

    /**
     * @param Collection $roles
     */
    public function setRoles(Collection $roles): void
    {
        $this->roles = $roles;
    }
}
