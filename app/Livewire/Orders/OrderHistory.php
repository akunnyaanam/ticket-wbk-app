<?php

namespace App\Livewire\Orders;

use App\Enums\UserRole;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app', ['title' => 'Riwayat Pembelian'])]
class OrderHistory extends Component
{
    use WithPagination;

    #[Url]
    public $startDate = '';

    #[Url]
    public $endDate = '';

    public function mount()
    {
        if (empty($this->startDate)) {
            $this->startDate = now()->format('Y-m-d');
        }

        if (empty($this->endDate)) {
            $this->endDate = now()->format('Y-m-d');
        }
    }

    public function updatedStartDate()
    {
        $this->resetPage();
    }

    public function updatedEndDate()
    {
        $this->resetPage();
    }

    public function render()
    {
        $user = Auth::user();

        $orders = Order::query()
            ->with(['event', 'orderDetails.ticket', 'user'])
            ->when($this->startDate, function ($query) {
                $query->whereDate('order_date', '>=', $this->startDate);
            })
            ->when($this->endDate, function ($query) {
                $query->whereDate('order_date', '<=', $this->endDate);
            })
            ->latest('order_date');

        if ($user->role !== UserRole::ADMIN) {
            $orders->where('user_id', $user->id);
        }

        return view('livewire.orders.order-history', [
            'orders' => $orders->paginate(10),
        ]);
    }
}
