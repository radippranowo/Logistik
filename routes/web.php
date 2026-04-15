<?php
use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard\Index as DashboardIndex;
use App\Livewire\Barang\Index as BarangIndex;
use App\Livewire\Barang\Create as barangCreate;
use App\Livewire\Category\Index as CategoryIndex;
use App\Livewire\Merk\Index as MerkIndex;
use App\Livewire\Group\Index as GroupIndex;
use App\Models\Group;


use App\Http\Controllers\BarangController; // Pastikan ini di-import di atas
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', DashboardIndex::class)->name('dashboard.index');;
Route::prefix('barang')->name('barang.')->group(function () {
    Route::get('/', BarangIndex::class)->name('index'); // Jadi: barang.index
    Route::get('/create', BarangCreate::class)->name('create'); // Jadi: barang.create
});
Route::get('/category', CategoryIndex::class)->name('category.index');
Route::get('/merk', MerkIndex::class)->name('merk.index');
Route::get('/group', GroupIndex::class)->name('group.index');


Route::prefix('v2')->group(function () {
    // URL-nya akan menjadi: localhost:8000/v2/barang
    Route::get('/barang', [BarangController::class, 'index'])->name('barang.react.index');
    
    // URL untuk simpan data: localhost:8000/v2/barang (Metode POST)
    Route::post('/barang', [BarangController::class, 'store'])->name('barang.react.store');
});

Route::prefix('v2')->group(function () {
    // URL-nya akan menjadi: localhost:8000/v2/barang
    Route::get('/category', [CategoryController::class, 'index'])->name('category.react.index');
    
    // URL untuk simpan data: localhost:8000/v2/barang (Metode POST)
    Route::post('/category', [CategoryController::class, 'store'])->name('category.react.store');
});