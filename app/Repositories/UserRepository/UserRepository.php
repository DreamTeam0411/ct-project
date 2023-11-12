<?php

namespace App\Repositories\UserRepository;

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
}
