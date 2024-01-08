<?php

namespace App\Repositories\Categories;

class CategoryStoreDTO
{
    public function __construct(
        protected int|null $parentId,
        protected string $title,
    ) {
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
    public function getTitle(): string
    {
        return $this->title;
    }
}
