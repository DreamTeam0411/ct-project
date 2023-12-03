<?php

namespace App\Services\Users\Login\Handlers;

use App\Services\Users\AuthUserService;
use App\Services\Users\Login\LoginDTO;
use App\Services\Users\Login\LoginInterface;
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
            throw new Exception('Credentials do not match our records.', 500);
        }

        return $next($loginDTO);
    }
}
