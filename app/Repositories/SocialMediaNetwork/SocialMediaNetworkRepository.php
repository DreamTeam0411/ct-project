<?php

namespace App\Repositories\SocialMediaNetwork;

use App\Repositories\SocialMediaNetwork\Iterators\HomePageSocialMediaNetworkIterator;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SocialMediaNetworkRepository
{
    protected Builder $query;

    public function __construct()
    {
        $this->query = DB::table('social_media_networks');
    }

    public function getHomePageSocialMediaNetworks(): Collection
    {
        $collection = $this->query->select([
            'title',
            'link',
            'icon',
        ])->get();

        return $collection->map(function ($link) {
            return new HomePageSocialMediaNetworkIterator($link);
        });
    }
}
