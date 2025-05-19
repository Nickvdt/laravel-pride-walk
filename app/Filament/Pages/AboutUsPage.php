<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\AboutUs;
use App\Models\Team;
use App\Models\Partner;
use Filament\Forms\Form;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Pages\Actions\ButtonAction;
use Filament\Forms\Concerns\InteractsWithForms;



class AboutUsPage extends Page
{
    use InteractsWithForms;


    protected static ?string $navigationIcon = 'heroicon-o-information-circle';
    protected static ?string $navigationLabel = 'About Us';
    protected static ?string $slug = 'about-us';
    protected static string $view = 'filament.pages.about-us';
    protected static ?string $navigationGroup = 'About Us Page';

    public $description;
    public $email;
    public $image;
    public $teams = [];
    public $partners = [];

    public function mount(): void
    {
        $aboutUs = AboutUs::firstOrCreate(['id' => 1], [
            'description' => 'No information available at this time.',
            'email' => 'info@company.com',
            'image' => null,
        ]);

        $this->form->fill([
            'description' => $aboutUs->description,
            'email' => $aboutUs->email,
            'image' => $aboutUs->image,
            'teams' => $aboutUs->teams()->pluck('teams.id')->toArray(),
            'partners' => $aboutUs->partners()->pluck('partners.id')->toArray(),
        ]);
    }



public function save()
{
    $data = $this->form->getState();

    $aboutUs = AboutUs::firstOrCreate(['id' => 1]);

    $aboutUs->description = $data['description'];
    $aboutUs->email = $data['email'];

    if (!empty($data['image'])) {
        $image = is_array($data['image']) ? $data['image'][0] : $data['image'];

        if (is_string($image)) {
            $aboutUs->image = $image;
        } elseif (method_exists($image, 'store')) {
            $path = $image->store('about_us_images', 'public');
            $aboutUs->image = $path;
        }
    }

    $aboutUs->teams()->sync($data['teams'] ?? []);
    $aboutUs->partners()->sync($data['partners'] ?? []);
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
                            FileUpload::make('image')
                                ->label('Upload Image')
                                ->image()
                                ->directory('about_us_images')
                                ->disk('public')
                                ->nullable(),
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

    public function form(Form $form): Form
    {
        return $form->schema($this->getFormSchema());
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
