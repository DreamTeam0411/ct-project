<?php

namespace App\Services\Service;

use App\Enums\Role;
use App\Repositories\RoleUser\RoleUserRepository;
use App\Repositories\Services\Iterators\PrivateServiceIterator;
use App\Repositories\Services\Iterators\PublicServiceIterator;
use App\Repositories\Services\ServiceIndexDTO;
use App\Repositories\Services\ServiceRepository;
use App\Repositories\Services\AdminServiceStoreDTO;
use App\Repositories\Services\ServiceUpdateDTO;
use App\Repositories\UserRepository\UserRepository;
use Illuminate\Support\Collection;

class ServiceService
{
    /**
     * @param ServiceRepository $serviceRepository
     * @param ServiceImageStorage $serviceImageStorage
     * @param UserRepository $userRepository
     * @param RoleUserRepository $roleUserRepository
     */
    public function __construct(
        protected ServiceRepository $serviceRepository,
        protected ServiceImageStorage $serviceImageStorage,
        protected UserRepository $userRepository,
        protected RoleUserRepository $roleUserRepository,
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

        $userId = $this->userRepository->createMaster($DTO);
        $DTO->setUserId($userId);

        $this->roleUserRepository->setRole($DTO->getUserId(), Role::IS_BUSINESS);

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
