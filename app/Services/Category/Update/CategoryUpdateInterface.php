<?php

namespace App\Services\Category\Update;

use App\Repositories\Categories\CategoryUpdateDTO;
use Closure;

interface CategoryUpdateInterface
{
    /**
     * @param CategoryUpdateDTO $DTO
     * @param Closure $next
     * @return CategoryUpdateDTO
     */
    public function handle(CategoryUpdateDTO $DTO, Closure $next): CategoryUpdateDTO;
}
