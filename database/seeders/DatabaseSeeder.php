<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Database\Factories\LikeFactory;
use Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
         User::factory()->create([
             'name' => 'Test User',
             'username' => 'username',
             'password' => Hash::make('password'),
         ]);

         Post::factory(1000)->create();

         Like::factory(1000)->create();
    }
}
