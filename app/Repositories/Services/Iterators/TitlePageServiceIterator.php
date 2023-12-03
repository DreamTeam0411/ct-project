<?php

namespace App\Repositories\Services\Iterators;

class TitlePageServiceIterator
{
    protected int $id;
    protected string $title;
    protected string $description;
    protected float $rating;

    /**
     * @param object $data
     */
    public function __construct(object $data)
    {
        $this->id           = $data->id;
        $this->title        = $data->title;
        $this->description  = $data->description;
        $this->rating       = $data->rating;
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
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return float
     */
    public function getRating(): float
    {
        return number_format($this->rating, 2);
    }
}
