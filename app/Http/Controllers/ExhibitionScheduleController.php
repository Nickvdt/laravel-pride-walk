<?php

namespace App\Http\Controllers;

use App\Models\Exhibition;
use App\Models\ExhibitionSchedule;
use Illuminate\Http\Request;

class ExhibitionScheduleController extends Controller
{
    public function store(Request $request, Exhibition $exhibition)
    {
        $data = $request->validate([
            'start' => 'required|date',
            'end' => 'required|date',
            'recurrence_rule' => 'nullable|string',
            'is_special_event' => 'boolean',
            'special_event_description' => 'nullable|string',
        ]);

        $start = new \DateTime($data['start']);
        $end = new \DateTime($data['end']);

        $schedule = $exhibition->schedules()->create([
            'date' => $start->format('Y-m-d'),
            'start_time' => $start->format('H:i:s'),
            'end_time' => $end->format('H:i:s'),
            'recurrence_rule' => $data['recurrence_rule'] ?? null,
            'is_special_event' => $data['is_special_event'] ?? false,
            'special_event_description' => $data['special_event_description'] ?? '',
        ]);

        return response()->json($schedule);
    }

    public function update(Request $request, ExhibitionSchedule $schedule)
    {
        $data = $request->validate([
            'start' => 'required|date',
            'end' => 'required|date',
            'is_special_event' => 'boolean',
            'special_event_description' => 'nullable|string',
        ]);

        $schedule->update([
            'date' => date('Y-m-d', strtotime($data['start'])),
            'start_time' => date('H:i:s', strtotime($data['start'])),
            'end_time' => date('H:i:s', strtotime($data['end'])),
            'is_special_event' => $data['is_special_event'] ?? false,
            'special_event_description' => $data['special_event_description'] ?? '',
        ]);

        return response()->json($schedule);
    }

        public function destroy(ExhibitionSchedule $schedule)
    {
        $schedule->delete();
        return response()->json(['status' => 'deleted']);
    }
}
