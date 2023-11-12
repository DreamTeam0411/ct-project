<?php

namespace App\Services\UserService\Login\Handlers;

use App\Services\UserService\AuthUserService;
use App\Services\UserService\Login\LoginDTO;
use App\Services\UserService\Login\LoginInterface;
use Closure;

class CheckValidDataHandler implements LoginInterface
{
    public function __construct(
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
        $data = [
            'email' => $loginDTO->getEmail(),
            'password' => $loginDTO->getPassword(),
        ];

        if ($this->authUserService->isUserDataValid($data) === false) {
            return $loginDTO;
        }

        return $next($loginDTO);
    }
}
