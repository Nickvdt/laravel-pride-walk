<?php

namespace App\Filament\Resources\ExhibitionResource\Pages;

use App\Filament\Resources\ExhibitionResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Log;

class CreateExhibition extends CreateRecord
{
    protected static string $resource = ExhibitionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        Log::info('Form data after processing:', $data); 
        return $data;
    }
}