<?php

namespace App\Services\HomePage\Handlers;

use App\Repositories\HomePageLogo\HomePageLogoRepository;
use App\Services\HomePage\HomePageDTO;
use App\Services\HomePage\HomePageInterface;
use Closure;
use Exception;

class LogoHandler implements HomePageInterface
{
    public function __construct(
        protected HomePageLogoRepository $logoRepository,
    ) {
    }

    /**
     * @param HomePageDTO $DTO
     * @param Closure $next
     * @return HomePageDTO
     * @throws Exception
     */
    public function handle(HomePageDTO $DTO, Closure $next): HomePageDTO
    {
        $logo = $this->logoRepository->getLogo()->getLogo();

        $DTO->setLogo($logo);

        return $next($DTO);
    }
}
