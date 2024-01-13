<?php

namespace App\Services\HomePage;

use App\Repositories\Categories\Iterators\HomePageCategoryCollectionIterator;
use App\Repositories\HomePageCategories\Iterators\HomePageCategoriesBlockIterator;
use App\Repositories\HomePageFooter\Iterators\HomePageFooterBlockIterator;
use App\Repositories\HomePageHeaderBlock\Iterators\HomePageHeaderBlockIterator;
use Illuminate\Support\Collection;

class HomePageDTO
{
    protected string $logo;
    protected Collection $links;
    protected HomePageHeaderBlockIterator $header;
    protected HomePageCategoriesBlockIterator $categoriesBlock;
    protected HomePageCategoryCollectionIterator $categoriesContent;
    protected Collection $aboutUsBlock;
    protected HomePageFooterBlockIterator $footerBlock;
    protected Collection $socialMedia;

    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function getLogo(): string
    {
        return $this->logo;
    }

    /**
     * @param string $logo
     */
    public function setLogo(string $logo): void
    {
        $this->logo = $logo;
    }

    /**
     * @return Collection
     */
    public function getLinks(): Collection
    {
        return $this->links;
    }

    /**
     * @param Collection $links
     */
    public function setLinks(Collection $links): void
    {
        $this->links = $links;
    }

    /**
     * @return HomePageHeaderBlockIterator
     */
    public function getHeader(): HomePageHeaderBlockIterator
    {
        return $this->header;
    }

    /**
     * @param HomePageHeaderBlockIterator $header
     */
    public function setHeader(HomePageHeaderBlockIterator $header): void
    {
        $this->header = $header;
    }

    /**
     * @return HomePageCategoriesBlockIterator
     */
    public function getCategoriesBlock(): HomePageCategoriesBlockIterator
    {
        return $this->categoriesBlock;
    }

    /**
     * @param HomePageCategoriesBlockIterator $categoriesBlock
     */
    public function setCategoriesBlock(HomePageCategoriesBlockIterator $categoriesBlock): void
    {
        $this->categoriesBlock = $categoriesBlock;
    }

    /**
     * @return HomePageCategoryCollectionIterator
     */
    public function getCategoriesContent(): HomePageCategoryCollectionIterator
    {
        return $this->categoriesContent;
    }

    /**
     * @param HomePageCategoryCollectionIterator $categoriesContent
     */
    public function setCategoriesContent(HomePageCategoryCollectionIterator $categoriesContent): void
    {
        $this->categoriesContent = $categoriesContent;
    }

    /**
     * @return Collection
     */
    public function getAboutUsBlock(): Collection
    {
        return $this->aboutUsBlock;
    }

    /**
     * @param Collection $aboutUsBlock
     */
    public function setAboutUsBlock(Collection $aboutUsBlock): void
    {
        $this->aboutUsBlock = $aboutUsBlock;
    }

    /**
     * @return HomePageFooterBlockIterator
     */
    public function getFooterBlock(): HomePageFooterBlockIterator
    {
        return $this->footerBlock;
    }

    /**
     * @param HomePageFooterBlockIterator $footerBlock
     */
    public function setFooterBlock(HomePageFooterBlockIterator $footerBlock): void
    {
        $this->footerBlock = $footerBlock;
    }

    /**
     * @return Collection
     */
    public function getSocialMedia(): Collection
    {
        return $this->socialMedia;
    }

    /**
     * @param Collection $socialMedia
     */
    public function setSocialMedia(Collection $socialMedia): void
    {
        $this->socialMedia = $socialMedia;
    }
}
