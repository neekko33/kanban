<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $pageSize = $request->input('pageSize', 10);
        $posts = $request
            ->user()
            ->posts()
            ->latest()
            ->with("category")
            ->with("tags")
            ->paginate($pageSize);

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

    public function show(Request $request, string $postId)
    {
        $post = $request
            ->user()
            ->posts()
            ->with("category")
            ->with("tags")
            ->findOrFail($postId);

        $result = [
            "title" => $post->title,
            "description" => $post->description,
            "content" => $post->content,
            "category" => $post->category?->name,
            "tags" => $post->tags->pluck("name"),
        ];

        return response()->json($result);
    }

    public function store(PostRequest $request)
    {
        // 创建文章
        $post = $request->user()->posts()->create($request->validated());

        // 关联标签
        $post->tags()->attach($request->input("tag_ids") ?? []);

        return response()->json($post, 201);
    }

    public function update(PostRequest $request, string $postId)
    {
        $data = $request->validated();

        $post = $request
            ->user()
            ->posts()
            ->findOrFail($postId);

        // 更新文章
        $post->update($data);

        // 同步标签
        $post->tags()->sync($data["tag_ids"] ?? []);

        return response()->json($post);
    }

    public function destroy(Request $request, string $postId)
    {
        $post = $request
            ->user()
            ->posts()
            ->findOrFail($postId);

        $post->delete();

        return response()->json(null, 204);
    }
}
