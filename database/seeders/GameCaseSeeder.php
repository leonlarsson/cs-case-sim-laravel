<?php

namespace Database\Seeders;

use App\Models\GameCase;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class GameCaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $caseValidatorRules = [
            'id'          => 'required|string',
            'type'        => 'nullable|string',
            'name'        => 'required|string',
            'image'       => 'required|string',
            'description' => 'nullable|string',
        ];

        $cases = Http::get('https://bymykel.github.io/CSGO-API/api/en/crates.json')->json();

        // Validate data
        foreach ($cases as $case) {
            $caseValidator = validator($case, $caseValidatorRules);
            if ($caseValidator->fails()) {
                throw new \Exception($caseValidator->errors());
            }
        }

        // Prepare data
        $caseData = collect($cases)->map(function ($case) {
            return [
                'id'          => $case['id'],
                'type'        => $case['type'],
                'name'        => $case['name'],
                'image'       => $case['image'],
                'description' => $case['description'],
                'created_at'  => now(),
                'updated_at'  => now(),
            ];
        })->toArray();

        GameCase::insertOrIgnore($caseData);
    }
}
