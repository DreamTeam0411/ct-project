<?php

namespace App\Services\Category;

use App\Repositories\Categories\CategoryRepository;
use App\Repositories\Categories\CategoryStoreDTO;
use App\Repositories\Categories\CategoryUpdateDTO;
use App\Repositories\Categories\Iterators\PrivateCategoryIterator;
use App\Repositories\Services\ServiceRepository;
use App\Services\Service\ServiceService;
use Exception;
use Illuminate\Support\Collection;

class PrivateCategoryService
{
    /**
     * @param CategoryRepository $categoryRepository
     * @param ServiceRepository $serviceRepository
     */
    public function __construct(
        protected CategoryRepository $categoryRepository,
        protected ServiceRepository $serviceRepository
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
     * @return PrivateCategoryIterator|null
     */
    public function getById(int $id): ?PrivateCategoryIterator
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
