<?php

namespace App\Services\HomePage\Handlers;

use App\Repositories\HomePageCategories\HomePageCategoriesBlockRepository;
use App\Services\HomePage\HomePageDTO;
use App\Services\HomePage\HomePageInterface;
use Closure;

class CategoriesBlockHandler implements HomePageInterface
{
    public function __construct(
        protected HomePageCategoriesBlockRepository $categoriesBlockRepository,
    ){
    }

    /**
     * @param HomePageDTO $DTO
     * @param Closure $next
     * @return HomePageDTO
     */
    public function handle(HomePageDTO $DTO, Closure $next): HomePageDTO
    {
        $categoriesBlock = $this->categoriesBlockRepository->getCategoriesBlock();

        $DTO->setCategoriesBlock($categoriesBlock);

        return $next($DTO);
    }
}
