<?php

use App\Http\Controllers\UnboxController;
use Illuminate\Support\Facades\Request;
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

    Route::get('/opcache', function (Request $request) {
        $password = $request->query('password');
        if ($password !== env('SECRET_PASSWORD')) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        phpinfo();
    });
});
