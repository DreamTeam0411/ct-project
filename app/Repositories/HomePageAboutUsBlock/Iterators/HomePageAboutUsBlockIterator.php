<?php

namespace App\Repositories\HomePageAboutUsBlock\Iterators;

class HomePageAboutUsBlockIterator
{
    protected string $title;
    protected string $description;
    protected string $image;

    /**
     * @param object $data
     */
    public function __construct(object $data)
    {
        $this->title        = $data->title;
        $this->description  = $data->description;
        $this->image        = $data->image;
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
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }
}
