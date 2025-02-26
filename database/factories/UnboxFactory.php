<?php

namespace Database\Factories;

use App\Models\GameCase;
use App\Models\GameItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Unbox>
 */
class UnboxFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $caseId = GameCase::inRandomOrder()->first()->id;
        $itemId = GameItem::inRandomOrder()->first()->id;

        return [
            'case_id' => $caseId,
            'item_id' => $itemId,
            'is_stat_trak' => fake()->boolean(),
            'unboxer_id' => fake()->uuid(),
        ];
    }
}
