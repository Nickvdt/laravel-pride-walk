<?php

namespace App\Services;

use RRule\RRule;
use App\Models\ExhibitionSchedule;
use Carbon\Carbon;

class ScheduleExpander
{
    public static function expand(ExhibitionSchedule $schedule, int $limit = 10)
    {
        $dateOnly = explode(' ', $schedule->date)[0];

        return [[
            'date' => $dateOnly,
            'start_time' => $schedule->start_time,
            'end_time' => $schedule->end_time,
        ]];
    }
}
