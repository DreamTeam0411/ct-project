<?php

namespace App\Repositories\HomePageHeaderBlock\Iterators;

class HomePageHeaderBlockIterator
{
    protected string $title;
    protected string $description;

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
