<?php

namespace App\Http\Controllers;

use App\Models\CaseItemDropRate;
use App\Models\Stats;
use App\Models\Unbox;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class UnboxController extends Controller
{
    public function renderUnboxedPage(Request $request)
    {
        $onlyCoverts = $request->query('onlyCoverts', false);

        return Inertia::render('unboxed', [
            'unboxes' => fn() => Unbox::limit(100)->with('case', 'item')
                ->when($onlyCoverts, function ($query) {
                    $query->whereHas('item', function ($query) {
                        $query->whereIn('rarity', ['Covert', 'Extraordinary']);
                    });
                })
                ->orderByDesc('created_at')
                ->get(),
            'stats' => fn() => [
                'totalUnboxes' => Stats::where('name', 'total_unboxes_all')->first()->value,
                'totalUnboxesCoverts' => Stats::where('name', 'total_unboxes_coverts')->first()->value,
                'totalUnboxesLast24Hours' => Unbox::where('created_at', '>=', now()->subDay())->count()
            ],
        ]);
    }

    public function getUnboxById(Request $request, Unbox $unbox)
    {
        return response()->json($unbox);
    }

    public function unboxItemFromCase(Request $request, string $caseId)
    {
        $caseItem = CaseItemDropRate::getRandomItemByDropRate($caseId);

        if (!$caseItem) {
            return response()->json(['error' => 'No item could be retrieved.'], 404);
        }

        $itemIsStatTrak = $caseItem->item->rarity !== "Extraordinary" && $caseItem->case->type !== "Souvenir" && fake()->boolean(10);

        $unbox = new Unbox();
        $unbox->case_id = $caseItem->case_id;
        $unbox->item_id = $caseItem->item_id;
        $unbox->is_stat_trak = $itemIsStatTrak;
        $unbox->unboxer_id = fake()->uuid();
        $unbox->setRelation('case', $caseItem->case);
        $unbox->setRelation('item', $caseItem->item);
        $unbox->save();

        // Increment Stats model
        dispatch(function () use ($caseItem) {
            DB::transaction(function () use ($caseItem) {
                Stats::where('name', 'total_unboxes_all')->increment('value');
                if ($caseItem->item->rarity === 'Covert' || $caseItem->item->rarity === 'Extraordinary') {
                    Stats::where('name', 'total_unboxes_coverts')->increment('value');
                }
            });
        })->afterResponse();

        return response()->json($unbox);
    }
}
