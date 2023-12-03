<?php

namespace App\Services\HomePage\Iterators;

use App\Repositories\Categories\Iterators\HomePageCategoryCollectionIterator;
use App\Repositories\HomePageFooter\Iterators\HomePageFooterBlockIterator;
use App\Repositories\HomePageHeaderBlock\Iterators\HomePageHeaderBlockIterator;
use App\Repositories\HomePageCategories\Iterators\HomePageCategoriesBlockIterator;
use Illuminate\Support\Collection;

class HomePageIterator
{
    protected string $logo;
    protected Collection $links;
    protected HomePageHeaderBlockIterator $header;
    protected HomePageCategoriesBlockIterator $categoriesBlock;
    protected HomePageCategoryCollectionIterator $categoriesContent;
    protected Collection $aboutUsBlock;
    protected HomePageFooterBlockIterator $footerBlock;
    protected Collection $socialMedia;

    public function __construct(object $data)
    {
        $this->logo                 = $data->logo;
        $this->links                = $data->links;
        $this->header               = $data->header;
        $this->categoriesBlock      = $data->categoriesBlock;
        $this->categoriesContent    = $data->categoriesContent;
        $this->aboutUsBlock         = $data->aboutUsBlock;
        $this->footerBlock          = $data->footerBlock;
        $this->socialMedia          = $data->socialMedia;
    }

    /**
     * @return string
     */
    public function getLogo(): string
    {
        return $this->logo;
    }

    public function getLinks(): Collection
    {
        return $this->links;
    }

    public function getHeader(): HomePageHeaderBlockIterator
    {
        return $this->header;
    }

    public function getCategoriesBlock(): HomePageCategoriesBlockIterator
    {
        return $this->categoriesBlock;
    }

    public function getCategoriesContent(): HomePageCategoryCollectionIterator
    {
        return $this->categoriesContent;
    }

    /**
     * @return Collection
     */
    public function getAboutUsBlock(): Collection
    {
        return $this->aboutUsBlock;
    }

    /**
     * @return HomePageFooterBlockIterator
     */
    public function getFooterBlock(): HomePageFooterBlockIterator
    {
        return $this->footerBlock;
    }

    /**
     * @return Collection
     */
    public function getSocialMedia(): Collection
    {
        return $this->socialMedia;
    }
}
