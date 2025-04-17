<?php

namespace App\Filament\Resources\ExhibitionResource\Pages;

use App\Filament\Resources\ExhibitionResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Pages\Actions\Action;


class ManageCalendar extends EditRecord
{
    protected static string $resource = ExhibitionResource::class;

    protected static string $view = 'filament.resources.exhibition-resource.pages.manage-calendar';

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return $data;
    }

    public function getTitle(): string
    {
        return 'Visiting Hours For ' . $this->record->title;
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Back')
                ->url(ExhibitionResource::getUrl('edit', ['record' => $this->record]))
                ->color('gray')
                ->icon('heroicon-o-arrow-left'),
        ];
    }
}
