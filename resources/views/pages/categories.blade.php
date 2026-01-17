<x-layouts::app :title="__('Categories')">
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        <flux:separator class="md:hidden" />

        <div class="mx-auto w-full max-w-7xl px-4 py-6 md:px-6 lg:px-8">
            <header class="mb-6 flex items-center justify-between">
                <div>
                    <flux:heading size="xl" level="1">{{ __('Categories') }}</flux:heading>
                    <flux:subheading class="mt-2 text-base">Manage your categories.</flux:subheading>
                </div>

                @livewire('categories.create-category')
            </header>

            <div class="rounded-xl shadow-sm ">
                @livewire('categories.list-categories')
            </div>
        </div>
    </div>
</x-layouts::app>
