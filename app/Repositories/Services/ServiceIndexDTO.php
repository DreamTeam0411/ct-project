<?php

namespace App\Repositories\Services;

class ServiceIndexDTO
{
    public function __construct(
        protected ?string $category = null,
        protected ?string $city = null,
    ) {
    }

    /**
     * @return string|null
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }
}
