<?php

namespace App\Services\Users\Login\Handlers;

use App\Services\Users\AuthUserService;
use App\Services\Users\Login\LoginDTO;
use App\Services\Users\Login\LoginInterface;
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
