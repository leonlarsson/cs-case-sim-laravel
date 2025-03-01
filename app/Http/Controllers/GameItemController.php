<?php

namespace App\Http\Controllers;

use App\Models\GameItem;
use Illuminate\Http\Request;

class GameItemController extends Controller
{
    public function listItems(Request $request)
    {
        $cases = GameItem::all();
        return response()->json($cases);
    }

    public function getItemById(Request $request, GameItem $item)
    {
        return response()->json($item);
    }
}
