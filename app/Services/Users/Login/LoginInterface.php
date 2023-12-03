<?php

namespace App\Services\Users\Login;

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
