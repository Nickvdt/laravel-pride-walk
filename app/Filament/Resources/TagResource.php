<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TagResource\Pages;
use App\Models\Tag;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;

class TagResource extends Resource
{
    protected static ?string $model = Tag::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationLabel = 'Tags';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            TextInput::make('name')
                ->required()
                ->unique(ignoreRecord: true)
                ->label('Tag Name'),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->sortable()->searchable()->label('Name'),
                TextColumn::make('created_at')->dateTime()->label('Created At'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Edit')
                    ->modalHeading('Edit Tag')
                    ->modalButton('Save'),

                Tables\Actions\DeleteAction::make()
                    ->label('Delete')
                    ->modalHeading('Delete Tag')
                    ->modalButton('Delete'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()->label('Delete Selected'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTags::route('/'),
        ];
    }
}
