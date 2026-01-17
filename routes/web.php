<?php

use App\Models\Event;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

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

    // Route::middleware('role:user')->group(function () {
    //     Route::view('my-tickets', 'pages.tickets.my-tickets')->name('my-tickets');
    // });
});

require __DIR__ . '/settings.php';
