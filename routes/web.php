<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')->middleware(['auth', 'verified'])->name('dashboard');

Route::view('categories', 'pages.categories')->middleware(['auth', 'verified'])->name('categories');

require __DIR__ . '/settings.php';
