<x-filament::widget>
    <x-filament::card>
        <div class="text-sm font-semibold mb-3">
            Quick idea submission
        </div>

        {{ $this->form }}

        <div class="mt-4 flex justify-end">
            <x-filament::button wire:click="submit">
                Save idea
            </x-filament::button>
        </div>
    </x-filament::card>
</x-filament::widget>
