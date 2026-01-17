<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Event;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('layouts.guest')]
class Home extends Component
{
    #[Url]
    public $kategori = '';

    #[Url]
    public $search = '';

    // 1. Tambahkan variabel untuk menampung event yang dipilih
    public ?Event $selectedEvent = null;

    // 2. Method untuk membuka modal
    public function showEvent(Event $event)
    {
        $this->selectedEvent = $event;
    }

    // 3. Method untuk menutup modal
    public function closeModal()
    {
        $this->selectedEvent = null;
    }

    public function render()
    {
        $categories = Category::all();

        $events = Event::query()
            ->when($this->kategori, function ($query) {
                $query->where('category_id', $this->kategori);
            })
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%'.$this->search.'%');
            })
            ->orderBy('datetime', 'asc')
            ->get();

        return view('livewire.home', [
            'categories' => $categories,
            'events' => $events,
        ]);
    }
}
