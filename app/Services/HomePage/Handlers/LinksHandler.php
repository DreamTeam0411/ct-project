<?php

namespace App\Services\HomePage\Handlers;

use App\Repositories\HomePageLinks\HomePageLinksRepository;
use App\Services\HomePage\HomePageDTO;
use App\Services\HomePage\HomePageInterface;
use Closure;

class LinksHandler implements HomePageInterface
{
    public function __construct(
        protected HomePageLinksRepository $linksRepository,
    ){
    }

    /**
     * @param HomePageDTO $DTO
     * @param Closure $next
     * @return HomePageDTO
     */
    public function handle(HomePageDTO $DTO, Closure $next): HomePageDTO
    {
        $links = $this->linksRepository->getTitlesAndLinks();

        $DTO->setLinks($links);

        return $next($DTO);
    }
}
