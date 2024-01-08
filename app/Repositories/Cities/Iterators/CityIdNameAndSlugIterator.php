<?php

namespace App\Repositories\Cities\Iterators;

class CityIdNameAndSlugIterator
{
    protected int $id;
    protected string $name;
    protected string $slug;

    public function __construct(object $data)
    {
        $this->id   = $data->id;
        $this->name = $data->name;
        $this->slug = $data->slug;
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
