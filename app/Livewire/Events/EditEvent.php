<?php

namespace App\Livewire\Events;

use App\Models\Event;
use Filament\Actions\Action;
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

class EditEvent extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public Event $record;

    public ?array $data = [];

    public function mount(Event $event): void
    {
        $this->record = $event;

        $this->form->fill($this->record->attributesToArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->heading('Edit Event')
                    ->collapsed()
                    ->schema([
                        Select::make('user_id')->relationship('user', 'name')->required(),
                        Select::make('category_id')->relationship('category', 'name')->required(),
                        TextInput::make('title')->required(),
                        Textarea::make('description')->columnSpanFull(),
                        TextInput::make('location')->required(),
                        DateTimePicker::make('datetime')->required(),
                        FileUpload::make('image_path')->image(),
                    ])
                    ->footer([
                        Action::make('save')->action(fn() => $this->save()),
                    ]),
            ])
            ->statePath('data')
            ->model($this->record);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $this->record->update($data);

        Notification::make()
            ->title('Updated!')
            ->success()
            ->send();

        // $this->redirect(route('events'), navigate: true);
    }

    public function render(): View
    {
        return view('livewire.events.edit-event');
    }
}
