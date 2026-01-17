<?php

use App\Livewire\Home;
use App\Livewire\Order\CreateOrder;
use App\Livewire\Orders\OrderHistory;
use App\Models\Event;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::middleware('role:admin')->group(function () {
        Route::view('categories', 'pages.categories')->name('categories');

        Route::prefix('events')
            ->name('events.')
            ->group(function () {
                // route('events.index')
                Route::view('/', 'pages.events.index')->name('index');

                // route('events.create')
                Route::view('/create', 'pages.events.create')->name('create');

                // route('events.edit')
                Route::get('/{event}/edit', function (Event $event) {
                    return view('pages.events.edit', ['event' => $event]);
                })->name('edit');
            });
    });

    Route::middleware(['auth', 'role:user'])->group(function () {
        Route::get('/events/{event}/order', CreateOrder::class)->name('orders.create');
    });

    Route::get('/history', OrderHistory::class)->middleware('auth')->name('orders.history');
});

require __DIR__.'/settings.php';
