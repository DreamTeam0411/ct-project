<?php

namespace App\Services\Category\Update\Handlers;

use App\Repositories\Categories\CategoryRepository;
use App\Repositories\Categories\CategoryUpdateDTO;
use App\Services\Category\CategoryImageStorage;
use App\Services\Category\Update\CategoryUpdateInterface;
use Closure;

class CategoryUpdateHandler implements CategoryUpdateInterface
{
    public function __construct(
        protected CategoryRepository $categoryRepository,
    ) {
    }

    /**
     * @param CategoryUpdateDTO $DTO
     * @param Closure $next
     * @return CategoryUpdateDTO
     */
    public function handle(CategoryUpdateDTO $DTO, Closure $next): CategoryUpdateDTO
    {
        $this->categoryRepository->updatePrivateCategory($DTO);

        return $next($DTO);
    }
}
