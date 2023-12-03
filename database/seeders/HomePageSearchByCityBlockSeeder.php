<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HomePageSearchByCityBlockSeeder extends Seeder
{
    /**
     * @var Generator
     */
    protected Generator $faker;
    protected Builder $query;

    /**
     * @throws BindingResolutionException
     */
    public function __construct()
    {
        $this->faker = $this->withFaker();
        $this->query = DB::table('home_page_search_by_city_block');
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'title'         => 'Search by cities',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ];

        $this->query->insert($data);
    }

    /**
     * @return Generator
     * @throws BindingResolutionException
     */
    protected function withFaker(): Generator
    {
        return Container::getInstance()->make(Generator::class);
    }
}
