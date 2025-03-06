<?php

use App\Http\Controllers\GameCaseController;
use App\Http\Controllers\GameItemController;
use App\Http\Controllers\UnboxController;
use App\Models\CaseItemDropRate;
use App\Models\Stats;
use App\Models\Unbox;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('home');
})->name('home');

Route::get('/unboxed', [UnboxController::class, "renderUnboxedPage"])->name('unboxed');

// API
Route::group(['prefix' => 'api'], function () {
    // Route::group(['prefix' => 'cases'], function () {
    //     Route::get('/', [GameCaseController::class, 'listCases']);
    //     Route::get('{case}', [GameCaseController::class, 'getCaseById']);
    // });

    // Route::group(['prefix' => 'items'], function () {
    //     Route::get('/', [GameItemController::class, 'listItems']);
    //     Route::get('{item}', [GameItemController::class, 'getItemById']);
    // });

    Route::group(['prefix' => 'unboxes'], function () {
        Route::get('new-unbox-from-case/{caseId}', [UnboxController::class, 'unboxItemFromCase'])->name('unboxItemFromCase');
    });

    Route::get('test', function () {
        return response()->json([
            'message' => 'Hello World',
        ]);
    });
});
