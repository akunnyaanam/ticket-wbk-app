<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Livewire\Component;

class CreateCategory extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public function getFormSchema(): array
    {
        return [
            TextInput::make('name')->required(),
        ];
    }

    public function createAction(): CreateAction
    {
        return CreateAction::make()
            ->model(Category::class)
            ->after(fn () => $this->dispatch('category-created'))
            ->schema($this->getFormSchema());
    }

    public function render()
    {
        return view('livewire.categories.create-category');
    }
}
