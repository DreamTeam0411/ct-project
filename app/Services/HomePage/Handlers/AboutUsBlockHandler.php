<?php

namespace App\Services\HomePage\Handlers;

use App\Repositories\HomePageAboutUsBlock\HomePageAboutUsBlockRepository;
use App\Services\HomePage\HomePageDTO;
use App\Services\HomePage\HomePageInterface;
use Closure;

class AboutUsBlockHandler implements HomePageInterface
{
    public function __construct(
        protected HomePageAboutUsBlockRepository $aboutUsBlockRepository,
    ){
    }

    /**
     * @param HomePageDTO $DTO
     * @param Closure $next
     * @return HomePageDTO
     */
    public function handle(HomePageDTO $DTO, Closure $next): HomePageDTO
    {
        $aboutUsBlock = $this->aboutUsBlockRepository->getAboutUsBlock();

        $DTO->setAboutUsBlock($aboutUsBlock);

        return $next($DTO);
    }
}
