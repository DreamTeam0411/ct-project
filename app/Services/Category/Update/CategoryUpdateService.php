<?php

namespace App\Services\Category\Update;

use App\Repositories\Categories\CategoryUpdateDTO;
use App\Services\Category\Update\Handlers\CategoryUpdateHandler;
use App\Services\Category\Update\Handlers\CheckCategorySlugExistHandler;
use Illuminate\Pipeline\Pipeline;

class CategoryUpdateService
{
    protected const HANDLERS = [
        CheckCategorySlugExistHandler::class,
        CategoryUpdateHandler::class,
    ];

    public function __construct(
        protected Pipeline $pipeline
    ) {
    }

    public function handle(CategoryUpdateDTO $DTO): CategoryUpdateDTO
    {
        return $this->pipeline
            ->send($DTO)
            ->through(self::HANDLERS)
            ->then(function (CategoryUpdateDTO $DTO) {
                return $DTO;
            });
    }
}
