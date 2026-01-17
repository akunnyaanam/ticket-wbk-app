<x-layouts::app :title="__('Categories')">
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        <flux:separator class="md:hidden" />

        <div class="mx-auto w-full max-w-7xl px-4 py-6 md:px-6 lg:px-8">
            <header class="mb-6">
                <flux:heading size="xl" level="1">{{ __('Categories') }}</flux:heading>
                <flux:subheading class="mt-2 text-base">
                    Create, edit, and manage your categories here.
                </flux:subheading>
            </header>

            <div class="rounded-xl shadow-sm">
                @livewire('categories.list-categories')
            </div>
        </div>
    </div>
</x-layouts::app>
