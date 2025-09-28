<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    public function latest(Request $request)
    {
        $board = $request->user()->boards()->latest()->with("tasks")->first();

        return response()->json($board);
    }

    public function store(Request $request)
    {
        $latestBoard = $request->user()->boards()->latest()->first();

        $newBoard = $request
            ->user()
            ->boards()
            ->create([
                "name" => "New Board",
            ]);

        $latestBoard
            ->tasks()
            ->where("status", "!=", "done")
            ->update([
                "board_id" => $newBoard->id,
            ]);

        return response()->json($newBoard);
    }

    public function update(Request $request, Board $board)
    {
        $request->validate([
            "name" => "sometimes|required|string|max:255",
        ]);

        $board->update([
            "name" => $request->input("name"),
        ]);

        return response()->json($board);
    }
}
