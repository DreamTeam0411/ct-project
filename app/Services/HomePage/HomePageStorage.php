<?php

namespace App\Services\HomePage;

use App\Services\HomePage\Iterators\HomePageIterator;
use Illuminate\Support\Facades\Cache;

class HomePageStorage
{
    private const KEY = 'home-page';
    private const SECONDS = 300;

    public function get(): mixed
    {
        return Cache::get(self::KEY);
    }

    public function set(HomePageIterator $iterator): void
    {
        Cache::set(self::KEY, $iterator, self::SECONDS);
    }
}
