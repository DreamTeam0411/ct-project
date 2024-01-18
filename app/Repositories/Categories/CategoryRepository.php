<?php

namespace App\Repositories\Categories;

use App\Repositories\Categories\Iterators\HomePageCategoryCollectionIterator;
use App\Repositories\Categories\Iterators\HomePageCategoryIterator;
use App\Repositories\Categories\Iterators\PrivateCategoryIterator;
use App\Repositories\Categories\Iterators\SubcategoryIterator;
use App\Services\Users\AuthUserService;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use function PHPUnit\Framework\objectEquals;

class CategoryRepository
{
    protected Builder $query;

    /**
     * @param AuthUserService $authUserService
     */
    public function __construct(
        protected AuthUserService $authUserService,
    ) {
        $this->query = DB::table('categories');
    }

    /**
     * @return HomePageCategoryCollectionIterator
     */
    public function getHomePageCategories(): HomePageCategoryCollectionIterator
    {
        $collection = $this->query->select([
            'id',
            'parent_id',
            'icon',
            'title',
            'slug',
        ])->take(48)->get();

        return new HomePageCategoryCollectionIterator($collection);
    }

    /**
     * @param int $lastId
     * @return Collection
     */
    public function getAllPrivateCategories(int $lastId): Collection
    {
        $collection = $this->query
            ->select([
                'categories.id',
                'categories.parent_id',
                'categories.title',
                'categories.slug',
                'categories.created_by',
                'created_by_user.first_name AS cbu_first_name',
                'created_by_user.last_name AS cbu_last_name',
                'created_by_user.email AS cbu_email',
                'categories.updated_by',
                'updated_by_user.first_name AS ubu_first_name',
                'updated_by_user.last_name AS ubu_last_name',
                'updated_by_user.email AS ubu_email',
                'categories.created_at',
                'categories.updated_at',
            ])
            ->join('users AS created_by_user', 'categories.created_by', '=', 'created_by_user.id')
            ->join('users AS updated_by_user', 'categories.updated_by', '=', 'updated_by_user.id')
            ->where('categories.id', '>', $lastId)
            ->take(100)
            ->get();

        return $collection->map(function ($category) {
            return $this->getPrivateCategoryIterator($category);
        });
    }

    /**
     * @return Collection
     */
    public function getAllPublicCategories(): Collection
    {
        $collection = $this->query
            ->select([
                'categories.id',
                'categories.title',
                'categories.slug',
            ])
            ->where('categories.parent_id', '=', null)
            ->take(100)
            ->get();

        return $collection->map(function ($category) {
            return new SubcategoryIterator($category);
        });
    }

    /**
     * @param CategoryStoreDTO $DTO
     * @return int
     */
    public function insertAndGetId(CategoryStoreDTO $DTO): int
    {
        return $this->query->insertGetId([
            'parent_id'     => $DTO->getParentId(),
            'icon'          => 'default.svg',
            'title'         => $DTO->getTitle(),
            'slug'          => Str::slug($DTO->getTitle()),
            'created_by'    => $this->authUserService->getUserId(),
            'updated_by'    => $this->authUserService->getUserId(),
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ]);
    }

    /**
     * @param int $id
     * @return PrivateCategoryIterator|null
     */
    public function getPrivateCategoryById(int $id): ?PrivateCategoryIterator
    {
        $category = $this->query
            ->select([
                'categories.id',
                'categories.parent_id',
                'categories.title',
                'categories.slug',
                'categories.created_by',
                'created_by_user.first_name AS cbu_first_name',
                'created_by_user.last_name AS cbu_last_name',
                'created_by_user.email AS cbu_email',
                'categories.updated_by',
                'updated_by_user.first_name AS ubu_first_name',
                'updated_by_user.last_name AS ubu_last_name',
                'updated_by_user.email AS ubu_email',
                'categories.created_at',
                'categories.updated_at',
            ])
            ->where('categories.id', '=', $id)
            ->join('users AS created_by_user', 'categories.created_by', '=', 'created_by_user.id')
            ->join('users AS updated_by_user', 'categories.updated_by', '=', 'updated_by_user.id')
            ->first();

        return $this->getPrivateCategoryIterator($category);
    }

    public function updatePrivateCategory(CategoryUpdateDTO $DTO): void
    {
        $this->query
            ->where('categories.id', '=', $DTO->getId())
            ->update([
                'parent_id'     => $DTO->getParentId(),
                'title'         => $DTO->getTitle(),
                'slug'          => Str::slug($DTO->getTitle()),
                'updated_by'    => $this->authUserService->getUserId(),
                'updated_at'    => Carbon::now(),
            ]);
    }

    /**
     * @param int $id
     * @return void
     */
    public function deleteById(int $id): void
    {
        $this->query->where('id', '=', $id)->delete();
    }

    /**
     * @param object|null $category
     * @return PrivateCategoryIterator|null
     */
    private function getPrivateCategoryIterator(object|null $category): ?PrivateCategoryIterator
    {
        if ($category === null) {
            return null;
        }

        return new PrivateCategoryIterator((object)[
            'id' => $category->id,
            'parent_id' => $category->parent_id,
            'title' => $category->title,
            'slug' => $category->slug,
            'createdBy' => (object)[
                'id' => $category->created_by,
                'firstName' => $category->cbu_first_name,
                'lastName'  => $category->cbu_last_name,
                'email'     => $category->cbu_email,
            ],
            'updatedBy' => (object)[
                'id' => $category->updated_by,
                'firstName' => $category->ubu_first_name,
                'lastName'  => $category->ubu_last_name,
                'email'     => $category->ubu_email,
            ],
            'createdAt' => $category->created_at,
            'updatedAt' => $category->updated_at,
        ]);
    }
}
