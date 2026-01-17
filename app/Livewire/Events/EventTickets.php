<?php

namespace App\Livewire\Events;

use App\Enums\TicketType;
use App\Models\Event;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\RawJs;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class EventTickets extends Component implements HasActions, HasForms, HasTable
{
    use InteractsWithActions;
    use InteractsWithForms;
    use InteractsWithTable;

    public $event;

    public function mount(Event $event): void
    {
        $this->event = $event;
    }

    public function getFormSchema(): array
    {
        return [
            Select::make('type')
                ->options(TicketType::class)
                ->native(false)
                ->required(),
            TextInput::make('stock')
                ->required()
                ->numeric()
                ->default(1)
                ->minValue(1),
            TextInput::make('price')
                ->required()
                ->prefix('IDR')
                ->mask(RawJs::make('$money($input)'))
                ->stripCharacters(',')
                ->numeric()
                ->step(1000)
                ->minValue(0),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->relationship(fn () => $this->event->tickets())
            ->heading('Tickets')
            ->searchable()
            ->columns([
                TextColumn::make('type')->sortable()->badge(),
                TextColumn::make('stock')->sortable(),
                TextColumn::make('price')->money('IDR'),
                TextColumn::make('created_at')->dateTime()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->headerActions([
                CreateAction::make()->schema($this->getFormSchema()),
            ])
            ->recordActions([
                EditAction::make()->schema($this->getFormSchema()),
                DeleteAction::make(),
            ]);
    }

    public function render()
    {
        return view('livewire.events.event-tickets');
    }
}
