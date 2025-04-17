<?php

namespace App\Filament\Resources\ExhibitionResource\Pages;

use App\Filament\Resources\ExhibitionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;

class CreateExhibition extends CreateRecord
{
    protected static string $resource = ExhibitionResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $exhibition = parent::handleRecordCreation($data);

        return $exhibition;
    }

    protected function getRedirectUrl(): string
    {
        return ExhibitionResource::getUrl('calendar', ['record' => $this->record]);
    }
}
