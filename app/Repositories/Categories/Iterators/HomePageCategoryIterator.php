<?php

namespace App\Repositories\Categories\Iterators;

class HomePageCategoryIterator
{
    protected string $title;
    protected string $icon;
    protected string $slug;
    protected HomePageSubcategoryIterator $subcategories;
    public function __construct(object $data)
    {
        $this->title            = $data->title;
        $this->icon             = $data->icon;
        $this->slug             = $data->slug;
        $this->subcategories    = new HomePageSubcategoryIterator($data->subcategories);
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
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return HomePageSubcategoryIterator
     */
    public function getSubcategories(): HomePageSubcategoryIterator
    {
        return $this->subcategories;
    }
}
