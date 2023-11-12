<?php

namespace App\Services\UserService\Login\Handlers;

use App\Services\UserService\AuthUserService;
use App\Services\UserService\Login\LoginDTO;
use App\Services\UserService\Login\LoginInterface;
use Closure;

class SetPersonalTokenHandler implements LoginInterface
{
    public function __construct(
        protected AuthUserService $authUserService
    ) {
    }

    /**
     * @param LoginDTO $loginDTO
     * @param Closure $next
     * @return LoginDTO
     */
    public function handle(LoginDTO $loginDTO, Closure $next): LoginDTO
    {
        $loginDTO->setBearerToken(
            $this->authUserService->createUserToken()
        );

        return $next($loginDTO);
    }
}
