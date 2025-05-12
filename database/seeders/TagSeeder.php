<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tagNames = [
            'fotografie',
            'schilderijen',
            'keramiek',
            'video',
            'sieraden',
            'collages',
            'documentatie',
            'lithografie',
            'acryl',
        ];

        foreach ($tagNames as $name) {
            Tag::firstOrCreate(['name' => ucfirst(strtolower($name))]);
        }
    }
}
