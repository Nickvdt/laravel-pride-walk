<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExhibitionResource;
use App\Library\Tags\ApplyTags;
use App\Models\Exhibition;
use Illuminate\Http\Request;
use App\Services\ScheduleExpander;

class ExhibitionController extends Controller
{
public function index(Request $request)
{
    $query = Exhibition::with([
        'schedules' => function ($query) {
            $query->where('date', '>=', now()->format('Y-m-d'))
                ->orderBy('date')
                ->orderBy('start_time');
        },
        'tags'
    ])->where('is_active', true);

    $tags = $request->input('tags');
    $searchTerm = $request->input('searchTerm');

    if ($tags) {
        $query = ApplyTags::ApplyFilters($query, $tags);
    }

    if ($searchTerm) {
        $query->where(function ($q) use ($searchTerm) {
            $q->where('title', 'LIKE', '%' . $searchTerm . '%')
              ->orWhere('description', 'LIKE', '%' . $searchTerm . '%');
        });
    }

    $exhibitions = $query->get();

    // Sorteer eerst op open exposities, daarna toekomstige
    $sorted = $exhibitions->sortBy(function ($exhibition) {
        $now = now()->timestamp;
        $expanded = [];
        $datesSeen = [];

        foreach ($exhibition->schedules as $schedule) {
            try {
                $items = ScheduleExpander::expand($schedule, 50);

                foreach ($items as $item) {
                    $dateOnly = explode(' ', $item['date'])[0];
                    $start = strtotime($dateOnly . ' ' . $item['start_time']);
                    $end = strtotime($dateOnly . ' ' . $item['end_time']);

                    if ($schedule->is_special_event) {
                        $expanded[] = compact('start', 'end');
                        continue;
                    }

                    if (!in_array($dateOnly, $datesSeen)) {
                        $datesSeen[] = $dateOnly;
                        $expanded[] = compact('start', 'end');
                    }
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        usort($expanded, fn($a, $b) => $a['start'] <=> $b['start']);

        if (empty($expanded)) return PHP_INT_MAX;

        $first = $expanded[0]['start'];
        $last = $expanded[0]['end'];

        if ($first <= $now && $last >= $now) {
            return 0; // Momenteel open
        }

        return $first; // Toekomstig
    });

    return ExhibitionResource::collection($sorted->values());
}

    public function show($id)
    {
        $exhibition = Exhibition::with([
            'schedules' => function ($query) {
                $query->where('date', '>=', now()->format('Y-m-d'))
                    ->orderBy('date')
                    ->orderBy('start_time');
            },
            'tags'
        ])->findOrFail($id);

        return new ExhibitionResource($exhibition);
    }

    public function upcoming(Request $request)
    {
        $limit = $request->input('limit', 10);

        $exhibitions = Exhibition::with(['schedules' => function ($query) {
            $query->where('date', '>=', now()->format('Y-m-d'));
        }])
            ->where('is_active', true)
            ->get();

        $data = $exhibitions->map(function ($exhibition) use ($limit) {
            $expandedSchedules = [];

            foreach ($exhibition->schedules as $schedule) {
                $expandedSchedules = array_merge(
                    $expandedSchedules,
                    ScheduleExpander::expand($schedule, $limit)
                );
            }

            usort($expandedSchedules, fn($a, $b) => strtotime($a['date'] . ' ' . $a['start_time']) <=> strtotime($b['date'] . ' ' . $b['start_time']));
            $expandedSchedules = array_slice($expandedSchedules, 0, $limit);

            return [
                'id' => $exhibition->id,
                'title' => $exhibition->title,
                'schedules' => $expandedSchedules,
            ];
        });

        return response()->json($data);
    }
}
