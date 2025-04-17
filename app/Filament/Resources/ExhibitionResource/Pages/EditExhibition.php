<?php

namespace App\Filament\Resources\ExhibitionResource\Pages;

use App\Filament\Resources\ExhibitionResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Pages\Actions\Action;

class EditExhibition extends EditRecord
{
    protected static string $resource = ExhibitionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Visiting Hours')
                ->requiresConfirmation(false)
                ->action(function () {
                    $this->save();
                })
                ->after(function () {
                    return redirect(ExhibitionResource::getUrl('calendar', ['record' => $this->record]));
                })
                ->color('primary')
                ->icon('heroicon-o-calendar'),
        ];
    }
    
}
