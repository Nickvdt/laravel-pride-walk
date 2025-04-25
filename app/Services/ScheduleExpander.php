<?php

namespace App\Services;

use RRule\RRule;
use App\Models\ExhibitionSchedule;
use Carbon\Carbon;

class ScheduleExpander
{
    public static function expand(ExhibitionSchedule $schedule, int $limit = 10)
    {
        if (!$schedule->recurrence_rule) {
            return [[
                'date' => $schedule->date->toDateString(),
                'start_time' => $schedule->start_time,
                'end_time' => $schedule->end_time,
            ]];
        }

        $rrule = new RRule([
            'DTSTART' => Carbon::parse($schedule->date . ' ' . $schedule->start_time),
            'RRULE' => $schedule->recurrence_rule,
        ]);

        $instances = [];
        foreach ($rrule as $i => $occurrence) {
            if ($i >= $limit) break;

            $instances[] = [
                'date' => $occurrence->format('Y-m-d'),
                'start_time' => $schedule->start_time,
                'end_time' => $schedule->end_time,
            ];
        }

        return $instances;
    }
}
