<?php

namespace App\Services\Category\Update\Handlers;

use App\Repositories\Categories\CategoryRepository;
use App\Repositories\Categories\CategoryUpdateDTO;
use App\Services\Category\CategoryImageStorage;
use App\Services\Category\Update\CategoryUpdateInterface;
use Closure;

class CategoryImageHandler implements CategoryUpdateInterface
{
    public function __construct(
        protected CategoryRepository $categoryRepository,
        protected CategoryImageStorage $categoryImageStorage,
    ) {
    }

    /**
     * @param CategoryUpdateDTO $DTO
     * @param Closure $next
     * @return CategoryUpdateDTO
     */
    public function handle(CategoryUpdateDTO $DTO, Closure $next): CategoryUpdateDTO
    {
        if ($DTO->getIcon() !== null) {
            $category = $this->categoryRepository->getPrivateCategoryById($DTO->getId());

            if (
                $category->getIcon() !== null &&
                $this->categoryImageStorage->isImageExists($category->getIcon()) === true
            ) {
                $this->categoryImageStorage->deleteImage($category->getIcon());
            }

            $this->categoryImageStorage
                ->saveImage(
                    $DTO->getIcon()
                );

            $this->categoryRepository->updateImage($DTO);
        }

        return $next($DTO);
    }
}
