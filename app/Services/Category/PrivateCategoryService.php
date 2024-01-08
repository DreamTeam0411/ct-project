<?php

namespace App\Services\Category;

use App\Repositories\Categories\CategoryRepository;
use App\Repositories\Categories\CategoryStoreDTO;
use App\Repositories\Categories\CategoryUpdateDTO;
use App\Repositories\Categories\Iterators\PrivateCategoryIterator;
use Illuminate\Support\Collection;

class PrivateCategoryService
{
    /**
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(
        protected CategoryRepository $categoryRepository
    ) {
    }

    /**
     * @param int $lastId
     * @return Collection
     */
    public function getAllCategories(int $lastId = 0): Collection
    {
        return $this->categoryRepository->getAllPrivateCategories($lastId);
    }

    /**
     * @param CategoryStoreDTO $DTO
     * @return PrivateCategoryIterator
     */
    public function insertAndGetId(CategoryStoreDTO $DTO): PrivateCategoryIterator
    {
        $categoryId = $this->categoryRepository->insertAndGetId($DTO);

        return $this->categoryRepository->getPrivateCategoryById($categoryId);
    }

    /**
     * @param int $id
     * @return PrivateCategoryIterator
     */
    public function getById(int $id): PrivateCategoryIterator
    {
        return $this->categoryRepository->getPrivateCategoryById($id);
    }

    /**
     * @param CategoryUpdateDTO $DTO
     * @return PrivateCategoryIterator
     */
    public function updateAndGetById(CategoryUpdateDTO $DTO): PrivateCategoryIterator
    {
        $this->categoryRepository->updatePrivateCategory($DTO);

        return $this->categoryRepository->getPrivateCategoryById($DTO->getId());
    }

    /**
     * @param int $id
     * @return void
     */
    public function deleteById(int $id): void
    {
        $this->categoryRepository->deleteById($id);
    }
}
