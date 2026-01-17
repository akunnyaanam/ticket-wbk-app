<x-layouts::app :title="__('Events')">
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        <flux:separator class="md:hidden" />

        <div class="mx-auto w-full max-w-7xl px-4 py-6 md:px-6 lg:px-8">
            <header class="mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <flux:heading size="xl" level="1">{{ __('Events') }}</flux:heading>
                        <flux:subheading class="mt-2 text-base">
                            Create your Event here.
                        </flux:subheading>
                    </div>

                    <flux:button
                        href="{{ route('events.index') }}" wire:navigate.hover
                        icon="arrow-left"
                        variant="subtle"
                        size="sm"
                    >
                        Back to List
                    </flux:button>
                </div>
            </header>

            <div>
                @livewire('events.create-event')
            </div>
        </div>
    </div>
</x-layouts::app>
