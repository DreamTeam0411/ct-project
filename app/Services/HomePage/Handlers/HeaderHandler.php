<?php

namespace App\Services\HomePage\Handlers;

use App\Repositories\HomePageHeaderBlock\HomePageHeaderBlockRepository;
use App\Services\HomePage\HomePageDTO;
use App\Services\HomePage\HomePageInterface;
use Closure;

class HeaderHandler implements HomePageInterface
{
    public function __construct(
        protected HomePageHeaderBlockRepository $headerBlockRepository,
    ){
    }

    /**
     * @param HomePageDTO $DTO
     * @param Closure $next
     * @return HomePageDTO
     */
    public function handle(HomePageDTO $DTO, Closure $next): HomePageDTO
    {
        $header = $this->headerBlockRepository->getInfo();

        $DTO->setHeader($header);

        return $next($DTO);
    }
}
