<?php

namespace Database\Seeders;

use App\Models\Categorie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = collect(['Livre', 'Jeux-vidéo', 'Film']);

        $categories->each(fn ($categorie) => Categorie::create([
            'name' => $categorie,
            'slug' => Str::slug($categorie),
        ]));
    }
}
