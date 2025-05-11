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
            $dateOnly = explode(' ', $schedule->date)[0];
            return [[
                'date' => $dateOnly,
                'start_time' => $schedule->start_time,
                'end_time' => $schedule->end_time,
            ]];
        }

        $rruleString = $schedule->recurrence_rule;
        if (!str_starts_with($rruleString, 'RRULE:')) {
            $rruleString = 'RRULE:' . $rruleString;
        }

        try {
            $rrule = new RRule($rruleString);
        } catch (\Exception $e) {
            return [];
        }

        $instances = [];
        foreach ($rrule as $i => $occurrence) {
            if ($i >= $limit) break;

            try {
                $dateOnly = $occurrence->format('Y-m-d');
                $start = Carbon::parse($dateOnly . ' ' . $schedule->start_time);
                $end = Carbon::parse($dateOnly . ' ' . $schedule->end_time);

                $instances[] = [
                    'date' => $dateOnly,
                    'start_time' => $start->format('H:i'),
                    'end_time' => $end->format('H:i'),
                ];
            } catch (\Exception $e) {
                continue;
            }
        }

        usort($instances, fn($a, $b) => strtotime($a['date'] . ' ' . $a['start_time']) <=> strtotime($b['date'] . ' ' . $b['start_time']));

        return $instances;
    }
}
