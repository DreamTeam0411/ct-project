<?php

namespace App\Services\Users;

use App\Repositories\RoleUser\RoleUserRepository;
use App\Repositories\UserRepository\Iterators\UserIterator;
use App\Repositories\UserRepository\RegisterUserDTO;
use App\Repositories\UserRepository\UserRepository;
use App\Repositories\UserRepository\UserSearchDTO;
use App\Repositories\UserRepository\UserUpdateDTO;
use Illuminate\Support\Collection;

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

    /**
     * @param RegisterUserDTO $DTO
     * @return UserIterator
     */
    public function register(RegisterUserDTO $DTO): UserIterator
    {
        $userId = $this->userRepository->insertAndGetId($DTO);
        $this->roleUserRepository->setCustomerRole($userId);

        return $this->userRepository->getUserById($userId);
    }

    /**
     * @param int $id
     * @return UserIterator
     */
    public function getUserById(int $id): UserIterator
    {
        return $this->userRepository->getUserById($id);
    }

    /**
     * @param UserUpdateDTO $DTO
     * @return UserIterator
     */
    public function update(UserUpdateDTO $DTO): UserIterator
    {
        $this->userRepository->update($DTO);

        return $this->userRepository->getUserById($DTO->getId());
    }

    /**
     * @param UserSearchDTO $DTO
     * @return Collection
     */
    public function searchUsersWithBusinessRole(UserSearchDTO $DTO): Collection
    {
        return $this->userRepository->searchUsersWithBusinessRole($DTO);
    }
}
