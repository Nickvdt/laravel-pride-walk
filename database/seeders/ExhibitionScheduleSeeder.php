<?php

namespace Database\Seeders;

use App\Models\Exhibition;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ExhibitionScheduleSeeder extends Seeder
{
    public function run()
    {
        $defaultStartDate = Carbon::create(2025, 7, 26);
        $defaultEndDate = Carbon::create(2025, 8, 3);

        $exhibitions = [
            ['title' => 'PEEKABOO', 'start' => '12:00', 'end' => '18:00'], // 1
            ['title' => 'WALLPAPER', 'start' => '13:00', 'end' => '19:00'], // 3
            ['title' => 'Dans volk', 'start' => '09:00', 'end' => '21:00'], // 4
            ['title' => 'MY FETISH EYE', 'start' => '11:00', 'end' => '19:00'], // 5
            ['title' => 'Roze Reuzen', 'weekdays' => [ // 8
                'zondag' => ['10:00', '20:00'],
                'maandag' => ['08:00', '22:00'],
                'dinsdag' => ['08:00', '22:00'],
                'woensdag' => ['08:00', '22:00'],
                'donderdag' => ['08:00', '22:00'],
                'vrijdag' => ['08:00', '22:00'],
                'zaterdag' => ['10:00', '20:00']
            ]],
            ['title' => 'MOREPIXX', 'start' => '17:00', 'end' => '19:00', 'start_date' => '2025-07-19', 'end_date' => '2025-08-03'], // 9
            ['title' => 'KUNSTRUIM', 'start' => '12:00', 'end' => '18:00', 'start_date' => '2025-07-09', 'end_date' => '2025-08-03',], // 10
            ['title' => '*DIED*', 'start' => '12:00', 'end' => '18:00', 'start_date' => '2025-07-31', 'end_date' => '2025-08-03'], // 11
            ['title' => 'MAMABIRD', 'start' => '12:00', 'end' => '18:00'], // 12
            ['title' => 'MARTIN AT FREE WILLY', 'start' => '20:00', 'end' => '23:59'], // 13
            ['title' => 'Gemma Leys en Bastiënne Kramer', 'start' => '12:00', 'end' => '18:00'], // 14
            ['title' => 'Prins de Vos', 'start' => '11:00', 'end' => '23:00', 'start_date' => '2025-07-18', 'end_date' => '2025-08-24'], // 17
            ['title' => 'TIM&RISK&DEVON', 'start' => '09:00', 'end' => '21:00'], // 18
            ['title' => 'MEN BY NIELS', 'start' => '09:00', 'end' => '21:00'], // 19
            ['title' => 'Pedro Matias', 'start' => '09:00', 'end' => '21:00'], // 22

        ];

        foreach ($exhibitions as $exhibition) {
            $model = Exhibition::where('title', $exhibition['title'])->first();
            if ($model) {
                $startDate = isset($exhibition['start_date']) ? Carbon::parse($exhibition['start_date'])->toDateString() : $defaultStartDate->toDateString();
                $endDate = isset($exhibition['end_date']) ? Carbon::parse($exhibition['end_date'])->toDateString() : $defaultEndDate->toDateString();

                for ($date = Carbon::parse($startDate); $date->lte(Carbon::parse($endDate)); $date->addDay()) {
                    $dayOfWeek = strtolower($date->format('l'));
                    $start = $exhibition['start'] ?? '00:00';
                    $end = $exhibition['end'] ?? '00:00';

                    if (isset($exhibition['weekdays']) && isset($exhibition['weekdays'][$dayOfWeek])) {
                        list($start, $end) = $exhibition['weekdays'][$dayOfWeek];
                    }

                    $model->schedules()->create([
                        'date' => $date->toDateString(),
                        'start_time' => $start,
                        'end_time' => $end,
                        'recurrence_rule' => $exhibition['daily'] ?? null,
                    ]);
                }
            }
        }
    }
}
