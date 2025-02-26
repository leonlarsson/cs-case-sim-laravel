<?php

use App\Models\GameCase;
use App\Models\GameItem;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('home');
})->name('home');

Route::group(['prefix' => 'api'], function () {
    Route::get('cases', function () {
        $cases = GameCase::all();
        return response()->json($cases);
    });

    Route::get('cases/{case}', function (GameCase $case) {
        return response()->json($case);
    });

    Route::get('items', function () {
        $items = GameItem::all();
        return response()->json($items);
    });

    Route::get('items/{item}', function (GameItem $item) {
        return response()->json($item);
    });
});
