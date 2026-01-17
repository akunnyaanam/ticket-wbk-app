<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')->middleware(['auth', 'verified'])->name('dashboard');

Route::view('categories', 'pages.categories')->middleware(['auth', 'verified'])->name('categories');
Route::view('events', 'pages.events.index')->middleware(['auth', 'verified'])->name('events');
Route::view('events/create', 'pages.events.create')->middleware(['auth', 'verified'])->name('events.create');

require __DIR__ . '/settings.php';
