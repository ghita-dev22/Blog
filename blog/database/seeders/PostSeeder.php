<?php

namespace Database\Seeders;

use App\Models\Categorie;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Categorie::all();
        $tags = Tag::all();
        $users = User::all();

        Post::factory(20)
            ->sequence(fn () => [
                'categorie_id' => $categories->random(),
            ])
            ->hasComments(3 ,fn()=>['user_id'=>$users->random()])

            ->create()
           
            ->each(fn ($post) => $post->tags()->attach($tags->random(rand(0, 3))));
    }
}
