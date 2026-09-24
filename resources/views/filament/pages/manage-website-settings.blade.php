<x-filament-panels::page>
    <form wire:submit.prevent="save">
        {{ $this->form }}

        <div class="mt-8 flex items-center justify-end gap-3 border-t border-gray-200 dark:border-gray-800 pt-5">
            <x-filament::button type="submit" size="lg" color="primary" class="shadow-md">
                <span class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Save Settings</span>
                </span>
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
