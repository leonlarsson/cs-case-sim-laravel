<?php

namespace Database\Seeders;

use App\Models\CaseItemDropRate;
use Exception;
use Illuminate\Database\Seeder;

class CaseItemDropRatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $jsonPathCases = storage_path('app/private/cases.json');
        $jsonPathSouvenirCases = storage_path('app/private/souvenir-cases.json');

        if (!file_exists($jsonPathCases) || !file_exists($jsonPathSouvenirCases)) {
            throw new Exception("JSON file not found at: $jsonPathCases or $jsonPathSouvenirCases");
        }

        $cases = json_decode(file_get_contents($jsonPathCases), true);
        $souvenirCases = json_decode(file_get_contents($jsonPathSouvenirCases), true);
        $cases = array_merge($cases, $souvenirCases);

        if (!$cases) {
            throw new Exception("Invalid JSON format.");
        }

        // Define drop rates - taken from https://www.csgo.com.cn/news/gamebroad/20170911/206155.shtml
        $caseGradeOdds = [
            "Mil-Spec Grade" => 0.79923,
            "Restricted"     => 0.15985,
            "Classified"     => 0.03197,
            "Covert"         => 0.00639,
            "Rare Special Item" => 0.00256,
        ];

        $souvenirCaseGradeOdds = [
            "Consumer Grade" => 0.79872,
            "Industrial Grade" => 0.15974,
            "Mil-Spec Grade" => 0.03328,
            "Restricted" => 0.00666,
            "Classified" => 0.00133,
            "Covert" => 0.00027,
        ];

        $insertData = [];

        foreach ($cases as $case) {
            $caseId = $case['id'];
            $caseGradeOdds = $case['type'] === 'Case' ? $caseGradeOdds : $souvenirCaseGradeOdds;

            foreach ($case['contains'] as $caseItem) {
                $itemRarity = $caseItem['rarity']['name'] ?? null;
                $caseItemDropRate = $caseGradeOdds[$itemRarity] ?? 0;

                $insertData[] = [
                    'case_id'    => $caseId,
                    'item_id'    => $caseItem['id'],
                    'item_drop_rate'  => $caseItemDropRate,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            if ($case['type'] === 'Case') {
                foreach ($case['contains_rare'] as $caseItem) {
                    $caseItemDropRate = $caseGradeOdds["Rare Special Item"]; // Use the rare special item rate

                    $insertData[] = [
                        'case_id'    => $caseId,
                        'item_id'    => $caseItem['id'],
                        'item_drop_rate'  => $caseItemDropRate,
                    ];
                }
            }
        }

        // Insert case item drop rate, or update item_drop_rate if it already exists
        CaseItemDropRate::upsert($insertData, ['case_id', 'item_id'], ['item_drop_rate']);
    }
}
