<?php

namespace App\Livewire\Order;

use App\Models\Event;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Ticket;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.guest')]
class CreateOrder extends Component
{
    public Event $event;

    public $quantities = [];

    public function mount(Event $event)
    {
        $this->event = $event;

        foreach ($event->tickets as $ticket) {
            $this->quantities[$ticket->id] = 0;
        }
    }

    public function getTotalProperty()
    {
        $total = 0;
        foreach ($this->event->tickets as $ticket) {
            $qty = (int) ($this->quantities[$ticket->id] ?? 0);
            $total += $qty * $ticket->price;
        }

        return $total;
    }

    public function checkout()
    {
        $this->validate([
            'quantities.*' => 'required|integer|min:0',
        ]);

        if ($this->total <= 0) {
            $this->addError('global', 'Silakan pilih minimal satu tiket.');

            return;
        }

        DB::transaction(function () {
            $order = Order::create([
                'user_id' => Auth::id(),
                'event_id' => $this->event->id,
                'order_date' => now(),
                'total_price' => $this->total,
            ]);

            foreach ($this->quantities as $ticketId => $qty) {
                $qty = (int) $qty;

                if ($qty > 0) {
                    $ticket = Ticket::find($ticketId);

                    if ($ticket->stock < $qty) {
                        throw new \Exception("Stok tiket {$ticket->type} tidak mencukupi.");
                    }

                    OrderDetail::create([
                        'order_id' => $order->id,
                        'ticket_id' => $ticket->id,
                        'quantity' => $qty,
                        'sub_total' => $ticket->price * $qty,
                    ]);

                    $ticket->decrement('stock', $qty);
                }
            }
        });

        session()->flash('success', 'Order berhasil dibuat!');

        Notification::make()
            ->title('Order Berhasil')
            ->success()
            ->send();

        return redirect()->route('orders.history');
    }

    public function render()
    {
        return view('livewire.order.create-order');
    }
}
