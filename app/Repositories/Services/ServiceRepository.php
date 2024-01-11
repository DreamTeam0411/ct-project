<?php

namespace App\Repositories\Services;

use App\Repositories\Services\Iterators\PrivateServiceIterator;
use App\Repositories\Services\Iterators\TitlePageServiceIterator;
use App\Services\Users\AuthUserService;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ServiceRepository
{
    protected Builder $query;

    public function __construct(
        protected AuthUserService $authUserService,
    ) {
        $this->query = DB::table('services');
    }

    public function getServicesForTitlePage()
    {
        $collection = $this->query->select(
            DB::raw('services.id, services.title, services.description, AVG(reviews.rating) as rating')
        )->join(
            'reviews',
            'services.id',
            '=',
            'reviews.service_id'
        )->groupBy('services.id')
            ->take(4)->get();

        return $collection->map(function ($data) {
            return new TitlePageServiceIterator($data);
        });
    }

    public function getPrivateServices(int $lastId): Collection
    {
        $collection = $this->query
            ->select([
                'services.id',
                'services.category_id',
                'categories.title AS category_title',
                'categories.slug',
                'services.title AS service_title',
                'services.description',
                'services.user_id',
                'users.first_name',
                'users.last_name',
                'users.email',
                'services.price',
                'services.city_id',
                'cities.name AS city_name',
                'cities.slug AS city_slug',
                'services.created_at',
                'services.updated_at',
            ])
            ->join('categories', 'services.category_id', '=', 'categories.id')
            ->join('users', 'services.user_id', '=', 'users.id')
            ->join('cities', 'services.city_id', '=', 'cities.id')
            ->where('services.id', '>', $lastId)
            ->orderBy('services.id', 'ASC')
            ->take(100)
            ->get();

        return $collection->map(function ($service) {
            return $this->getIterator($service);
        });
    }

    public function insertAndGetId(AdminServiceStoreDTO $DTO): int
    {
        return $this->query
            ->insertGetId([
                'category_id'   => $DTO->getCategoryId(),
                'title'         => $DTO->getTitle(),
                'description'   => $DTO->getDescription(),
                'user_id'       => $DTO->getUserId(),
                'price'         => $DTO->getPrice(),
                'city_id'       => $DTO->getCityId(),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ]);
    }

    public function getById(int $id): PrivateServiceIterator
    {
        $query = $this->query
            ->select([
                'services.id',
                'services.category_id',
                'categories.title AS category_title',
                'categories.slug',
                'services.title AS service_title',
                'services.description',
                'services.user_id',
                'users.first_name',
                'users.last_name',
                'users.email',
                'services.price',
                'services.city_id',
                'cities.name AS city_name',
                'cities.slug AS city_slug',
                'services.created_at',
                'services.updated_at',
            ])
            ->join('categories', 'services.category_id', '=', 'categories.id')
            ->join('users', 'services.user_id', '=', 'users.id')
            ->join('cities', 'services.city_id', '=', 'cities.id')
            ->where('services.id', '=', $id)
            ->first();


        return $this->getIterator($query);
    }

    /**
     * @param ServiceUpdateDTO $DTO
     * @return void
     */
    public function updatePrivateService(ServiceUpdateDTO $DTO): void
    {
        $this->query
            ->where('services.id', '=', $DTO->getId())
            ->update([
                'services.category_id'   => $DTO->getCategoryId(),
                'services.title'         => $DTO->getTitle(),
                'services.description'   => $DTO->getDescription(),
                'services.user_id'       => $DTO->getUserId(),
                'services.price'         => $DTO->getPrice(),
                'services.city_id'       => $DTO->getCityId(),
                'services.updated_at'    => Carbon::now(),
            ]);
    }

    /**
     * @param int $id
     * @return void
     */
    public function deleteById(int $id): void
    {
        $this->query
            ->where('id', '=', $id)
            ->delete();
    }

    public function isExistsByCategoryId(int $categoryId): bool
    {
        return $this->query
            ->where('services.category_id', '=', $categoryId)
            ->exists();
    }

    /**
     * @param object|null $query
     * @return PrivateServiceIterator
     */
    protected function getIterator(object|null $query): PrivateServiceIterator
    {
        return new PrivateServiceIterator((object)[
            'id' => $query->id,
            'category' => (object)[
                'id' => $query->category_id,
                'title' => $query->category_title,
                'slug' => $query->slug,
            ],
            'title' => $query->service_title,
            'description' => $query->description,
            'user' => (object)[
                'id' => $query->user_id,
                'firstName' => $query->first_name,
                'lastName' => $query->last_name,
                'email' => $query->email,
            ],
            'price' => $query->price,
            'city' => (object)[
                'id' => $query->city_id,
                'name' => $query->city_name,
                'slug' => $query->city_slug,
            ],
            'createdAt' => $query->created_at,
            'updatedAt' => $query->updated_at,
        ]);
    }
}
