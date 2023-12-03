<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CitySeeder extends Seeder
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
        $this->query = DB::table('cities');
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'Kyiv',
            'Vinnytsya',
            'Dnipro',
            'Kharkiv',
            'Lviv',
            'Zhytomyr',
        ];

        foreach ($data as $city) {
            $this->query->insert([
                'country_id' => 1,
                'parent_id' => null,
                'name' => $city,
                'slug' => Str::slug('Ukraine ' . $city),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
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
