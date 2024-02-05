<?php

namespace App\Repositories\Categories;

use Illuminate\Http\UploadedFile;

class CategoryUpdateDTO
{
    public function __construct(
        protected int $id,
        protected int|null $parentId,
        protected string $title,
        protected UploadedFile|null $icon = null,
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

    /**
     * @return UploadedFile|null
     */
    public function getIcon(): ?UploadedFile
    {
        return $this->icon;
    }
}
