<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ExhibitionScheduleResource;
use App\Services\ScheduleExpander;
use Illuminate\Support\Facades\Log;


class ExhibitionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'artist_name' => $this->artist_name,
            'venue_name' => $this->venue_name,
            'description' => $this->description,
            'special_event' => $this->special_event,
            'image' => $this->image,
            'image_alt' => $this->image_alt,
            'image_caption' => $this->image_caption,
            'is_active' => $this->is_active,
            'location' => [
                (float) $this->location['latitude'],
                (float) $this->location['longitude'],
            ],
            'address' => $this->location['address'] ?? null,
            'schedules' => $this->getExpandedSchedules(),
            'tags' => $this->tags->map(function ($tag) {
                return [
                    'id' => $tag->id,
                    'name' => $tag->name,
                ];
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    protected function getExpandedSchedules(): array
    {
        $schedules = $this->schedules;
        $expanded = [];

        foreach ($schedules as $schedule) {
            try {
                $items = ScheduleExpander::expand($schedule, 50);
                foreach ($items as $item) {
                    // Verwijder de tijd uit de datum als die erin zit
                    $dateOnly = explode(' ', $item['date'])[0];

                    // Gebruik UNIX-timestamp voor de tijden
                    $start = strtotime($dateOnly . ' ' . $item['start_time']);
                    $end = strtotime($dateOnly . ' ' . $item['end_time']);

                    $expanded[] = [
                        'date' => $item['date'],
                        'start_time' => $start,    // Gebruik UNIX-timestamp
                        'end_time' => $end,        // Gebruik UNIX-timestamp
                        'is_special_event' => $schedule->is_special_event,
                        'special_event_description' => $schedule->special_event_description,
                    ];
                }
            } catch (\Exception $e) {
                // Log de fout
                Log::error("Fout tijdens expanderen van schedules", [
                    'schedule_id' => $schedule->id,
                    'title' => $schedule->exhibition->title ?? 'Onbekend',
                    'error' => $e->getMessage(),
                ]);
            }
        }

        usort($expanded, fn($a, $b) => $a['start_time'] <=> $b['start_time']);

        return $expanded;
    }
}
