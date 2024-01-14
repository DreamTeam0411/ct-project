<?php

namespace App\Repositories\Services\Iterators;

use App\Repositories\Categories\Iterators\PublicSubcategoryIterator;
use App\Repositories\Cities\Iterators\CityNameAndSlugIterator;
use App\Repositories\UserRepository\Iterators\BusinessIterator;

class PublicServiceIterator
{
    protected int $id;
    protected PublicSubcategoryIterator $category;
    protected string $title;
    protected string $description;
    protected string|null $photo;
    protected BusinessIterator $user;
    protected float $price;
    protected CityNameAndSlugIterator $city;
    protected string $createdAt;

    public function __construct(object $data)
    {
        $this->id           = $data->id;
        $this->category     = new PublicSubcategoryIterator($data->category);
        $this->title        = $data->title;
        $this->description  = $data->description;
        $this->photo        = $data->photo;
        $this->user         = new BusinessIterator($data->user);
        $this->price        = $data->price;
        $this->city         = new CityNameAndSlugIterator($data->city);
        $this->createdAt    = $data->createdAt;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return PublicSubcategoryIterator
     */
    public function getCategory(): PublicSubcategoryIterator
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
     * @return string|null
     */
    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    /**
     * @return BusinessIterator
     */
    public function getUser(): BusinessIterator
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
     * @return CityNameAndSlugIterator
     */
    public function getCity(): CityNameAndSlugIterator
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
}
