<x-layouts::app :title="__('Categories')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <flux:separator class="md:hidden" />
        <div class="flex-1 max-md:pt-6 self-stretch">
        <flux:heading size="xl" level="1">{{ __('Categories') }}</flux:heading>
        <flux:text class="mb-6 mt-2 text-base">Create, edit, and manage your categories here.</flux:text>
        @livewire('categories.list-categories')
    </div>
</x-layouts::app>
