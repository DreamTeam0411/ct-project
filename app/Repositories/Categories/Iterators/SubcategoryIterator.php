<?php

namespace App\Repositories\Categories\Iterators;

class SubcategoryIterator
{
    protected int $id;
    protected string $title;
    protected string $slug;

    public function __construct(object $data)
    {
        $this->id       = $data->id;
        $this->title    = $data->title;
        $this->slug     = $data->slug;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
}
