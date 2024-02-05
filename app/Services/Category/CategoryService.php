<?php

namespace App\Services\Category;

use App\Repositories\Categories\CategoryRepository;
use App\Repositories\Categories\CategoryStoreDTO;
use App\Repositories\Categories\Iterators\PrivateCategoryIterator;
use App\Repositories\Services\ServiceRepository;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class CategoryService
{
    /**
     * @param CategoryRepository $categoryRepository
     * @param ServiceRepository $serviceRepository
     * @param CategoryImageStorage $categoryImageStorage
     */
    public function __construct(
        protected CategoryRepository $categoryRepository,
        protected ServiceRepository $serviceRepository,
        protected CategoryImageStorage $categoryImageStorage,
    ) {
    }

    /**
     * @param int $lastId
     * @return Collection
     */
    public function getAllPrivateCategories(int $lastId = 0): Collection
    {
        return $this->categoryRepository->getAllPrivateCategories($lastId);
    }

    public function getAllPublicCategories(): Collection
    {
        return $this->categoryRepository->getAllPublicCategories();
    }

    /**
     * @param CategoryStoreDTO $DTO
     * @return PrivateCategoryIterator
     * @throws Exception
     */
    public function insertAndGetId(CategoryStoreDTO $DTO): PrivateCategoryIterator
    {
        if ($this->categoryRepository->isSlugExists(Str::slug($DTO->getTitle())) === true) {
            throw new Exception('This category already exists', 400);
        }

        $this->categoryImageStorage->saveImage($DTO->getIcon());
        $categoryId = $this->categoryRepository->insertAndGetId($DTO);

        return $this->categoryRepository->getPrivateCategoryById($categoryId);
    }

    /**
     * @param int $id
     * @return PrivateCategoryIterator|null
     */
    public function getById(int $id): ?PrivateCategoryIterator
    {
        return $this->categoryRepository->getPrivateCategoryById($id);
    }

    /**
     * @param int $id
     * @return void
     * @throws Exception
     */
    public function deleteById(int $id): void
    {
        if ($this->serviceRepository->isExistsByCategoryId($id) === true) {
            throw new Exception('This category is using by other services.', 400);
        }

        $this->categoryRepository->deleteById($id);
    }
}
