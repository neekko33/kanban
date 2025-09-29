<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index(Request $request)
    {
        $pageSize = $request->input('pageSize', 10);
        return response()->json($request->user()->tags()->latest()->paginate($pageSize));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "name" => "required|string|max:255",
        ]);

        $tag = $request->user()->tags()->create($data);

        return response()->json($tag, 201);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            "name" => "required|string|max:255",
        ]);

        $tag = $request->user()->tags()->findOrFail($id);
        $tag->update($data);

        return response()->json($tag);
    }

    public function destroy(Request $request, $id)
    {
        $tag = $request->user()->tags()->findOrFail($id);
        $tag->delete();

        return response()->json(null, 204);
    }
}
