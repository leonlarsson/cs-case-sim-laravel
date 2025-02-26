<?php

namespace Database\Seeders;

use App\Models\Stats;
use Illuminate\Database\Seeder;

class StatsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Stats::insert([
            [
                'name' => 'total_unboxes_all',
                'value' => 53550979,
            ],
            [
                'name' => 'total_unboxes_coverts',
                'value' => 448059,
            ],
        ]);
    }
}
