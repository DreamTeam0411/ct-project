<?php

namespace App\Services\HomePage\Handlers;

use App\Repositories\SocialMediaNetwork\SocialMediaNetworkRepository;
use App\Services\HomePage\HomePageDTO;
use App\Services\HomePage\HomePageInterface;
use Closure;

class SocialMediaHandler implements HomePageInterface
{
    public function __construct(
        protected SocialMediaNetworkRepository $socialMediaRepository,
    ){
    }

    /**
     * @param HomePageDTO $DTO
     * @param Closure $next
     * @return HomePageDTO
     */
    public function handle(HomePageDTO $DTO, Closure $next): HomePageDTO
    {
        $socialMedia = $this->socialMediaRepository->getHomePageSocialMediaNetworks();

        $DTO->setSocialMedia($socialMedia);

        return $next($DTO);
    }
}
