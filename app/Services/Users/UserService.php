<?php

namespace App\Services\Users;

use App\Repositories\RoleUser\RoleUserRepository;
use App\Repositories\UserRepository\Iterators\UserIterator;
use App\Repositories\UserRepository\RegisterUserDTO;
use App\Repositories\UserRepository\UserRepository;

class UserService
{
    /**
     * @param UserRepository $userRepository
     * @param RoleUserRepository $roleUserRepository
     */
    public function __construct(
        protected UserRepository $userRepository,
        protected RoleUserRepository $roleUserRepository
    ) {
    }

    public function register(RegisterUserDTO $DTO): UserIterator
    {
        $userId = $this->userRepository->insertAndGetId($DTO);
        $this->roleUserRepository->setCustomerRole($userId);

        return $this->userRepository->getUserById($userId);
    }

    public function getUserById(int $id): UserIterator
    {
        return $this->userRepository->getUserById($id);
    }
}
