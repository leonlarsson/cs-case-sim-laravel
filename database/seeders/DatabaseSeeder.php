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
        // Seed cases and items
        $this->call([
            GameCaseSeeder::class,
            GameItemSeeder::class,
            CaseItemDropRatesSeeder::class,
            StatsSeeder::class,
        ]);
    }
}
