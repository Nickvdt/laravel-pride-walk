<?php

namespace App\Filament\Widgets;

use App\Models\NewsRibbon;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Widgets\Widget;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;

class NewsRibbonWidget extends Widget implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'filament.widgets.news-ribbon-widget';

    public $text;
    public $active;

    public function mount(): void
    {
        $newsRibbon = NewsRibbon::first();
        $this->form->fill([
            'text' => $newsRibbon?->text ?? '',
            'active' => $newsRibbon?->active ?? false,
        ]);
    }

    public function updateNewsRibbon(): void
    {
        $data = $this->form->getState();

        $newsRibbon = NewsRibbon::firstOrNew([]);
        $newsRibbon->text = $data['text'];
        $newsRibbon->active = $data['active'];
        $newsRibbon->save();

        Notification::make()
            ->title('NewsRibbon updated!')
            ->success()
            ->send();
    }

    protected function getFormSchema(): array
    {
        return [
            RichEditor::make('text')
                ->label('News Ribbon Text')
                ->placeholder('Enter your news message here...')
                ->toolbarButtons(['bold', 'italic', 'underline', 'link', 'list'])
                ->maxLength(255)
                    ->extraAttributes([
                        'x-on:keydown.enter.prevent' => '',
                        'style' => 'min-height: 200px; height: 100px; overflow: hidden;',
                    ]),

            Toggle::make('active')
                ->label('Active')
                ->default(true),
        ];
    }
}
