<?php

namespace App\Repositories\Categories;

use Illuminate\Http\UploadedFile;

class CategoryStoreDTO
{
    public function __construct(
        protected int|null $parentId,
        protected UploadedFile $icon,
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
     * @return UploadedFile
     */
    public function getIcon(): UploadedFile
    {
        return $this->icon;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }
}
