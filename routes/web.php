<?php
use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard\Index as DashboardIndex;
use App\Livewire\Barang\Index as BarangIndex;
use App\Livewire\Category\Index as CategoryIndex;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', DashboardIndex::class);
Route::get('/barang', BarangIndex::class);
Route::get('/category', CategoryIndex::class);