<?php

namespace Database\Seeders;

use App\Models\Unbox;
use Illuminate\Database\Seeder;

class UnboxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Unbox::factory()
            ->count(1337)
            ->create();
    }
}
