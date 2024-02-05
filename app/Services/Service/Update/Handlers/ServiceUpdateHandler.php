<?php

namespace App\Services\Service\Update\Handlers;

use App\Repositories\Services\ServiceRepository;
use App\Repositories\Services\ServiceUpdateDTO;
use App\Services\Service\Update\ServiceUpdateInterface;
use Closure;

class ServiceUpdateHandler implements ServiceUpdateInterface
{
    public function __construct(
        protected ServiceRepository $serviceRepository
    ) {
    }

    /**
     * @param ServiceUpdateDTO $DTO
     * @param Closure $next
     * @return ServiceUpdateDTO
     */
    public function handle(ServiceUpdateDTO $DTO, Closure $next): ServiceUpdateDTO
    {
        $this->serviceRepository->updatePrivateService($DTO);

        return $next($DTO);
    }
}
