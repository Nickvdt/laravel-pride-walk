<?php

namespace Database\Seeders;

use App\Models\Exhibition;
use Illuminate\Database\Seeder;
use App\Models\Tag;

class ExhibitionSeeder extends Seeder
{
    public function run()
    {
        $exhibitions = [
            [
                'title' => 'PEEKABOO', // 1
                'artist_name' => ['Diverse kunstenaars'],
                'venue_name' => 'Internationaal Theater Amsterdam',
                'description' => 'Fotografie schilderijen keramiek video sieraden collage',
                'tags' => ['fotografie', 'schilderijen', 'keramiek', 'video', 'sieraden', 'collages'],
                'image' => null,
                'image_alt' => null,
                'location' => [
                    'latitude' => '52.36423115',
                    'longitude' => '4.882024282583231',
                    'address' => 'Leidseplein 26, 1017 PT Amsterdam'
                ],
                'is_active' => true,
            ],

            [
                'title' => 'Art at Lutherse Kerk', // 2
                'artist_name' => ['Arjan Spannenburg', 'Frans Franciscus', 'MVS'],
                'venue_name' => 'Oude Lutherse Kerk',
                'description' => 'Fotografie, keramiek video',
                'tags' => ['fotografie', 'keramiek', 'video'],
                'image' => null,
                'image_alt' => null,
                'location' => [
                    'latitude' => '52.3683481',
                    'longitude' => '4.889191',
                    'address' => 'Singel 411, 1012 WN Amsterdam'
                ],
                'is_active' => true,
            ],
            [
                'title' => 'WALLPAPER', // 3
                'artist_name' => ['Ton of Holland'],
                'venue_name' => 'Galerie MAI',
                'description' => 'Schilderijen',
                'tags' => ['schilderijen'],
                'image' => null,
                'image_alt' => null,
                'location' => [
                    'latitude' => '52.3754759',
                    'longitude' => '4.9015342',
                    'address' => 'Geldersekade 30, 1012 BJ Amsterdam'
                ],
                'is_active' => true,
            ],

            [
                'title' => 'Dans volk', // 4
                'artist_name' => ['Maxime de Waal'],
                'venue_name' => 'Hotel Mercier',
                'description' => 'Fotografie',
                'tags' => ['fotografie'],
                'image' => null,
                'image_alt' => null,
                'location' => [
                    'latitude' => '52.3731543',
                    'longitude' => '4.8822357',
                    'address' => 'Rozenstraat 12, 1016 NX Amsterdam'
                ],
                'is_active' => true,
            ],
            [
                'title' => 'MY FETISH EYE', // 5
                'artist_name' => ['Gabriel Batenburg'],
                'venue_name' => 'Mr. B',
                'description' => 'Fotografie',
                'tags' => ['fotografie'],
                'image' => null,
                'image_alt' => null,
                'location' => [
                    'latitude' => '52.3736246',
                    'longitude' => '4.8826868',
                    'address' => 'Prinsengracht 192, 1016 HC Amsterdam'
                ],
                'is_active' => true,
            ],

            [
                'title' => '50 jaar PAUL DERREz', // 6
                'artist_name' => ['Paul Derrez'],
                'venue_name' => 'THE WEARHOUSE',
                'description' => 'Sieraden',
                'tags' => ['Sieraden'],
                'image' => null,
                'image_alt' => null,
                'location' => [
                    'latitude' => '52,3735185',
                    'longitude' => '4,9005289',
                    'address' => 'Geldersekade 112, Amsterdam'
                ],
                'is_active' => true,
            ],
            // [ // 7 weg?
            //     'title' => 'Carlos Marlo @ Rob',
            //     'artist_name' => ['Carlos Marló'],
            //     'venue_name' => 'RoB',
            //     'description' => 'Collages',
            //     'tags' => ['Collages'],
            //     'image' => null,
            //     'image_alt' => null,
            //     'location' => [
            //         'latitude' => '52.3749991',
            //         'longitude' => '4.8977663',
            //         'address' => 'Warmoesstraat 71, 1012 HX Amsterdam'
            //     ],
            //     'is_active' => true,
            // ],

            [
                'title' => 'Roze Reuzen', // 8
                'artist_name' => ['Uit archief IHLIA'],
                'venue_name' => 'IHLIA 143 (3e verdieping)',
                'description' => 'Documentatie',
                'tags' => ['documentatie'],
                'image' => null,
                'image_alt' => null,
                'location' => [
                    'latitude' => '52.375795747210375',
                    'longitude' => '4.907404195926572',
                    'address' => 'Oosterdokskade, 1011 DL Amsterdam'
                ],
                'is_active' => true,
            ],
            [
                'title' => 'MOREPIXX', // 9
                'artist_name' => ['Diverse fotografen'],
                'venue_name' => 'Ramses Shaffy Huis',
                'description' => 'Fotografie',
                'tags' => ['fotografie'],
                'image' => null,
                'image_alt' => null,
                'location' => [
                    'latitude' => '52.3753973',
                    'longitude' => '4.9285329',
                    'address' => 'Piet Heinkade 231, 1019 BW Amsterdam'
                ],
                'is_active' => true,
            ],
            [
                'title' => 'KUNSTRUIM', // 10
                'artist_name' => ['Diverse kunstenaars'],
                'venue_name' => 'Galerie kunstRUIMTE',
                'description' => 'Schilderij keramiek',
                'tags' => ['schilderijen', 'keramiek'],
                'image' => null,
                'image_alt' => null,
                'location' => [
                    'latitude' => '52.368697',
                    'longitude' => '4.9039147',
                    'address' => 'Jodenbreestraat 25, 1011 NH Amsterdam'
                ],
                'is_active' => true,
            ],
            [
                'title' => '*DIED*', // 11
                'artist_name' => ['Diederik Verbakel'],
                'venue_name' => 'Stadszwanen',
                'description' => '',
                'tags' => [],
                'image' => null,
                'image_alt' => null,
                'location' => [
                    'latitude' => '52.3692282',
                    'longitude' => '4.8997682',
                    'address' => 'Zwanenburgwal 20, 1011 JD Amsterdam'
                ],
                'is_active' => true,
            ],
            [
                'title' => 'MAMABIRD', // 12
                'artist_name' => ['MAMABIRD'],
                'venue_name' => 'Studio Rob Visje',
                'description' => 'Lithografie en acryl',
                'tags' => ['lithografie', 'acryl'],
                'image' => null,
                'image_alt' => null,
                'location' => [
                    'latitude' => '52.3693878',
                    'longitude' => '4.900047',
                    'address' => 'Zwanenburgwal 60, 1011 JG Amsterdam'
                ],
                'is_active' => true,
            ],
            [
                'title' => 'MARTIN AT FREE WILLY', // 13
                'artist_name' => ['Martin of Holland'],
                'venue_name' => 'Free Willie',
                'description' => '',
                'tags' => [],
                'image' => null,
                'image_alt' => null,
                'location' => [
                    'latitude' => '52.3667459',
                    'longitude' => '4.8993403',
                    'address' => 'Amstel 178, 1017 CZ Amsterdam'
                ],
                'is_active' => true,
            ],
            [
                'title' => 'Gemma Leys en Bastiënne Kramer', // 14
                'artist_name' => ['Gemma Leys', 'Bastiënne Kramer'],
                'venue_name' => 'Prinsengracht Atelier',
                'description' => 'schilderijen / keramiek',
                'tags' => ['schilderijen', 'keramiek'],
                'image' => null,
                'image_alt' => null,
                'location' => [
                    'latitude' => '52.3621594',
                    'longitude' => '4.8900681',
                    'address' => 'Prinsengracht 626'
                ],
                'is_active' => true,
            ],
            [
                'title' => 'PERFORMANCE', // 15
                'artist_name' => ['Jesse Asselman'],
                'venue_name' => 'Het Grachten Museum',
                'description' => 'geen informatie',
                'tags' => [],
                'image' => null,
                'image_alt' => null,
                'location' => [
                    'latitude' => '52.3678921',
                    'longitude' => '4.8862198',
                    'address' => 'Herengracht 386, 1016 CJ Amsterdam'
                ],
                'is_active' => true,
            ],
            [
                'title' => 'onbekend', // 16
                'artist_name' => ['Ronald Eduart', 'Soek Zet'],
                'venue_name' => 'Oudezijds Voorburgwal',
                'description' => 'geen informatie',
                'tags' => [],
                'image' => null,
                'image_alt' => null,
                'location' => [
                    'latitude' => '52.3727052',
                    'longitude' => '4.8972777',
                    'address' => 'Oudezijds Voorburgwal 131'
                ],
                'is_active' => true,
            ],
            [
                'title' => 'Prins de Vos', // 17
                'artist_name' => ['Prins de Vos'],
                'venue_name' => 'De Melkweg',
                'description' => 'geen informatie',
                'tags' => [],
                'image' => null,
                'image_alt' => null,
                'location' => [
                    'latitude' => '52.3647777',
                    'longitude' => '4.881073',
                    'address' => 'Lijnbaansgracht 234A, 1017 PH Amsterdam'
                ],
                'is_active' => true,
            ],
            [
                'title' => 'TIM&RISK&DEVON', // 18
                'artist_name' => ['Tim Weerdeburg', 'Risk Hazenkamp', 'Devon Ress'],
                'venue_name' => 'ARTHOTEL',
                'description' => 'geen informatie',
                'tags' => [],
                'image' => null,
                'image_alt' => null,
                'location' => [
                    'latitude' => '52.3776412',
                    'longitude' => '4.8971654',
                    'address' => 'Prins Hendrikkade 33, 1012 TM Amsterdam'
                ],
                'is_active' => true,
            ],
            [
                'title' => 'MEN BY NIELS', // 19
                'artist_name' => ['Niels Smits van Burgst'],
                'venue_name' => 'HOXTON',
                'description' => 'geen informatie',
                'tags' => [],
                'image' => null,
                'image_alt' => null,
                'location' => [
                    'latitude' => '52.37181',
                    'longitude' => '4.8873904',
                    'address' => 'Herengracht 255, 1016 BJ Amsterdam'
                ],
                'is_active' => true,
            ],
            [
                'title' => 'Athenaeum', // 20
                'artist_name' => ['onbekend'],
                'venue_name' => 'Spui 14-16',
                'description' => 'geen informatie',
                'tags' => [],
                'image' => null,
                'image_alt' => null,
                'location' => [
                    'latitude' => '52.368913',
                    'longitude' => '4.8890848',
                    'address' => 'Spui 14-16, 1012 XA Amsterdam'
                ],
                'is_active' => true,
            ],
            [
                'title' => 'Queer Surinaamse Kunst', // 21
                'artist_name' => ['Queer Surinaamse Kunst'],
                'venue_name' => 'H’art',
                'description' => 'geen informatie',
                'tags' => [],
                'image' => null,
                'image_alt' => null,
                'location' => [
                    'latitude' => '52.3656522',
                    'longitude' => '4.9022137',
                    'address' => 'Amstel 51, 1018 EJ Amsterdam'
                ],
                'is_active' => true,
            ],
            [
                'title' => 'Pedro Matias', // 22
                'artist_name' => ['Pedro Matias'],
                'venue_name' => 'Hotel Bunk',
                'description' => 'geen informatie',
                'tags' => [],
                'image' => null,
                'image_alt' => null,
                'location' => [
                    'latitude' => '52.388097',
                    'longitude' => '4.9139418',
                    'address' => 'Hagedoornplein 2, 1031 BV Amsterdam'
                ],
                'is_active' => true,
            ],
            [
                'title' => 'COCK IN NORTH', // 23
                'artist_name' => ['Martijn Overweel'],
                'venue_name' => 'Tiny Showroom',
                'description' => 'geen informatie',
                'tags' => [],
                'image' => null,
                'image_alt' => null,
                'location' => [
                    'latitude' => '52.4091137',
                    'longitude' => '4.8993148',
                    'address' => 'Mandarijnenstraat 78, 1033 LH Amsterdam'
                ],
                'is_active' => true,
            ],
            [
                'title' => 'onbekend', // 24
                'artist_name' => ['Harry van Gestel'],
                'venue_name' => 'Palmstraat',
                'description' => 'geen informatie',
                'tags' => [],
                'image' => null,
                'image_alt' => null,
                'location' => [
                    'latitude' => '52.3814864',
                    'longitude' => '4.8823464',
                    'address' => 'Palmstraat 88 Amsterdam'
                ],
                'is_active' => true,
            ],
            [
                'title' => 'Matthias Herrmann', // 25
                'artist_name' => ['Matthias Herrmann'],
                'venue_name' => 'Serieuze Zaken Galerie',
                'description' => 'geen informatie',
                'tags' => [],
                'image' => null,
                'image_alt' => null,
                'location' => [
                    'latitude' => '52.3722495',
                    'longitude' => '4.8787217',
                    'address' => 'Tweede Rozendwarsstraat 24, 1016 PE Amsterdam'
                ],
                'is_active' => true,
            ],
        ];

        foreach ($exhibitions as $data) {
            $tags = collect($data['tags'] ?? [])
                ->map(function ($name) {
                    return Tag::where('name', ucfirst(strtolower($name)))->first()?->id;
                })
                ->filter()
                ->toArray();

            unset($data['tags']);

            $exhibition = Exhibition::create($data);

            $exhibition->tags()->sync($tags);
        }
    }
}
