<?php

namespace App\Services\UserService\Login\Handlers;

use App\Repositories\UserRepository\UserRepository;
use App\Services\UserService\AuthUserService;
use App\Services\UserService\Login\LoginDTO;
use App\Services\UserService\Login\LoginInterface;
use Closure;

class SetAuthorizedUserHandler implements LoginInterface
{
    public function __construct(
        protected UserRepository $userRepository,
        protected AuthUserService $authUserService,
    ) {
    }
    /**
     * @param LoginDTO $loginDTO
     * @param Closure $next
     * @return LoginDTO
     */
    public function handle(LoginDTO $loginDTO, Closure $next): LoginDTO
    {
        $user = $this->userRepository->getUserById(
            $this->authUserService->getUserId()
        );

        $loginDTO->setUserIterator($user);

        return $next($loginDTO);
    }
}
