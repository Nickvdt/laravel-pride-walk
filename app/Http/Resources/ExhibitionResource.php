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
    $datesSeen = [];

    foreach ($schedules as $schedule) {
        try {
            $items = ScheduleExpander::expand($schedule, 50);

            foreach ($items as $item) {
                $dateOnly = explode(' ', $item['date'])[0];

                $start = strtotime($dateOnly . ' ' . $item['start_time']);
                $end = strtotime($dateOnly . ' ' . $item['end_time']);

                // Special events altijd meenemen
                if ($schedule->is_special_event) {
                    $expanded[] = [
                        'date' => $dateOnly,
                        'start_time' => $start,
                        'end_time' => $end,
                        'is_special_event' => true,
                        'special_event_description' => $schedule->special_event_description,
                    ];
                    continue;
                }

                // Normale events: alleen als deze datum nog niet eerder is toegevoegd
                if (!in_array($dateOnly, $datesSeen)) {
                    $datesSeen[] = $dateOnly;
                    $expanded[] = [
                        'date' => $dateOnly,
                        'start_time' => $start,
                        'end_time' => $end,
                        'is_special_event' => false,
                        'special_event_description' => null,
                    ];
                }
            }
        } catch (\Exception $e) {
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
