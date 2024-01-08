<?php

namespace App\Repositories\Cities\Iterators;

use App\Repositories\Countries\Iterators\CountryIdAndNameIterator;

class PrivateCityIterator
{
    protected int $id;
    protected CountryIdAndNameIterator $country;
    protected int|null $parentId;
    protected string $name;
    protected string $slug;
    protected string $createdAt;
    protected string $updatedAt;

    public function __construct(object $data)
    {
        $this->id           = $data->id;
        $this->country      = new CountryIdAndNameIterator($data->country);
        $this->parentId     = $data->parentId;
        $this->name         = $data->name;
        $this->slug         = $data->slug;
        $this->createdAt    = $data->createdAt;
        $this->updatedAt    = $data->updatedAt;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return CountryIdAndNameIterator
     */
    public function getCountry(): CountryIdAndNameIterator
    {
        return $this->country;
    }

    /**
     * @return int|null
     */
    public function getParentId(): int|null
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

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }
}
