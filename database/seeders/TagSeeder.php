<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            'Laravel',
            'Vue.js',
            'React',
            'JavaScript',
            'PHP',
            'Python',
            'API Development',
            'Web Development',
            'Backend',
            'Frontend',
            'Database Design',
            'Authentication',
            'REST API',
            'GraphQL',
            'Docker',
            'DevOps',
            'Testing',
            'Performance',
            'Security',
            'Best Practices',
            'Tutorial',
            'Tips & Tricks',
            'Case Study',
        ];

        foreach ($tags as $tagName) {
            Tag::firstOrCreate(
                ['slug' => Str::slug($tagName)],
                ['name' => $tagName]
            );
        }
    }
}
