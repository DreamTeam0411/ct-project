<?php

namespace App\Repositories\Services\Iterators;

use App\Repositories\Categories\Iterators\PrivateSubcategoryIterator;
use App\Repositories\Cities\Iterators\CityIdNameAndSlugIterator;
use App\Repositories\UserRepository\Iterators\SupportIterator;

class PrivateServiceIterator
{
    protected int $id;
    protected PrivateSubcategoryIterator $category;
    protected string $title;
    protected string $description;
    protected SupportIterator $user;
    protected float $price;
    protected CityIdNameAndSlugIterator $city;
    protected string $createdAt;
    protected string $updatedAt;

    public function __construct(object $data)
    {
        $this->id           = $data->id;
        $this->category     = new PrivateSubcategoryIterator($data->category);
        $this->title        = $data->title;
        $this->description  = $data->description;
        $this->user         = new SupportIterator($data->user);
        $this->price        = $data->price;
        $this->city         = new CityIdNameAndSlugIterator($data->city);
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
     * @return PrivateSubcategoryIterator
     */
    public function getCategory(): PrivateSubcategoryIterator
    {
        return $this->category;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return SupportIterator
     */
    public function getUser(): SupportIterator
    {
        return $this->user;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return CityIdNameAndSlugIterator
     */
    public function getCity(): CityIdNameAndSlugIterator
    {
        return $this->city;
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
