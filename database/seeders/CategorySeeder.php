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

class CategorySeeder extends Seeder
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
        $this->query = DB::table('categories');
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        $counter = 0;
        $parentId = 0;
        $incr = 1;

        for ($i=0; $i < 48; $i++) {
            $title = 'Cat' . $incr++;

            $data[] = [
                'parent_id'     => null,
                'icon'          => 'default.svg',
                'title'         => $title,
                'slug'          => Str::slug($title),
                'created_by'    => 5,
                'updated_by'    => 5,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ];

            if ($i >= 8 && ($counter % 5) === 0) {
                $parentId++;
            }

            if ($i >= 8) {
                $data[$i]['parent_id'] = $parentId;
                $counter++;
            }
        }

        foreach ($data as $category) {
            $this->query->insert($category);
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
