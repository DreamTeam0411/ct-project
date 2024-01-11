<?php

namespace App\Services\Service;

use App\Repositories\Services\Iterators\PrivateServiceIterator;
use App\Repositories\Services\ServiceRepository;
use App\Repositories\Services\AdminServiceStoreDTO;
use App\Repositories\Services\ServiceUpdateDTO;
use Exception;
use Illuminate\Support\Collection;

class ServiceService
{
    /**
     * @param ServiceRepository $serviceRepository
     */
    public function __construct(
        protected ServiceRepository $serviceRepository,
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
     * @param AdminServiceStoreDTO $DTO
     * @return PrivateServiceIterator
     */
    public function insertAndGetService(AdminServiceStoreDTO $DTO): PrivateServiceIterator
    {
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
     * @param ServiceUpdateDTO $DTO
     * @return PrivateServiceIterator
     */
    public function updateAndGetById(ServiceUpdateDTO $DTO): PrivateServiceIterator
    {
        $this->serviceRepository->updatePrivateService($DTO);

        return $this->serviceRepository->getById($DTO->getId());
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
