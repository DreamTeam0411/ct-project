<?php

namespace App\Services\Service;

use App\Repositories\Services\Iterators\PrivateServiceIterator;
use App\Repositories\Services\Iterators\PublicServiceIterator;
use App\Repositories\Services\ServiceIndexDTO;
use App\Repositories\Services\ServiceRepository;
use App\Repositories\Services\AdminServiceStoreDTO;
use App\Repositories\Services\ServiceUpdateDTO;
use Illuminate\Support\Collection;

class ServiceService
{
    /**
     * @param ServiceRepository $serviceRepository
     * @param ServiceImageStorage $serviceImageStorage
     */
    public function __construct(
        protected ServiceRepository $serviceRepository,
        protected ServiceImageStorage $serviceImageStorage,
    ) {
    }

    /**
     * @param int $lastId
     * @return Collection
     */
    public function getPrivateServices(int $lastId): Collection
    {
        return $this->serviceRepository->getPrivateServices($lastId);
    }

    /**
     * @param ServiceIndexDTO $DTO
     * @param int $lastId
     * @return Collection<PublicServiceIterator>
     */
    public function getPublicServices(
        ServiceIndexDTO $DTO,
        int $lastId = 0,
    ): Collection {
        $this->serviceRepository->getPublicServices($lastId);

        if (is_null($DTO->getCategory()) === false) {
            $this->serviceRepository->queryCategorySlug($DTO->getCategory());
        }

        if (is_null($DTO->getCity()) === false) {
            $this->serviceRepository->queryCitySlug($DTO->getCity());
        }

        return $this->serviceRepository->getPublicServicesWithParams();
    }

    /**
     * @param AdminServiceStoreDTO $DTO
     * @return PrivateServiceIterator
     */
    public function insertAndGetService(AdminServiceStoreDTO $DTO): PrivateServiceIterator
    {
        $this->serviceImageStorage->saveImage($DTO->getPhoto());

        $serviceId = $this->serviceRepository->insertAndGetId($DTO);

        return $this->serviceRepository->getById($serviceId);
    }

    /**
     * @param int $id
     * @return PrivateServiceIterator
     */
    public function getById(int $id): PrivateServiceIterator
    {
        return $this->serviceRepository->getById($id);
    }

    /**
     * @param int $id
     * @return void
     */
    public function deleteById(int $id): void
    {
        $this->serviceRepository->deleteById($id);
    }
}
