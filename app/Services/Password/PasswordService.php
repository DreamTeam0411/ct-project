<?php

namespace App\Services\Password;

use App\Repositories\UserRepository\ChangePasswordDTO;
use App\Repositories\UserRepository\UserRepository;
use Exception;

class PasswordService
{
    /**
     * @param UserRepository $userRepository
     * @param CanResetPasswordService $canResetPasswordService
     */
    public function __construct(
        protected UserRepository $userRepository,
        protected CanResetPasswordService $canResetPasswordService,
    ) {
    }

    /**
     * @param string $email
     * @return PasswordResetDTO
     * @throws Exception
     */
    public function resetPasswordPreparation(string $email): PasswordResetDTO
    {
        $user = $this->canResetPasswordService->getUser($email);

        $createdToken = $this->canResetPasswordService->createToken($user);

        return new PasswordResetDTO($user->getEmailForPasswordReset(), $createdToken);
    }

    /**
     * @param ChangePasswordDTO $DTO
     * @return void
     * @throws Exception
     */
    public function changePassword(ChangePasswordDTO $DTO): void
    {
        $userData = $this->canResetPasswordService->getUser($DTO->getEmail());

        if ($this->canResetPasswordService->isTokenExists($userData, $DTO->getToken()) === false) {
            throw new Exception('Invalid token or email.', 400);
        }

        $this->userRepository->updatePasswordByEmail($DTO->getEmail(), $DTO->getPassword());
        $this->canResetPasswordService->deleteToken($userData);
    }
}
