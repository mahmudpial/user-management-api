<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Technology', 'type' => 'blog'],
            ['name' => 'Web Development', 'type' => 'blog'],
            ['name' => 'Mobile Development', 'type' => 'blog'],
            ['name' => 'Backend Development', 'type' => 'blog'],
            ['name' => 'Frontend Development', 'type' => 'blog'],
            ['name' => 'DevOps', 'type' => 'blog'],
            ['name' => 'Cloud Computing', 'type' => 'blog'],
            ['name' => 'AI & Machine Learning', 'type' => 'blog'],
            ['name' => 'Tutorials', 'type' => 'blog'],
            ['name' => 'Tips & Tricks', 'type' => 'blog'],
            ['name' => 'Case Studies', 'type' => 'blog'],
            ['name' => 'News & Updates', 'type' => 'blog'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => Str::slug($category['name'])],
                [
                    'name' => $category['name'],
                    'type' => $category['type'] ?? 'blog',
                ]
            );
        }
    }
}
