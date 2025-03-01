<?php

use App\Models\CaseItemDropRate;
use App\Models\GameCase;
use App\Models\GameItem;
use App\Models\Stats;
use App\Models\Unbox;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('home');
})->name('home');

Route::get('/unboxed', function () {
    $onlyCoverts = request()->query('onlyCoverts', false);

    // Moves these to be lazy so that unboxes could be fetched alone. Might not be needed
    return Inertia::render('unboxed', [
        'unboxes' => fn() => Unbox::limit(100)->with('case', 'item')
            ->when($onlyCoverts, function ($query) {
                $query->whereHas('item', function ($query) {
                    $query->whereIn('rarity', ['Covert', 'Extraordinary']);
                });
            })
            ->orderByDesc('created_at')
            ->get(),
        'totalUnboxes' => fn() => Stats::where('name', 'total_unboxes_all')->first()->value,
        'totalUnboxesCoverts' => fn() => Stats::where('name', 'total_unboxes_coverts')->first()->value,
        'totalUnboxesLast24Hours' => fn() => Unbox::where('created_at', '>=', now()->subDay())->count()
    ]);
})->name('unboxed');

// API
Route::group(['prefix' => 'api'], function () {
    Route::group(['prefix' => 'cases'], function () {
        Route::get('/', function () {
            $cases = GameCase::all();
            return response()->json($cases);
        });

        Route::get('{case}', function (GameCase $case) {
            return response()->json($case);
        });
    });

    Route::group(['prefix' => 'items'], function () {
        Route::get('/', function () {
            $items = GameItem::all();
            return response()->json($items);
        });

        Route::get('{item}', function (GameItem $item) {
            return response()->json($item);
        });
    });

    Route::group(['prefix' => 'unboxes'], function () {
        Route::get('/', function () {
            $unboxes = Unbox::with('case', 'item')->get();
            return response()->json($unboxes);
        });

        Route::get('{unbox}', function (Unbox $unbox) {
            return response()->json($unbox);
        });

        Route::get('from-case/{caseId}', function (string $caseId) {
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
            $unbox->save();

            // Increment Stats model
            Stats::where('name', 'total_unboxes_all')->increment('value');
            if ($caseItem->item->rarity === 'Covert' || $caseItem->item->rarity === 'Extraordinary') {
                Stats::where('name', 'total_unboxes_coverts')->increment('value');
            }

            return response()->json($unbox);
        });
    });
});
