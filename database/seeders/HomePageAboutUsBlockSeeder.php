<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HomePageAboutUsBlockSeeder extends Seeder
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
        $this->query = DB::table('home_page_about_us_block');
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        $counter = 1;

        for ($i = 0; $i < 2; $i++) {
            $data[] = [
                'title' => $this->faker->sentence,
                'description' => $this->faker->paragraph(6),
                'image' => 'aboutUs0' . $counter . '.svg',
                'position' => $counter++,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        foreach ($data as $aboutUs) {
            $this->query->insert($aboutUs);
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
