<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;
use Livewire\Component;

class ListCategories extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithSchemas;
    use InteractsWithTable;

    public function getFormSchema(): array
    {
        return [
            TextInput::make('name')->required(),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Category::query())
            ->searchable()
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([])
            ->recordActions([
                DeleteAction::make(),
                EditAction::make()->schema($this->getFormSchema()),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }

    #[On('category-created')]
    public function refreshTable(): void
    {
        // Livewire akan otomatis me-render ulang komponen saat fungsi ini dipicu
    }

    public function render(): View
    {
        return view('livewire.categories.list-categories');
    }
}
