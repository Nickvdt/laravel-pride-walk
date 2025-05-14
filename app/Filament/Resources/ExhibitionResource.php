<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExhibitionResource\Pages;
use App\Models\Exhibition;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use App\Forms\Components\MapPicker;
use Illuminate\Support\Facades\Log;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Forms\Components\Select;


class ExhibitionResource extends Resource
{
    protected static ?string $model = Exhibition::class;
    protected static ?string $navigationIcon = 'heroicon-o-map';

    public static function form(Forms\Form $form): Forms\Form
    {
        Log::info('Form method aangeroepen');
        return $form
            ->schema([
                Grid::make(3)
                    ->schema([
                        Card::make()
                            ->columnSpan(2)
                            ->schema([
                                TextInput::make('title')->required()->placeholder('Enter the title of the exhibition')->columnSpan(1),
                                TextInput::make('venue_name')->required()->placeholder('Enter the name of the venue')->columnSpan(1),
                                TagsInput::make('artist_name')->label('Artist name(s)')->required()->placeholder('Enter the name(s) of the artist(s)'),
                                RichEditor::make('description')->placeholder('Write a detailed description'),
                                MapPicker::make('location')->label('Select location'),
                            ]),

                        Card::make()
                            ->columnSpan(1)
                            ->schema([
                                FileUpload::make('image')
                                    ->label('Exhibition Image')
                                    ->image()
                                    ->columnSpan(1),
                                TextInput::make('image_alt')
                                    ->label('Alt Text for Image')
                                    ->placeholder('Enter alternative text for the image')
                                    ->columnSpan(1),
                                TextInput::make('image_caption')
                                    ->label('Image Caption')
                                    ->placeholder('Enter a brief description for the image')
                                    ->columnSpan(1),
                                Select::make('tags')->label('Labels / Tags')->multiple()->relationship('tags', 'name')->searchable()->preload()->columnSpan(1),
                                Toggle::make('is_active')->label('Active')->default(true)->columnSpan(1),
                            ]),
                    ])
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Title')->sortable()->searchable(),
                TextColumn::make('artist_name')->label('Artist Name')->sortable(),
                TextColumn::make('venue_name')->label('Venue Name')->sortable(),
                ToggleColumn::make('is_active')->label('Active'),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Show only active exhibitions')
                    ->nullable()
                    ->boolean(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExhibitions::route('/'),
            'create' => Pages\CreateExhibition::route('/create'),
            'edit' => Pages\EditExhibition::route('/{record}/edit'),
            'calendar' => Pages\ManageCalendar::route('/{record}/calendar'),
        ];
    }

    public static function mutateFormDataBeforeSave(array $data): array
    {
        return self::mutateFormDataBeforeCreate($data);
    }
}
