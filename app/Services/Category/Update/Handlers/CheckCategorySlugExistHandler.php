<?php

namespace App\Services\Category\Update\Handlers;

use App\Repositories\Categories\CategoryRepository;
use App\Repositories\Categories\CategoryUpdateDTO;
use App\Services\Category\Update\CategoryUpdateInterface;
use Closure;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckCategorySlugExistHandler implements CategoryUpdateInterface
{

    public function __construct(
        protected CategoryRepository $categoryRepository
    ) {
    }

    /**
     * @param CategoryUpdateDTO $DTO
     * @param Closure $next
     * @return CategoryUpdateDTO
     * @throws Exception
     */
    public function handle(CategoryUpdateDTO $DTO, Closure $next): CategoryUpdateDTO
    {
        if ($this->categoryRepository->isSlugExists(Str::slug($DTO->getTitle()), $DTO->getId()) === true) {
            throw new Exception('This category already exists', 400);
        }

        return $next($DTO);
    }
}
