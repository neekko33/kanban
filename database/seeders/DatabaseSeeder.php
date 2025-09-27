<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            "name" => "neekko33",
            "email" => "neekko33@gmail.com",
        ]);

        $user->boards()->create([
            "name" => "Project Alpha",
        ]);

        Task::factory(10)->create([
            "board_id" => $user->boards()->first()->id,
        ]);

        $categories = Category::factory(5)->create([
            "user_id" => $user->id,
        ]);

        $tags = Tag::factory(5)->create([
            "user_id" => $user->id,
        ]);

        Post::factory(20)
            ->create([
                "user_id" => $user->id,
                "category_id" => $categories->random()->id,
            ])
            ->each(function ($post) use ($tags) {
                $post
                    ->tags()
                    ->attach($tags->random(rand(1, 3))->pluck("id")->toArray());
            });
    }
}
