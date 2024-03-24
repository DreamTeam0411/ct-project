<?php

namespace App\Repositories\Services;

use App\Enums\Role;
use App\Repositories\Services\Iterators\PrivateServiceIterator;
use App\Repositories\Services\Iterators\PublicServiceIterator;
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

    /**
     * @return Collection
     */
    public function getServicesForTitlePage(): Collection
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

    /**
     * @param int $lastId
     * @return Collection
     */
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
                'services.photo AS service_photo',
                'services.user_id',
                'users.first_name',
                'users.last_name',
                'users.email',
                'users.address',
                'users.phone_number',
                'users.link',
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
            return $this->getPrivateIterator($service);
        });
    }

    /**
     * @param int $lastId
     * @return Builder
     */
    public function getPublicServices(int $lastId): Builder
    {
        return $this->query
            ->select([
                'services.id',
                'services.category_id',
                'categories.title AS category_title',
                'categories.slug',
                'services.title AS service_title',
                'services.description',
                'services.photo AS service_photo',
                'services.user_id',
                'users.first_name',
                'users.last_name',
                'users.phone_number',
                'users.email',
                'users.address',
                'services.price',
                'cities.name AS city_name',
                'cities.slug AS city_slug',
                'services.created_at',
            ])
            ->join('categories', 'services.category_id', '=', 'categories.id')
            ->join('users', 'services.user_id', '=', 'users.id')
            ->join('cities', 'services.city_id', '=', 'cities.id')
            ->join('role_user', 'services.user_id', '=', 'role_user.user_id')
            ->where('services.id', '>', $lastId)
            ->where('role_user.role_id', '=', Role::IS_BUSINESS->value);
    }

    public function queryCategorySlug(string $slug): Builder
    {
        return $this->query
            ->where('categories.slug', '=', $slug);
    }

    public function queryCitySlug(string $slug): Builder
    {
        return $this->query
            ->where('cities.slug', '=', $slug);
    }

    /**
     * @return Collection<PublicServiceIterator>
     */
    public function getPublicServicesWithParams(): Collection
    {
        $collection = $this->query
            ->orderBy('services.id', 'ASC')
            ->get();

        return $collection->map(function ($service) {
            return $this->getPublicIterator($service);
        });
    }

    /**
     * @param AdminServiceStoreDTO $DTO
     * @return int
     */
    public function insertAndGetId(AdminServiceStoreDTO $DTO): int
    {
        return $this->query
            ->insertGetId([
                'category_id'   => $DTO->getCategoryId(),
                'title'         => $DTO->getTitle(),
                'description'   => $DTO->getDescription(),
                'photo'         => $DTO->getPhoto()->hashName(),
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
                'services.photo AS service_photo',
                'users.first_name',
                'users.last_name',
                'users.address',
                'users.phone_number',
                'users.link',
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


        return $this->getPrivateIterator($query);
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

    public function updateImage(ServiceUpdateDTO $DTO): void
    {
        $this->query
            ->where('services.id', '=', $DTO->getId())
            ->update([
                'services.photo' => $DTO->getPhoto()->hashName(),
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
    protected function getPrivateIterator(object|null $query): PrivateServiceIterator
    {
        return new PrivateServiceIterator((object)[
            'id' => $query->id,
            'category' => (object)[
                'id'    => $query->category_id,
                'title' => $query->category_title,
                'slug'  => $query->slug,
            ],
            'title'         => $query->service_title,
            'description'   => $query->description,
            'photo'         => $query->service_photo,
            'user' => (object)[
                'id'            => $query->user_id,
                'first_name'    => $query->first_name,
                'last_name'     => $query->last_name,
                'phone_number'  => $query->phone_number,
                'address'       => $query->address,
                'link'          => $query->link,
                'email'         => $query->email,
                'created_at'    => $query->created_at,
            ],
            'price' => $query->price,
            'city' => (object)[
                'id'    => $query->city_id,
                'name'  => $query->city_name,
                'slug'  => $query->city_slug,
            ],
            'createdAt' => $query->created_at,
            'updatedAt' => $query->updated_at,
        ]);
    }

    /**
     * @param object|null $query
     * @return PublicServiceIterator
     */
    protected function getPublicIterator(object|null $query): PublicServiceIterator
    {
        return new PublicServiceIterator((object)[
            'id' => $query->id,
            'category' => (object)[
                'title' => $query->category_title,
                'slug'  => $query->slug,
            ],
            'title'         => $query->service_title,
            'description'   => $query->description,
            'photo'         => $query->service_photo ?? '',
            'user' => (object)[
                'id' => $query->user_id,
                'firstName'     => $query->first_name,
                'lastName'      => $query->last_name,
                'phoneNumber'   => $query->phone_number,
                'address'       => $query->address ?? '',
            ],
            'price' => $query->price,
            'city' => (object)[
                'name' => $query->city_name,
                'slug' => $query->city_slug,
            ],
            'createdAt' => $query->created_at,
        ]);
    }
}
