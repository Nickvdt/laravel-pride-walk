<?php

namespace Database\Seeders;

use App\Models\Exhibition;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ExhibitionScheduleSeeder extends Seeder
{
    public function run()
    {
        $peekaboo = Exhibition::where('title', 'PEEKABOO')->first();
        $queerChurch = Exhibition::where('title', 'Queer in the Church')->first();
        $tonOfHolland = Exhibition::whereJsonContains('artist_name', 'Ton of Holland')->first();
        $hotelMercier = Exhibition::where(function ($query) {
            $query->whereJsonContains('artist_name', 'Maxime de Waal')
                ->orWhereJsonContains('artist_name', 'Tim Weerdenburg');
        })->first();
        $eepSeeber = Exhibition::where('title', 'Eep Seeber @ Mister B')->first();
        $paulDerrez = Exhibition::whereJsonContains('artist_name', 'Paul Derrez')->first();
        $carlosMarlow = Exhibition::where('title', 'Carlos Marlo @ Rob')->first();
        $rozeReuzen = Exhibition::where('title', 'Roze Reuzen')->first();
        $morepixx = Exhibition::where('title', 'MOREPIXX')->first();
        $groupExhibition = Exhibition::where('title', 'groepsexpo')->first();
        $stadszwanen = Exhibition::where('title', 'Onbekend Stadszwanen')->first();
        $mamabird = Exhibition::where('title', 'MAMABIRD')->first();
        $iztock = Exhibition::whereJsonContains('artist_name', 'Iztock Klançar')->first();
        $gemma = Exhibition::where(function ($query) {
            $query->whereJsonContains('artist_name', 'Gemma Leys')
                ->orWhereJsonContains('artist_name', 'Bastiënne Kramer');
        })->first();

        $startDate = Carbon::create(2025, 7, 26);
        $endDate = Carbon::create(2025, 8, 3);

        foreach ([$peekaboo, $queerChurch, $tonOfHolland, $hotelMercier, $eepSeeber, $paulDerrez, $carlosMarlow, $rozeReuzen, $stadszwanen, $mamabird, $gemma] as $exhibition) {
            for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
                $exhibition?->schedules()->create([
                    'date' => $date->toDateString(),
                    'start_time' => '12:00',
                    'end_time' => '18:00',
                    'recurrence_rule' => null,
                ]);
            }
        }
        $morepixxDates = [
            '2025-07-19' => ['16:00', '20:00'],
            '2025-07-20' => ['16:00', '19:00'],
            '2025-07-21' => ['16:00', '19:00'],
            '2025-07-22' => ['17:00', '19:00'],
            '2025-07-23' => ['17:00', '19:00'],
            '2025-07-24' => ['19:00', '19:00'],
            '2025-07-25' => ['19:00', '19:00'],
            '2025-07-26' => ['19:00', '19:00'],
            '2025-07-27' => ['13:00', '18:00'],
            '2025-07-28' => ['13:00', '18:00'],
            '2025-07-29' => ['17:00', '19:00'],
            '2025-07-30' => ['13:00', '18:00'],
            '2025-07-31' => ['13:00', '18:00'],
            '2025-08-01' => ['13:00', '18:00'],
            // '2025-08-02' => gesloten
            '2025-08-03' => ['13:00', '18:00'],
        ];

        foreach ($morepixxDates as $date => [$start, $end]) {
            $morepixx?->schedules()->create([
                'date' => $date,
                'start_time' => $start,
                'end_time' => $end,
                'recurrence_rule' => null,
            ]);
        }
        if ($groupExhibition) {
            $startGroup = Carbon::create(2025, 7, 9);
            $endGroup = Carbon::create(2025, 8, 3);

            for ($date = $startGroup; $date->lte($endGroup); $date->addDay()) {
                $groupExhibition->schedules()->create([
                    'date' => $date->toDateString(),
                    'start_time' => '12:00',
                    'end_time' => '18:00',
                    'recurrence_rule' => null,
                ]);
            }
        }
    }
}
