<?php

namespace App\Services\Service\Update;

use App\Repositories\Services\ServiceUpdateDTO;
use Closure;

interface ServiceUpdateInterface
{
    /**
     * @param ServiceUpdateDTO $DTO
     * @param Closure $next
     * @return ServiceUpdateDTO
     */
    public function handle(ServiceUpdateDTO $DTO, Closure $next): ServiceUpdateDTO;
}
