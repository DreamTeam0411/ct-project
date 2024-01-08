<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
//            CategorySeeder::class,
//            CountrySeeder::class,
//            CitySeeder::class,
//            ServiceSeeder::class,
//            ReviewSeeder::class,
//            HomePageAboutUsBlockSeeder::class,
//            HomePageFaqBlockSeeder::class,
//            HomePageFooterBlockSeeder::class,
//            SocialMediaNetworkSeeder::class,
//            HomePageHeaderBlockSeeder::class,
//            HomePageLogoSeeder::class,
//            HomePageLinksSeeder::class,
//            HomePageSearchByCityBlockSeeder::class,
//            HomePageCategoriesBlockSeeder::class,
            RoleSeeder::class,
        ]);
    }
}
