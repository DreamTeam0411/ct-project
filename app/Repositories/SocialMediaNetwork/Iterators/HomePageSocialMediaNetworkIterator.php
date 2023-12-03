<?php

namespace App\Repositories\SocialMediaNetwork\Iterators;

class HomePageSocialMediaNetworkIterator
{
    protected string $title;
    protected string $link;
    protected string $icon;

    public function __construct(object $data)
    {
        $this->title    = $data->title;
        $this->link     = $data->link;
        $this->icon     = $data->icon;
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

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }
}
