<?php

use Illuminate\Database\Seeder;
use App\Models\News;
use App\Models\User;

class NewsSeeder extends Seeder
{
    public function run()
    {
        $user = User::first();
        News::factory(10)->create(['user_id' => $user->id]);
    }
}
