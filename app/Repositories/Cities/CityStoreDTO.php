<?php

namespace App\Repositories\Cities;

class CityStoreDTO
{
    public function __construct(
        protected int $countryId,
        protected int|null $parentId,
        protected string $name,
    ) {
    }

    /**
     * @return int
     */
    public function getCountryId(): int
    {
        return $this->countryId;
    }

    /**
     * @return int|null
     */
    public function getParentId(): ?int
    {
        return $this->parentId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
