<?php

namespace App\Http\Controllers;

use App\Models\GameCase;
use Illuminate\Http\Request;

class GameCaseController extends Controller
{
    public function listCases(Request $request)
    {
        $cases = GameCase::all();
        return response()->json($cases);
    }

    public function getCaseById(Request $request, GameCase $case)
    {
        return response()->json($case);
    }
}
