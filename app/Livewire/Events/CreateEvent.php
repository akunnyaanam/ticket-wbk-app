<?php

namespace App\Livewire\Events;

use App\Models\Event;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class CreateEvent extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()->schema([
                    Select::make('category_id')
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->relationship('category', 'name')
                        ->required(),
                    TextInput::make('title')->required(),
                    Textarea::make('description')->columnSpanFull(),
                    TextInput::make('location')->required(),
                    DateTimePicker::make('datetime')->native(false)->required(),
                    FileUpload::make('image_path')->image(),
                ]),
            ])
            ->statePath('data')
            ->model(Event::class);
    }

    public function create(): void
    {
        $data = $this->form->getState();

        $data['user_id'] = auth()->id();

        $record = Event::create($data);

        $this->form->model($record)->saveRelationships();

        Notification::make()
            ->title('Created!')
            ->success()
            ->send();

        $this->redirect(route('events.edit', ['event' => $record]), navigate: true);
    }

    public function render(): View
    {
        return view('livewire.events.create-event');
    }
}
