<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tagNames = [
            'Fotografie',
            'schilderijen',
            'keramiek',
            'video',
            'sieraden',
            'collage',
            'Collages',
            'Documentatie',
            'Schilderij',
            'Lithografie',
            'acryl',
        ];

        foreach ($tagNames as $name) {
            Tag::firstOrCreate(['name' => ucfirst(strtolower($name))]);
        }
    }
}
