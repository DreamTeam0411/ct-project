<?php

namespace App\Services\Users\Login\Handlers;

use App\Repositories\RoleUser\RoleUserRepository;
use App\Services\Users\Login\LoginDTO;
use App\Services\Users\Login\LoginInterface;
use Closure;

class GetUsersRolesHandler implements LoginInterface
{
    public function __construct(
        protected RoleUserRepository $roleUserRepository,
    ) {
    }

    /**
     * @param LoginDTO $loginDTO
     * @param Closure $next
     * @return LoginDTO
     */
    public function handle(LoginDTO $loginDTO, Closure $next): LoginDTO
    {
        $roles = $this->roleUserRepository->getUserRoles(
            $loginDTO->getUserIterator()->getId()
        );

        $loginDTO->setRoles($roles);

        return $next($loginDTO);
    }
}
