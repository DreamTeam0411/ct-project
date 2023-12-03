<?php

namespace App\Repositories\Services;

use App\Repositories\Services\Iterators\TitlePageServiceIterator;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class ServiceRepository
{
    protected Builder $query;

    public function __construct()
    {
        $this->query = DB::table('services');
    }

    public function getServicesForTitlePage()
    {
        $collection = $this->query->select(
            DB::raw('services.id, services.title, services.description, AVG(reviews.rating) as rating')
        )->join(
            'reviews',
            'services.id',
            '=',
            'reviews.service_id'
        )->groupBy('services.id')
            ->take(4)->get();

        return $collection->map(function ($data) {
            return new TitlePageServiceIterator($data);
        });
    }
}
