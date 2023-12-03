<?php

namespace App\Repositories\HomePageFooter\Iterators;

class HomePageFooterBlockIterator
{
    protected string $description;

    public function __construct(object $data)
    {
        $this->description = $data->description;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
}
