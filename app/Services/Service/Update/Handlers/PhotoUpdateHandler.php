<?php

namespace App\Services\Service\Update\Handlers;

use App\Repositories\Services\ServiceRepository;
use App\Repositories\Services\ServiceUpdateDTO;
use App\Services\Service\ServiceImageStorage;
use App\Services\Service\Update\ServiceUpdateInterface;
use Closure;

class PhotoUpdateHandler implements ServiceUpdateInterface
{
    public function __construct(
        protected ServiceRepository $serviceRepository,
        protected ServiceImageStorage $serviceImageStorage,
    ) {
    }

    /**
     * @param ServiceUpdateDTO $DTO
     * @param Closure $next
     * @return ServiceUpdateDTO
     */
    public function handle(ServiceUpdateDTO $DTO, Closure $next): ServiceUpdateDTO
    {
        if ($DTO->getPhoto() !== null) {
            $service = $this->serviceRepository->getById($DTO->getId());

            if ($this->serviceImageStorage->isImageExists($service->getPhoto()) && $service->getPhoto() !== null) {
                $this->serviceImageStorage->deleteImage($service->getPhoto());
            }

            $this->serviceImageStorage->saveImage($DTO->getPhoto());

            $this->serviceRepository->updateImage($DTO);
        }

        return $next($DTO);
    }
}
