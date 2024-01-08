<?php

namespace App\Repositories\RoleUser;

use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
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
     * @return void
     */
    public function setAdminRole(int $userId): void
    {
        $this->query->insert([
            'role_id'       => Role::IS_ADMIN,
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
            'role_id'       => Role::IS_CUSTOMER,
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
}
