<?php

namespace Database\Seeders;

use App\Models\Exhibition;
use Illuminate\Database\Seeder;

class ExhibitionSeeder extends Seeder
{
    public function run()
    {
        Exhibition::create([
            'title' => 'PEEKABOO',
            'artist_name' => ['overview'],
            'venue_name' => 'Internationaal Theater Amsterdam',
            'description' => 'Fotografie schilderijen keramiek video sieraden collage',
            'tags' => ['Fotografie', 'schilderijen', 'keramiek', 'video', 'sieraden', 'collage'],
            'special_event' => false,
            'image' => null,
            'image_alt' => null,
            'location' => [
                'latitude' => '52.36423115',
                'longitude' => '4.882024282583231',
                'address' => 'Leidseplein 26, 1017 PT Amsterdam'
            ],
            'is_active' => true,
        ]);

        Exhibition::create([
            'title' => 'Queer in the Church',
            'artist_name' => ['Arjan Spannenburg', 'Frans Franciscus', 'MVS'],
            'venue_name' => 'Oude Lutherse Kerk',
            'description' => 'Fotografie, keramiek video',
            'tags' => ['Fotografie', 'keramiek', 'video'],
            'special_event' => false,
            'image' => null,
            'image_alt' => null,
            'location' => [
                'latitude' => '52.3683481',
                'longitude' => '4.889191',
                'address' => 'Singel 411, 1012 WN Amsterdam'
            ],
            'is_active' => true,
        ]);
        Exhibition::create([
            'title' => 'onbekend',
            'artist_name' => ['Ton of Holland'],
            'venue_name' => 'Galerie MAI',
            'description' => 'schilderijen',
            'tags' => ['schilderijen'],
            'special_event' => false,
            'image' => null,
            'image_alt' => null,
            'location' => [
                'latitude' => '52.3754759',
                'longitude' => '4.9015342',
                'address' => 'Geldersekade 30, 1012 BJ Amsterdam'
            ],
            'is_active' => true,
        ]);

        Exhibition::create([
            'title' => 'onbekend',
            'artist_name' => ['Maxime de Waal', 'Tim Weerdenburg'],
            'venue_name' => 'Hotel Mercier',
            'description' => 'Fotografie',
            'tags' => ['Fotografie'],
            'special_event' => false,
            'image' => null,
            'image_alt' => null,
            'location' => [
                'latitude' => '52.3731543',
                'longitude' => '4.8822357',
                'address' => 'Rozenstraat 12, 1016 NX Amsterdam'
            ],
            'is_active' => true,
        ]);
        Exhibition::create([
            'title' => 'Eep Seeber @ Mister B',
            'artist_name' => ['Eep Seeber'],
            'venue_name' => 'Mr. B',
            'description' => 'fotografie',
            'tags' => ['fotografie'],
            'special_event' => false,
            'image' => null,
            'image_alt' => null,
            'location' => [
                'latitude' => '52.3736246',
                'longitude' => '4.8826868',
                'address' => 'Prinsengracht 192, 1016 HC Amsterdam'
            ],
            'is_active' => true,
        ]);

        Exhibition::create([
            'title' => 'Paul Derrez',
            'artist_name' => ['Paul Derrez'],
            'venue_name' => '?',
            'description' => 'Sieraden',
            'tags' => ['Sieraden'],
            'special_event' => false,
            'image' => null,
            'image_alt' => null,
            'location' => [
                'latitude' => '52.3730796', // geen adres
                'longitude' => '4.8924534',
                'address' => 'Amsterdam'
            ],
            'is_active' => true,
        ]);
        Exhibition::create([
            'title' => 'Carlos Marlo @ Rob',
            'artist_name' => ['Carlos Marló'],
            'venue_name' => 'RoB',
            'description' => 'Collages',
            'tags' => ['Collages'],
            'special_event' => false,
            'image' => null,
            'image_alt' => null,
            'location' => [
                'latitude' => '52.3749991',
                'longitude' => '4.8977663',
                'address' => 'Warmoesstraat 71, 1012 HX Amsterdam'
            ],
            'is_active' => true,
        ]);

        Exhibition::create([
            'title' => 'Roze Reuzen',
            'artist_name' => ['Uit archief IHLIA'],
            'venue_name' => 'IHLIA 143 (3e verdieping)',
            'description' => 'Documentatie',
            'tags' => ['Documentatie'],
            'special_event' => false,
            'image' => null,
            'image_alt' => null,
            'location' => [
                'latitude' => '52.375795747210375',
                'longitude' => '4.907404195926572',
                'address' => 'Oosterdokskade, 1011 DL Amsterdam'
            ],
            'is_active' => true,
        ]);
        Exhibition::create([
            'title' => 'MOREPIXX',
            'artist_name' => ['Diverse fotografen'],
            'venue_name' => 'Ramses Shaffy Huis',
            'description' => 'Fotografie',
            'tags' => ['Fotografie'],
            'special_event' => false,
            'image' => null,
            'image_alt' => null,
            'location' => [
                'latitude' => '52.3753973',
                'longitude' => '4.9285329',
                'address' => 'Piet Heinkade 231, 1019 BW Amsterdam'
            ],
            'is_active' => true,
        ]);
        Exhibition::create([
            'title' => 'groepsexpo',
            'artist_name' => ['Diverse kunstenaars'],
            'venue_name' => 'Galerie kunstRUIMTE',
            'description' => 'Schilderij keramiek',
            'tags' => ['schilderij', 'keramiek'],
            'special_event' => false,
            'image' => null,
            'image_alt' => null,
            'location' => [
                'latitude' => '52.368697',
                'longitude' => '4.9039147',
                'address' => 'Jodenbreestraat 25, 1011 NH Amsterdam'
            ],
            'is_active' => true,
        ]);
        Exhibition::create([
            'title' => 'Onbekend Stadszwanen',
            'artist_name' => [],
            'venue_name' => 'Zwanenburgwal',
            'description' => '',
            'tags' => [],
            'special_event' => false,
            'image' => null,
            'image_alt' => null,
            'location' => [
                'latitude' => '52.36891054616912',
                'longitude' => '4.899950238944655',
                'address' => 'Zwanenburgwal, Amsterdam'
            ],
            'is_active' => true,
        ]);
        Exhibition::create([
            'title' => 'MAMABIRD',
            'artist_name' => ['MAMABIRD Studio Rob Visje'],
            'venue_name' => 'Zwanenburgwal',
            'description' => 'Lithografie en acryl',
            'tags' => ['Lithografie', 'acryl'],
            'special_event' => false,
            'image' => null,
            'image_alt' => null,
            'location' => [
                'latitude' => '52.36891054616912',
                'longitude' => '4.899950238944655',
                'address' => 'Zwanenburgwal, Amsterdam'
            ],
            'is_active' => true,
        ]);
        Exhibition::create([
            'title' => 'Iztock Klançar',
            'artist_name' => ['Iztock Klançar'],
            'venue_name' => 'Free Willie',
            'description' => '',
            'tags' => json_encode([]),
            'special_event' => false,
            'image' => null,
            'image_alt' => null,
            'location' => [
                'latitude' => '52.3667161',
                'longitude' => '4.8993281',
                'address' => 'Amstel 178, 1017 CZ Amsterdam'
            ],
            'is_active' => true,
        ]);
        Exhibition::create([
            'title' => 'Gemma Leys / Bastiënne Kramer',
            'artist_name' => ['Gemma Leys', 'Bastiënne Kramer'],
            'venue_name' => 'Prinsengracht Atelier',
            'description' => 'schilderijen / keramiek',
            'tags' => ['schilderijen', 'keramiek'],
            'special_event' => false,
            'image' => null,
            'image_alt' => null,
            'location' => [
                'latitude' => '52.37522295',
                'longitude' => '4.8832819',
                'address' => 'Prinsengracht, Amsterdam'
            ],
            'is_active' => true,
        ]);
    }
}
