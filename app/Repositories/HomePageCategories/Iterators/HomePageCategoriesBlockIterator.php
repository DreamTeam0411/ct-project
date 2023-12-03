<?php

namespace App\Repositories\HomePageCategories\Iterators;

class HomePageCategoriesBlockIterator
{
    protected string $title;
    protected string $description;

    /**
     * @param object $data
     */
    public function __construct(object $data)
    {
        $this->title        = $data->title;
        $this->description  = $data->description;
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
}
