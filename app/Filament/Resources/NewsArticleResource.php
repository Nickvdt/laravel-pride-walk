<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsArticleResource\Pages;
use App\Models\NewsArticle;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Grid;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\Select;

class NewsArticleResource extends Resource
{
    protected static ?string $model = NewsArticle::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Grid::make(3)
                    ->schema([
                        Card::make()
                            ->columnSpan(2)
                            ->schema([
                                TextInput::make('title')->required(),
                                RichEditor::make('description'),
                                FileUpload::make('image')->image(),
                                TextInput::make('image_alt')->label('Alt Text for image'),
                            ]),

                        Card::make()
                            ->columnSpan(1)
                            ->schema([
                                DatePicker::make('date')->required(),
                                Select::make('tags')->label('Labels / Tags')->multiple()->relationship('tags', 'name')->searchable()->preload(),
                                Toggle::make('is_active')->label('Active')->default(true),
                            ]),
                    ])
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->sortable()->searchable(),
                TextColumn::make('description')->limit(50)->formatStateUsing(fn($state) => strip_tags($state)),
                ImageColumn::make('image')->circular(),
                ToggleColumn::make('is_active')->label('Active'),
                TextColumn::make('date')->date()->sortable(),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Toon alleen actieve artikelen')
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
            'index' => Pages\ListNewsArticles::route('/'),
            'create' => Pages\CreateNewsArticle::route('/create'),
            'edit' => Pages\EditNewsArticle::route('/{record}/edit'),
        ];
    }
}
