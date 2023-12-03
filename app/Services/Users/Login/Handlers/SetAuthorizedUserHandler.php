<?php

namespace App\Services\Users\Login\Handlers;

use App\Repositories\UserRepository\UserRepository;
use App\Services\Users\AuthUserService;
use App\Services\Users\Login\LoginDTO;
use App\Services\Users\Login\LoginInterface;
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
