<?php

namespace App\Repositories\Cities;

use App\Repositories\Cities\Iterators\CityIdNameAndSlugIterator;
use App\Repositories\Cities\Iterators\CityNameAndSlugIterator;
use App\Repositories\Cities\Iterators\PrivateCityIterator;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CityRepository
{
    protected Builder $query;
    public const COUNTRY = 'Україна';
    public const UKRAINE_ID = 1;

    public function __construct()
    {
        $this->query = DB::table('cities');
    }

    /**
     * @param int $lastId
     * @return Collection
     */
    public function getAllPrivateCities(int $lastId): Collection
    {
        $collection = $this->query
                ->select([
                    'cities.id',
                    'cities.country_id',
                    'countries.name AS country_name',
                    'cities.parent_id',
                    'cities.name',
                    'cities.slug',
                    'cities.created_at',
                    'cities.updated_at'
                ])
                ->join('countries', 'cities.country_id', '=', 'countries.id')
                ->where('cities.id', '>', $lastId)
                ->take(100)
                ->get();

        return $collection->map(function ($city) {
            return new PrivateCityIterator((object)[
                'id'            => $city->id,
                'country'       => (object)[
                    'id'        => $city->country_id,
                    'name'      => $city->country_name,
                ],
                'parentId'      => $city->parent_id,
                'name'          => $city->name,
                'slug'          => $city->slug,
                'createdAt'     => $city->created_at,
                'updatedAt'     => $city->updated_at,
            ]);
        });
    }

    public function getAllPublicCities()
    {
        $collection = $this->query
            ->select([
                'cities.id',
                'cities.name',
                'cities.slug',
            ])
            ->where('cities.parent_id', '=', null)
            ->where('cities.country_id', '=', self::UKRAINE_ID)
            ->take(100)
            ->get();

        return $collection->map(function ($city) {
            return new CityIdNameAndSlugIterator((object)[
                'id'            => $city->id,
                'name'          => $city->name,
                'slug'          => $city->slug,
            ]);
        });
    }

    public function insertAndGetId(CityStoreDTO $DTO): int
    {
        return $this->query
            ->insertGetId([
                'country_id'    => $DTO->getCountryId(),
                'parent_id'     => $DTO->getParentId(),
                'name'          => $DTO->getName(),
                'slug'          => Str::slug(self::COUNTRY . ' ' . $DTO->getName()),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ]);
    }

    /**
     * @param int $id
     * @return PrivateCityIterator
     */
    public function getById(int $id): PrivateCityIterator
    {
        $query = $this->query
            ->select([
                'cities.id',
                'cities.country_id',
                'countries.name AS country_name',
                'cities.parent_id',
                'cities.name',
                'cities.slug',
                'cities.created_at',
                'cities.updated_at'
            ])
            ->where('cities.id', '=', $id)
            ->join('countries', 'cities.country_id', '=', 'countries.id')
            ->first();

        return new PrivateCityIterator((object)[
            'id'            => $query->id,
            'country'       => (object)[
                'id'        => $query->country_id,
                'name'      => $query->country_name,
            ],
            'parentId'      => $query->parent_id,
            'name'          => $query->name,
            'slug'          => $query->slug,
            'createdAt'     => $query->created_at,
            'updatedAt'     => $query->updated_at,
        ]);
    }

    public function update(CityUpdateDTO $DTO): void
    {
        $this->query
            ->where('cities.id', '=', $DTO->getId())
            ->update([
                'country_id'    => $DTO->getCountryId(),
                'parent_id'     => $DTO->getParentId(),
                'name'          => $DTO->getName(),
                'slug'          => Str::slug(self::COUNTRY . ' ' . $DTO->getName()),
                'updated_at'    => Carbon::now(),
            ]);
    }

    public function delete(int $id): void
    {
        $this->query
            ->where('id', '=', $id)
            ->delete();
    }
}
