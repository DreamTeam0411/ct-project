<?php

namespace App\Repositories\RoleUser;

use App\Enums\Role;
use App\Repositories\RoleUser\Iterators\RoleIterator;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RoleUserRepository
{
    protected Builder $query;

    public function __construct()
    {
        $this->query = DB::table('role_user');
    }

    /**
     * @param int $userId
     * @param Role $role
     * @return void
     */
    public function setRole(int $userId, Role $role): void
    {
        $this->query->insert([
            'role_id'       => $role->value,
            'user_id'       => $userId,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ]);
    }

    /**
     * @param int $userId
     * @return void
     */
    public function setCustomerRole(int $userId): void
    {
        $this->query->insert([
            'role_id'       => Role::IS_CUSTOMER->value,
            'user_id'       => $userId,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ]);
    }

    /**
     * @param int $userId
     * @return void
     */
    public function deleteAllRoles(int $userId): void
    {
        $this->query->where('user_id', $userId)->delete();
    }

    /**
     * @param int $userId
     * @return Collection
     */
    public function getUserRoles(int $userId): Collection
    {
        $collection = $this->query
            ->select([
                'roles.id AS role_id',
                'roles.name AS role_name'
            ])
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('role_user.user_id', '=', $userId)
            ->orderBy('roles.id', 'ASC')
            ->get();

        return $collection->map(function ($role) {
            return new RoleIterator($role);
        });
    }
}
