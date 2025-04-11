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
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;


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
                                TextInput::make('title')->required()->columnSpan(1),
                                TextInput::make('venue_name')->required()->columnSpan(1),
                                TagsInput::make('artist_name')->label('Artist name(s)')->required()->placeholder('New Artist'),
                                RichEditor::make('description'),
                                Repeater::make('schedules')
                                    ->relationship()
                                    ->label('Date and Times')
                                    ->schema([
                                        DatePicker::make('date')->required(),
                                        TimePicker::make('start_time')->label('Starttijd')->required(),
                                        TimePicker::make('end_time')->label('Eindtijd')->required(),
                                    ])
                                    ->columns(3)
                                    ->defaultItems(1),
                                MapPicker::make('location')->label('Select location'),
                            ]),

                        Card::make()
                            ->columnSpan(1)
                            ->schema([
                                FileUpload::make('image')->image()->columnSpan(1),
                                TextInput::make('image_alt')->label('Alt Text for image')->columnSpan(1),
                                TagsInput::make('tags')->label('Labels / Tags')->columnSpan(1),
                                Toggle::make('special_event')->label('Special Event')->columnSpan(1),
                                Toggle::make('is_active')->label('Active')->default(true)->columnSpan(1),
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
                ToggleColumn::make('special_event')->label('Special Event'),
                ToggleColumn::make('is_active')->label('Active'),
                TextColumn::make('created_at')->dateTime(),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Toon alleen actieve exposities')
                    ->nullable()
                    ->boolean(),

                TernaryFilter::make('special_event')
                    ->label('Toon alleen special events')
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
        ];
    }

    public static function mutateFormDataBeforeSave(array $data): array
    {
        return self::mutateFormDataBeforeCreate($data);
    }
}
