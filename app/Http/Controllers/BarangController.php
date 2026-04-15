<?php

// app/Http/Controllers/BarangController.php
namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BarangController extends Controller
{
    public function index()
    {
        return Inertia::render('Barang/Index', [
            'barangs' => Barang::with(['kategori'])->latest()->get(),
            'categories' => Category::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required',
            'category_code' => 'required',
            'stok' => 'required|integer',
        ]);

        Barang::create($validated);

        return redirect()->route('barang.index')->with('message', 'Barang berhasil ditambah!');
    }
}