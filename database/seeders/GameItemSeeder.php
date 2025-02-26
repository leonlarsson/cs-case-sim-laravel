<?php

namespace Database\Seeders;

use App\Models\GameItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class GameItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $itemValidatorRules = [
            'id'          => 'required|string',
            'name'        => 'required|string',
            'description' => 'nullable|string',
            'image'       => 'required|string',
            'rarity.name' => 'required|string',
            'phase'       => 'nullable|string',
        ];

        $items = Http::get('https://bymykel.github.io/CSGO-API/api/en/skins.json')->json();

        // Validate data
        foreach ($items as $item) {
            $itemValidator = validator($item, $itemValidatorRules);
            if ($itemValidator->fails()) {
                throw new \Exception($itemValidator->errors());
            }
        }

        // Prepare data with timestamps
        $itemData = collect($items)->map(function ($item) {
            return [
                'id'          => $item['id'],
                'name'        => $item['name'],
                'description' => $item['description'],
                'image'       => $item['image'],
                'rarity'      => $item['rarity']['name'],
                'phase'       => $item['phase'] ?? null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ];
        })->toArray();

        GameItem::insertOrIgnore($itemData);
    }
}
