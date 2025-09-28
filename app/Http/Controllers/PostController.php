<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = $request
            ->user()
            ->posts()
            ->with("category")
            ->with("tags")
            ->paginate(12);

        // 自定义每条数据
        $results = $posts->getCollection()->map(
            fn($post) => [
                "id" => $post->id,
                "title" => $post->title,
                "category" => $post->category?->name,
                "tags" => $post->tags->pluck("name"),
                "created_at" => $post->created_at->toDateTimeString(),
                "updated_at" => $post->updated_at->toDateTimeString(),
            ]
        );

        // 用自定义数据替换分页的 collection
        $paginated = $posts->setCollection($results);

        return response()->json($paginated);
    }
}
