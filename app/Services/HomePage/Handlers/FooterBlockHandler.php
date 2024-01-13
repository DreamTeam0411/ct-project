<?php

namespace App\Services\HomePage\Handlers;

use App\Repositories\HomePageFooter\HomePageFooterBlockRepository;
use App\Services\HomePage\HomePageDTO;
use App\Services\HomePage\HomePageInterface;
use Closure;

class FooterBlockHandler implements HomePageInterface
{
    public function __construct(
        protected HomePageFooterBlockRepository $footerRepository,
    ){
    }

    /**
     * @param HomePageDTO $DTO
     * @param Closure $next
     * @return HomePageDTO
     */
    public function handle(HomePageDTO $DTO, Closure $next): HomePageDTO
    {
        $footer = $this->footerRepository->getTitlePageFooter();

        $DTO->setFooterBlock($footer);

        return $next($DTO);
    }
}
