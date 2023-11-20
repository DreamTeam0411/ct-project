<?php

namespace App\Services\UserService\Login\Handlers;

use App\Services\UserService\AuthUserService;
use App\Services\UserService\Login\LoginDTO;
use App\Services\UserService\Login\LoginInterface;
use Closure;
use Exception;

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
     * @throws Exception
     */
    public function handle(LoginDTO $loginDTO, Closure $next): LoginDTO
    {
        $data = [
            'email' => $loginDTO->getEmail(),
            'password' => $loginDTO->getPassword(),
        ];

        if ($this->authUserService->isUserDataValid($data) === false) {
            throw new Exception('Credentials do not match our records.', 200);
        }

        return $next($loginDTO);
    }
}
