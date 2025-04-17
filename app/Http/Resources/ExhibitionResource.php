<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ExhibitionScheduleResource;
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
            'tags' => $this->tags,
            'special_event' => $this->special_event,
            'image' => $this->image,
            'image_alt' => $this->image_alt,
            'is_active' => $this->is_active,
            'location' => [
                (float) $this->location['latitude'],
                (float) $this->location['longitude'],
            ],
            'address' => $this->location['address'] ?? null,
            'schedules' => ExhibitionScheduleResource::collection($this->whenLoaded('schedules')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
    
}
