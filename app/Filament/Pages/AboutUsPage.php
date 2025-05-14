<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\AboutUs;
use App\Models\Team;
use App\Models\Partner;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Notifications\Notification;
use Filament\Pages\Actions\ButtonAction;

class AboutUsPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-information-circle';
    protected static ?string $navigationLabel = 'About Us';
    protected static ?string $slug = 'about-us';
    protected static string $view = 'filament.pages.about-us';
    protected static ?string $navigationGroup = 'About Us Management';

    public $description;
    public $email;
    public $teams = [];
    public $partners = [];

    public function mount()
{
    $aboutUs = AboutUs::firstOrCreate(['id' => 1], [
        'description' => 'No information available at this time.',
        'email' => 'info@company.com',
    ]);

    $this->description = $aboutUs->description;
    $this->email = $aboutUs->email;
    $this->teams = $aboutUs->teams()->pluck('teams.id')->toArray();
    $this->partners = $aboutUs->partners()->pluck('partners.id')->toArray();
}


    public function save()
    {
        $aboutUs = AboutUs::first();
         $aboutUs->description = $this->description;
        $aboutUs->email = $this->email;
        $aboutUs->teams()->sync($this->teams);
        $aboutUs->partners()->sync($this->partners);
        $aboutUs->save();

        Notification::make()
            ->title('About Us updated successfully!')
            ->success()
            ->send();
    }


    protected function getFormSchema(): array
    {
        return [
            Grid::make(2)
                ->schema([
                    Card::make()
                        ->schema([
                            RichEditor::make('description')->label('Description'),
                            TextInput::make('email')->label('Contact Email')->email()->required(),
                            Select::make('teams')
                                ->label('Select Teams')
                                ->multiple()
                                ->options(Team::pluck('name', 'id')->toArray())
                                ->preload(),
                            Select::make('partners')
                                ->label('Select Partners')
                                ->multiple()
                                ->options(Partner::pluck('name', 'id')->toArray())
                                ->preload(),
                        ]),
                ]),
        ];
    }

    protected function getActions(): array
    {
        return [
            ButtonAction::make('save')
                ->label('Update About Us')
                ->action('save')
                ->color('primary'),
        ];
    }
}
