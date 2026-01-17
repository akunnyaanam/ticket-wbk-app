<?php

namespace App\Livewire\Events;

use App\Models\Event;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\EditAction;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Livewire\Component;

class ListEvents extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithSchemas;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Event::query())
            ->columns([
                TextColumn::make('user.name')->searchable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('title')
                    ->description(fn (Event $model) => Str::limit($model->description ?? 'No Description', 50))
                    ->searchable(),
                TextColumn::make('category.name')->searchable()->sortable(),
                TextColumn::make('datetime')
                    ->label('Date and Location')
                    ->description(fn (Event $model) => $model->location ?? '')
                    ->dateTime()
                    ->sortable(),
                ImageColumn::make('image_path')->toggleable(isToggledHiddenByDefault: true),
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
            ->headerActions([
                //
            ])
            ->recordActions([
                EditAction::make()->url(fn (Event $record): string => route('events.edit', $record)),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }

    public function render(): View
    {
        return view('livewire.events.list-events');
    }
}
