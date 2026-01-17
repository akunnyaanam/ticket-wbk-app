<div>
    <form wire:submit="create">
        {{ $this->form }}

        <flux:button class="mt-4" type="submit" variant="primary">
            Submit
        </flux:button>
    </form>

    <x-filament-actions::modals />
</div>
