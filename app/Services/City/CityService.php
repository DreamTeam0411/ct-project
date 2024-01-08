<?php

namespace App\Services\City;

use App\Repositories\Cities\CityRepository;
use App\Repositories\Cities\CityStoreDTO;
use App\Repositories\Cities\CityUpdateDTO;
use App\Repositories\Cities\Iterators\PrivateCityIterator;
use Illuminate\Support\Collection;

class CityService
{
    /**
     * @param CityRepository $cityRepository
     */
    public function __construct(
        protected CityRepository $cityRepository,
    ) {
    }

    /**
     * @param int $lastId
     * @return Collection
     */
    public function getAllCitiesByLastId(int $lastId = 0): Collection
    {
        return $this->cityRepository->getAllPrivateCities($lastId);
    }

    /**
     * @param CityStoreDTO $DTO
     * @return PrivateCityIterator
     */
    public function insertAndGetCity(CityStoreDTO $DTO): PrivateCityIterator
    {
        $cityId = $this->cityRepository->insertAndGetId($DTO);

        return $this->cityRepository->getById($cityId);
    }

    /**
     * @param int $id
     * @return PrivateCityIterator
     */
    public function getById(int $id): PrivateCityIterator
    {
        return $this->cityRepository->getById($id);
    }

    /**
     * @param CityUpdateDTO $DTO
     * @return PrivateCityIterator
     */
    public function update(CityUpdateDTO $DTO): PrivateCityIterator
    {
        $this->cityRepository->update($DTO);

        return $this->cityRepository->getById($DTO->getId());
    }

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        $this->cityRepository->delete($id);
    }
}
