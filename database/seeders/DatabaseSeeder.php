<?php

namespace Database\Seeders;

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
            "bio" => "Trying to do better",
            "avatar_url" =>
                "https://avatars.githubusercontent.com/u/45459176?v=4",
        ]);

        $user->boards()->create([
            "name" => "Project Alpha",
        ]);

        Task::factory(10)->create([
            "board_id" => $user->boards()->first()->id,
        ]);
    }
}
