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
     * @param EmailVerificationService $emailVerificationService
     */
    public function __construct(
        protected UserRepository $userRepository,
        protected EmailVerificationService $emailVerificationService,
    ) {
    }

    public function register(RegisterUserDTO $DTO): UserIterator
    {
        $userId = $this->userRepository->insertAndGetId($DTO);

        $user = $this->userRepository->getUserById($userId);
        $DTO = new EmailVerificationDTO($user->getId(), $user->getEmail());

        $this->emailVerificationService->sendNotification($DTO);

        return $user;
    }

    public function getUserById(int $id): UserIterator
    {
        return $this->userRepository->getUserById($id);
    }
}
