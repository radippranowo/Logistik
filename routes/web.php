<?php
use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard\Index as DashboardIndex;
use App\Livewire\Barang\Index; // Sesuaikan dengan lokasi file PHP-nya
use App\Livewire\Barang\Create;
use App\Livewire\Category\Index as CategoryIndex;
use App\Livewire\Merk\Index as MerkIndex;
use App\Livewire\Group\Index as GroupIndex;
use App\Models\Group;

use App\Http\Controllers\DashboardController; // Pastikan ini di-import di atas
use App\Http\Controllers\BarangController; // Pastikan ini di-import di atas
use App\Http\Controllers\CategoryController;
use Inertia\Inertia;

// Route::get('/', function () {
//     return view('welcome');
// });



Route::get('/dashboard', DashboardIndex::class)->name('dashboard.index');;
// Route::prefix('barang')->name('barang.')->group(function () {
//     Route::get('/', BarangIndex::class)->name('index'); // Jadi: barang.index
//     Route::get('/create', BarangCreate::class)->name('create'); // Jadi: barang.create
// });
Route::get('/category', CategoryIndex::class)->name('category.index');
Route::get('/merk', MerkIndex::class)->name('merk.index');
Route::get('/group', GroupIndex::class)->name('group.index');


// Gunakan 'prefix' untuk mengatur URL, bukan middleware
Route::prefix('barang')->group(function () {
    
    // Halaman Utama Barang (URL: domain.com/barang)
    // Pastikan file ada di: resources/views/livewire/barang/index.blade.php
    Route::livewire('/', 'barang.index')->name('barang.index');
    
    // Halaman Tambah Barang (URL: domain.com/barang/create)
    // Pastikan file ada di: resources/views/livewire/barang/create.blade.php
    Route::livewire('/create', 'barang.create')->name('barang.create');
    
});