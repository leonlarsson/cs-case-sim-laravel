<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseItemDropRate extends Model
{
    public function case()
    {
        return $this->belongsTo(GameCase::class);
    }

    public function item()
    {
        return $this->belongsTo(GameItem::class);
    }

    public static function getRandomItemByDropRate(string $caseId)
    {
        // Get all items and their drop rates for this case
        $caseItems = self::where('case_id', $caseId)
            ->with(['case', 'item'])
            ->get();

        if ($caseItems->isEmpty()) {
            return null;
        }

        // Construct weighted array for selection
        $weightedItems = [];
        $totalWeight = 0;

        foreach ($caseItems as $caseItem) {
            $dropRate = (float)$caseItem->item_drop_rate; // Ensure float consistency
            $totalWeight += $dropRate;
            $weightedItems[] = ['item' => $caseItem, 'weight' => $dropRate];
        }

        // Generate a random number within the total weight
        $random = mt_rand() / mt_getrandmax() * $totalWeight;

        // Select an item based on weighted probability
        $cumulativeWeight = 0;
        foreach ($weightedItems as $entry) {
            $cumulativeWeight += $entry['weight'];
            if ($random <= $cumulativeWeight) {
                return $entry['item'];
            }
        }

        // Should never reach here, but return the first item in case of precision errors
        return $weightedItems[array_key_first($weightedItems)]['item'];
    }

    // public static function getRandomItemByDropRate(string $caseId)
    // {
    //     // Get all items and their drop rates for this case
    //     $caseItems = self::where('case_id', $caseId)
    //         ->with(['case', 'item'])
    //         ->get();

    //     if ($caseItems->isEmpty()) {
    //         return null;
    //     }

    //     // Group items by drop rate
    //     $itemsByRate = [];
    //     $uniqueRates = [];

    //     foreach ($caseItems as $caseItem) {
    //         $rate = (string)$caseItem->item_drop_rate; // Convert to string for consistent array keys

    //         if (!isset($uniqueRates[$rate])) {
    //             $uniqueRates[$rate] = $caseItem->item_drop_rate;
    //         }

    //         $itemsByRate[$rate][] = $caseItem;
    //     }

    //     // Calculate the sum of distinct drop rates
    //     $totalDistinctDropRate = array_sum($uniqueRates);

    //     // Generate a random number between 0 and the total distinct drop rate
    //     $random = (float)mt_rand() / mt_getrandmax() * $totalDistinctDropRate;

    //     // Iterate through unique rates and find which rate group contains our random value
    //     $cumulativeProbability = 0;
    //     foreach ($uniqueRates as $rate => $probability) {
    //         $cumulativeProbability += $probability;

    //         if ($random <= $cumulativeProbability) {
    //             // Randomly select one item from this rate group
    //             $itemsInGroup = $itemsByRate[$rate];
    //             return $itemsInGroup[array_rand($itemsInGroup)];
    //         }
    //     }

    //     // Fallback in case of rounding errors
    //     $lastRateKey = array_key_last($itemsByRate);
    //     $lastRateItems = $itemsByRate[$lastRateKey];
    //     return $lastRateItems[array_rand($lastRateItems)];
    // }
}
