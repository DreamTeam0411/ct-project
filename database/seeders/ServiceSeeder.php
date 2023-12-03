<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
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
        $this->query = DB::table('services');
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];

        for ($i=0; $i < 100; $i++) {
            $data[] = [
                'category_id'   => rand(9, 48),
                'title'         => 'Lorem Ipsum',
                'description'   => $this->faker->paragraph,
                'user_id'       => 6,
                'price'         => rand(400, 10000),
                'city_id'       => rand(1, 6),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ];
        }

        foreach ($data as $service) {
            $this->query->insert($service);
        }
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
