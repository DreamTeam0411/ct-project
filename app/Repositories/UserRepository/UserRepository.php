<?php

namespace App\Repositories\UserRepository;

use App\Enums\Role;
use App\Repositories\UserRepository\Iterators\UserIterator;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    protected Builder $query;

    public function __construct()
    {
        $this->query = DB::table('users');
    }

    /**
     * @param RegisterUserDTO $DTO
     * @return int
     */
    public function insertAndGetId(RegisterUserDTO $DTO): int
    {
       return $this->query->insertGetId([
           'first_name'     => $DTO->getFirstName(),
           'last_name'      => $DTO->getLastName(),
           'phone_number'   => $DTO->getPhoneNumber(),
           'email'          => $DTO->getEmail(),
           'password'       => Hash::make($DTO->getPassword()),
           'created_at'     => Carbon::now(),
           'updated_at'     => Carbon::now(),
       ]);
    }

    /**
     * @param int $id
     * @return UserIterator
     */
    public function getUserById(int $id): UserIterator
    {
        return new UserIterator(
            $this->query
                ->where('id', '=', $id)
                ->first()
        );
    }

    /**
     * @param string $email
     * @param string $password
     */
    public function updatePasswordByEmail(string $email, string $password): void
    {
        $this->query
            ->where('email', '=', $email)
            ->update([
                'password'      => Hash::make($password),
                'updated_at'    => Carbon::now(),
                ]);
    }

    public function isUserHasRole(int $userId, Role $role): bool
    {
        return $this->query
            ->select([
                'users.id',
                'users.first_name',
                'users.last_name',
                'users.phone_number',
                'users.photo',
                'users.email',
                'role_user.role_id',
                'roles.name',
            ])
            ->join('role_user', 'users.id', '=', 'user_id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->where('users.id', '=', $userId)
            ->where('role_user.role_id', '=', $role->value)
            ->exists();
    }

    /**
     * @param string $email
     * @return bool
     */
    public function isUserExistsByEmail(string $email): bool
    {
        return $this->query
            ->select([
                'users.id',
                'users.first_name',
                'users.last_name',
                'users.phone_number',
                'users.photo',
                'users.email',
                'users.created_at',
            ])
            ->where('users.email', '=', $email)
            ->exists();
    }

    /**
     * @param string $email
     * @return UserIterator
     */
    public function getUserByEmail(string $email): UserIterator
    {
        return new UserIterator(
            $this->query
                ->where('email', '=', $email)
                ->first()
        );
    }
}
