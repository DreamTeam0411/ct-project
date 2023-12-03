<?php

namespace App\Repositories\HomePageLogo\Iterators;

class HomePageLogoIterator
{
    protected string $logo;

    public function __construct(object $data)
    {
        $this->logo = $data->logo;
    }

    /**
     * @return string
     */
    public function getLogo(): string
    {
        return $this->logo;
    }
}
