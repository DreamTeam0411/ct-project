<?php

namespace App\Console\Commands;

use App\Enums\Role;
use App\Repositories\RoleUser\RoleUserRepository;
use App\Repositories\UserRepository\UserRepository;
use Illuminate\Console\Command;

class ChangeUsersRoleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:roleChange {email}';

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

        $roleName = $this->choice('Choose user\'s role?', [
            Role::IS_ADMIN->value       => 'Admin',
            Role::IS_SUPPORT->value     => 'Support',
            Role::IS_BUSINESS->value    => 'Business',
            Role::IS_CUSTOMER->value    => 'Customer',
        ], 'Customer');

        $role = match ($roleName) {
            'Admin'     => Role::IS_ADMIN,
            'Support'   => Role::IS_SUPPORT,
            'Business'  => Role::IS_BUSINESS,
            'Customer'  => Role::IS_CUSTOMER,
        };

        $roleUserRepository->deleteAllRoles($user->getId());
        $roleUserRepository->setRole($user->getId(), $role);

        $this->info('User with ' . $user->getEmail() . ' mail got ' . $roleName . ' role.');
    }
}
