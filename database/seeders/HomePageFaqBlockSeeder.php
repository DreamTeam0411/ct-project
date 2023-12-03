<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HomePageFaqBlockSeeder extends Seeder
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
        $this->query = DB::table('home_page_faq_block');
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];

        for($i = 0; $i < 6; $i++) {
            $data[] = [
                'question'      => $this->faker->sentence,
                'answer'        => $this->faker->paragraph,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ];
        }

        foreach ($data as $block) {
            $this->query->insert($block);
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
