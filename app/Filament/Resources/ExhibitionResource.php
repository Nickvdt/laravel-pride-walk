<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExhibitionResource\Pages;
use App\Models\Exhibition;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TagsInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BooleanColumn;
use App\Forms\Components\MapPicker;

class ExhibitionResource extends Resource
{
    protected static ?string $model = Exhibition::class;
    protected static ?string $navigationIcon = 'heroicon-o-map';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
        ->schema([
            TextInput::make('title')->required()->label('Naam Expositie'),
            TextInput::make('artist_name')->required()->label('Naam Artiest'),
            TextInput::make('venue_name')->required()->label('Naam Locatie'),
            TextInput::make('address')->required()->label('Adres')->columnSpan(2),
            Textarea::make('description')->label('Beschrijving'),
            TagsInput::make('tags')->label('Labels / Tags'),
            Toggle::make('special_event')->label('Special Event'),
            MapPicker::make('location')->label('Selecteer locatie')
                ->required(),
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
            ->filters([
                //
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
        ];
    }
}
