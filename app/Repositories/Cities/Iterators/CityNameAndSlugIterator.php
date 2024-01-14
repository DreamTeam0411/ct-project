<?php

namespace App\Repositories\Cities\Iterators;

class CityNameAndSlugIterator
{
    protected string $name;
    protected string $slug;

    public function __construct(object $data)
    {
        $this->name = $data->name;
        $this->slug = $data->slug;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }
}
