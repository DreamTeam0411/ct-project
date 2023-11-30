<?php

namespace App\Services\UserService;

use App\Notifications\EmailVerification\EmailVerificationDTO;
use App\Repositories\UserRepository\Iterators\UserIterator;
use App\Repositories\UserRepository\RegisterUserDTO;
use App\Repositories\UserRepository\UserRepository;
use App\Services\EmailVerificationService\EmailVerificationService;

class UserService
{
    /**
     * @param UserRepository $userRepository
     */
    public function __construct(
        protected UserRepository $userRepository,
    ) {
    }

    public function register(RegisterUserDTO $DTO): UserIterator
    {
        $userId = $this->userRepository->insertAndGetId($DTO);

        return $this->userRepository->getUserById($userId);
    }

    public function getUserById(int $id): UserIterator
    {
        return $this->userRepository->getUserById($id);
    }
}
