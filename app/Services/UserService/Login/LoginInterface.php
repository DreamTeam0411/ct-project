<?php

namespace App\Services\UserService\Login;

use Closure;

interface LoginInterface
{
    /**
     * @param LoginDTO $loginDTO
     * @param Closure $next
     * @return LoginDTO
     */
    public function handle(LoginDTO $loginDTO, Closure $next): LoginDTO;
}
