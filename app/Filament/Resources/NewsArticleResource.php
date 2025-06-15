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
                                TextInput::make('title')->placeholder('Enter the title of the news article')->required(),
                                RichEditor::make('description')->placeholder('Write the news content'),
                                FileUpload::make('image')->image()->label('News Article Image'),
                                TextInput::make('image_alt')->label('Alt Text for Image')->placeholder('Enter alternative text for the image'),
                                TextInput::make('image_caption')
                                    ->label('Image Caption')
                                    ->placeholder('Enter a brief description for the image')
                                    ->columnSpan(1),
                            ]),

                        Card::make()
                            ->columnSpan(1)
                            ->schema([
                                DatePicker::make('date')
                                    ->placeholder('Select the publication date')
                                    ->default(now())
                                    ->required(),
                                Select::make('tags')
                                    ->label('Labels / Tags')
                                    ->multiple()
                                    ->searchable()
                                    ->preload()
                                    ->relationship('tags', 'name')
                                    ->options(function () {
                                        return \App\Models\Tag::all()->mapWithKeys(function ($tag) {
                                            return [
                                                $tag->id => $tag->name ?: 'Afbeelding-tag (#' . $tag->id . ')',
                                            ];
                                        });
                                    }),
                                Toggle::make('is_active')->label('Active')->default(true),
                            ]),
                    ])
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Title')->sortable()->searchable(),
                TextColumn::make('description')->label('Description')->limit(50)->formatStateUsing(fn($state) => strip_tags($state)),
                ImageColumn::make('image')->label('Image')->circular(),
                ToggleColumn::make('is_active')->label('Active'),
                TextColumn::make('date')->label('Date')->date()->sortable(),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Show only active articles')
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
