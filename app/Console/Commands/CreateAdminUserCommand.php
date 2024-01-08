<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Repositories\RoleUser\RoleUserRepository;
use App\Repositories\UserRepository\UserRepository;
use Illuminate\Console\Command;

class CreateAdminUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:AdminRoleByEmail {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(UserRepository $userRepository, RoleUserRepository $roleUserRepository): void
    {
        if ($userRepository->isUserExistsByEmail($this->argument('email')) === false) {
            $this->error('User email don\'t exists.');
            return;
        }

        $user = $userRepository->getUserByEmail($this->argument('email'));

        if ($userRepository->isUserHasRole($user->getId(), Role::IS_ADMIN)) {
            $this->warn('User has Admin role already.');
            return;
        }

        $roleUserRepository->deleteAllRoles($user->getId());
        $roleUserRepository->setAdminRole($user->getId());

        $this->info('User with ' . $user->getEmail() . ' mail got Admin role.');
    }
}
