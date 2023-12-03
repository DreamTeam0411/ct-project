<?php

namespace App\Repositories\HomePageLinks\Iterators;

class HomePageLinksIterator
{
    protected string $title;
    protected string $link;

    /**
     * @param object $data
     */
    public function __construct(object $data)
    {
        $this->title    = $data->title;
        $this->link     = $data->link;
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
    public function getLink(): string
    {
        return $this->link;
    }
}
