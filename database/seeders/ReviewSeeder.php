<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
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
        $this->query = DB::table('reviews');
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];

        $total = 2000;
        $batchSize = 200;

        for ($i = 0; $i < $total; $i+= $batchSize) {
            $data = [];

            for ($l = 0; $l < $batchSize; $l++) {
                $data[] = [
                    'user_id'       => 6,
                    'service_id'    => $this->faker->numberBetween(1, 100),
                    'description'   => $this->faker->paragraph(10),
                    'rating'        => $this->faker->numberBetween(3, 5),
                    'created_at'    => Carbon::now(),
                ];
            }

            DB::table('reviews')->insert($data);
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
