<?php

namespace App\Repositories\UserRepository;

use App\Enums\Role;
use App\Repositories\UserRepository\Iterators\AdminBusinessIterator;
use App\Repositories\UserRepository\Iterators\UserIterator;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
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
           'first_name'     => $this->setFirstLetterUppercase($DTO->getFirstName()),
           'last_name'      => $this->setFirstLetterUppercase($DTO->getLastName()),
           'phone_number'   => $DTO->getPhoneNumber(),
           'email'          => $DTO->getEmail(),
           'password'       => Hash::make($DTO->getPassword()),
           'created_at'     => Carbon::now(),
           'updated_at'     => Carbon::now(),
        ]);
    }

    /**
     * @param UserUpdateDTO $DTO
     * @return void
     */
    public function update(UserUpdateDTO $DTO): void
    {
        $this->query
            ->where('id', '=', $DTO->getId())
            ->update([
            'first_name'     => $this->setFirstLetterUppercase($DTO->getFirstName()),
            'last_name'      => $this->setFirstLetterUppercase($DTO->getLastName()),
            'phone_number'   => $DTO->getPhoneNumber(),
            'address'        => $DTO->getAddress(),
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
                ->select([
                    'users.id',
                    'users.first_name',
                    'users.last_name',
                    'users.phone_number',
                    'users.address',
                    'users.email',
                    'users.created_at',
                ])
                ->where('email', '=', $email)
                ->first()
        );
    }

    /**
     * WARNING: One-To-One Relation
     * @param UserSearchDTO $DTO
     * @return Collection
     */
    public function searchUsersWithBusinessRole(UserSearchDTO $DTO): Collection
    {
        $collection = new Collection(
            $this->query
                ->select([
                    'users.id',
                    'users.last_name',
                    'users.first_name',
                    'services.title AS service_title',
                    'users.email',
                    'users.address',
                    'users.phone_number'
                ])
                ->join('role_user', 'users.id', '=', 'role_user.user_id')
                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                ->leftJoin('services', 'users.id', '=', 'services.user_id')
                ->where('roles.id', '=', Role::IS_BUSINESS->value)
                ->where(function ($query) use ($DTO) {
                    $query->where('users.first_name', 'like', '%' . $DTO->getSearchInput() . '%')
                        ->orWhere('users.last_name', 'like', '%' . $DTO->getSearchInput() . '%');
                })
                ->get()
        );

        return $collection->unique('id')->map(function ($user) {
            return new AdminBusinessIterator((object)[
                'id'            => $user->id,
                'lastName'      => $user->last_name,
                'firstName'     => $user->first_name,
                'service'       => $user->service_title,
                'email'         => $user->email,
                'address'       => $user->address,
                'phoneNumber'   => $user->phone_number
            ]);
        });
    }

    /**
     * @param string $name
     * @return string
     */
    protected function setFirstLetterUppercase(string $name): string
    {
        return ucfirst(strtolower($name));
    }
}
