<x-filament::widget>
    <x-filament::card>
        <form wire:submit.prevent="updateNewsRibbon" class="space-y-4">
            {{ $this->form }}

            <div class="flex justify-end">
                <x-filament::button class="mt-4" type="submit" color="primary">
                    Update
                </x-filament::button>
            </div>
        </form>
    </x-filament::card>
</x-filament::widget>
