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
use Filament\Tables\Columns\BooleanColumn;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use App\Forms\Components\MapPicker;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;



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
                                TextInput::make('title')->required()->label('Naam Expositie')->columnSpan(1),
                                TextInput::make('venue_name')->required()->label('Naam Locatie')->columnSpan(1),
                                TextInput::make('artist_name')->required()->label('Naam Artiest'),
                                RichEditor::make('description')->label('Beschrijving'),

                                MapPicker::make('map')
                                    ->label('Selecteer locatie'),

                                TextInput::make('latitude')
                                    ->label('Latitude'),

                                TextInput::make('longitude')
                                    ->label('Longitude'),

                            ]),

                        Card::make()
                            ->columnSpan(1)
                            ->schema([
                                FileUpload::make('image')->label('Expositie Afbeelding')->image()->columnSpan(1),
                                TextInput::make('image_alt')->label('Alt Text voor Afbeelding')->columnSpan(1),
                                TagsInput::make('tags')->label('Labels / Tags')->columnSpan(1),
                                Toggle::make('special_event')->label('Special Event')->columnSpan(1),
                            ]),
                    ])
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->sortable()->searchable(),
                TextColumn::make('artist_name')->sortable(),
                TextColumn::make('venue_name')->sortable(),
                BooleanColumn::make('special_event')->label('Special Event'),
                TextColumn::make('created_at')->dateTime()->label('Aangemaakt op'),
            ])
            ->filters([])
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
        ];
    }

    public static function mutateFormDataBeforeSave(array $data): array
    {
        return self::mutateFormDataBeforeCreate($data);
    }
}
