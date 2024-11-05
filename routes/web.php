<?php

use App\Livewire\BannerList;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/vendors', function () {
        return view('livewire.vendors.index');
    })->name('vendors');

    Route::get('/banners', BannerList::class)->name('banners');
//    Route::get('/vendors', \App\Livewire\Vendor::class)->name('vendors');
});
