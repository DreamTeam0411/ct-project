<?php

namespace App\Services\HomePage;

use Closure;

interface HomePageInterface
{
    /**
     * @param HomePageDTO $DTO
     * @param Closure $next
     * @return HomePageDTO
     */
    public function handle(HomePageDTO $DTO, Closure $next): HomePageDTO;
}
