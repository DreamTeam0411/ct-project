<?php

namespace App\Services\HomePage\Handlers;

use App\Repositories\Categories\CategoryRepository;
use App\Services\HomePage\HomePageDTO;
use App\Services\HomePage\HomePageInterface;
use Closure;

class CategoriesContentHandler implements HomePageInterface
{
    public function __construct(
        protected CategoryRepository $categoryRepository,
    ){
    }

    /**
     * @param HomePageDTO $DTO
     * @param Closure $next
     * @return HomePageDTO
     */
    public function handle(HomePageDTO $DTO, Closure $next): HomePageDTO
    {
        $categories = $this->categoryRepository->getHomePageCategories();

        $DTO->setCategoriesContent($categories);

        return $next($DTO);
    }
}
