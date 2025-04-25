<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ExhibitionScheduleResource;
use App\Services\ScheduleExpander;


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
            $items = ScheduleExpander::expand($schedule, 50);
            foreach ($items as $item) {
                $start = strtotime($item['date'] . ' ' . $item['start_time']);
                $end = strtotime($item['date'] . ' ' . $item['end_time']);
                $expanded[] = [
                    'date' => $item['date'],
                    'start_time' => $start,
                    'end_time' => $end,
                ];
            }
        }

        usort($expanded, fn($a, $b) => $a['start_time'] <=> $b['start_time']);

        return $expanded;
    }
}
