<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExhibitionScheduleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'date' => $this->date->format('Y-m-d'),
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'recurrence_rule' => $this->recurrence_rule,
        ];
    }
}