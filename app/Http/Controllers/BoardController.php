<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    public function index()
    {
        return response()->json(Board::all());
    }

    public function show(Request $request, Board $board)
    {
        return response()->json($board);
    }

    public function store(Request $request)
    {
        $board = Board::create([
            ...$request->validate([
                'name' => 'required|string|max:255',
            ]),
            'user_id' => $request->user()->id,
        ]);

        return response()->json($board, 201);
    }

    public function update(Request $request, Board $board)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
        ]);

        $board->update([
            'name' => $request->input('name'),
        ]);

        return response()->json($board);
    }
}
