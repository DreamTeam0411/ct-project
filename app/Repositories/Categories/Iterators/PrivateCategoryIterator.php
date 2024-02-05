<?php

namespace App\Repositories\Categories\Iterators;

use App\Repositories\UserRepository\Iterators\SupportIterator;

class PrivateCategoryIterator
{
    protected int $id;
    protected int|null $parentId;
    protected string $icon;
    protected string $title;
    protected string $slug;
    protected SupportIterator $createdBy;
    protected SupportIterator $updatedBy;
    protected string $createdAt;
    protected string $updatedAt;

    /**
     * @param object $data
     */
    public function __construct(object $data)
    {
        $this->id           = $data->id;
        $this->parentId     = $data->parent_id;
        $this->icon         = $data->icon;
        $this->title        = $data->title;
        $this->slug         = $data->slug;
        $this->createdBy    = new SupportIterator($data->createdBy);
        $this->updatedBy    = new SupportIterator($data->updatedBy);
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
     * @return int|null
     */
    public function getParentId(): ?int
    {
        return $this->parentId;
    }

    public function getIcon(): string
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

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return SupportIterator
     */
    public function getCreatedBy(): SupportIterator
    {
        return $this->createdBy;
    }

    /**
     * @return SupportIterator
     */
    public function getUpdatedBy(): SupportIterator
    {
        return $this->updatedBy;
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
