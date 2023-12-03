<?php

namespace App\Repositories\Categories\Iterators;

class PublicSubcategoryIterator
{
    protected string $title;
    protected string $slug;

    public function __construct(object $data)
    {
        $this->title    = $data->title;
        $this->slug     = $data->slug;
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
