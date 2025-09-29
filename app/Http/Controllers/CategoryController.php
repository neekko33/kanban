<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $pageSize = $request->input('pageSize', 10);
        return response()->json($request->user()->categories()->latest()->paginate($pageSize));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "name" => "required|string|max:255",
        ]);

        $category = $request->user()->categories()->create($data);

        return response()->json($category, 201);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            "name" => "required|string|max:255",
        ]);

        $category = $request->user()->categories()->findOrFail($id);
        $category->update($data);

        return response()->json($category);
    }

    public function destroy(Request $request, $id)
    {
        $category = $request->user()->categories()->findOrFail($id);
        $category->delete();

        return response()->json(null, 204);
    }
}
