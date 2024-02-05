<?php

namespace App\Repositories\Services;

use Illuminate\Http\UploadedFile;

class ServiceUpdateDTO
{
    public function __construct(
        protected int $id,
        protected int $categoryId,
        protected string $title,
        protected string $description,
        protected int $userId,
        protected float $price,
        protected int $cityId,
        protected UploadedFile|null $photo = null,
    ) {
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->categoryId;
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
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return int
     */
    public function getCityId(): int
    {
        return $this->cityId;
    }

    /**
     * @return UploadedFile|null
     */
    public function getPhoto(): ?UploadedFile
    {
        return $this->photo;
    }
}
