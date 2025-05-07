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
        $title = $request->input('title');

        if ($tags) {
            $query = ApplyTags::ApplyFilters($query, $tags);
        }

        if ($title) {
            $query->where('title', 'LIKE', '%' . $title . '%');
        }

        return ExhibitionResource::collection(
            $query->get()
        );
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
