<?php

use App\Models\GameCase;
use App\Models\GameItem;
use App\Models\Unbox;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('home');
})->name('home');

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
    });
});
