<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tagNames = [
            'Ceramics',
            'Paintings',
            'Drawings',
            'Graphics',
            'Textile',
            'History',
            'Installation',
            'Jewelry',
            'Mixed Media',
            'Performance',
            'Photography',
            'Video'
        ];

        foreach ($tagNames as $name) {
            Tag::firstOrCreate(['name' => ucfirst(strtolower($name))]);
        }
    }
}
