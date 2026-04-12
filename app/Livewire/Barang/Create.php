<?php

namespace App\Livewire\Barang;

use App\Models\Barang;
use App\Models\Category;
use Livewire\Component;

class Create extends Component
{
    public $inputs = [];

    public function mount()
    {
        $this->addInput();
    }

    public function addInput()
    {
        $this->inputs[] = [
            'kode_barang' => '',
            'nama_barang' => '',
            'category_code' => '',
            'stok' => 0,
            'harga' => 0,
            'deskripsi' => ''
        ];
    }

    public function removeInput($index)
    {
        unset($this->inputs[$index]);
        $this->inputs = array_values($this->inputs);
    }

    public function save()
    {
        // Validasi untuk semua input di dalam array
        $this->validate([
            'inputs.*.kode_barang' => 'required|unique:barangs,kode_barang',
            'inputs.*.nama_barang' => 'required|min:3',
            'inputs.*.category_code' => 'required',
            'inputs.*.stok' => 'required|numeric',
            'inputs.*.harga' => 'required|numeric',
        ], [
            'inputs.*.kode_barang.required' => 'Kode wajib diisi',
            'inputs.*.nama_barang.required' => 'Nama wajib diisi',
            'inputs.*.category_code' => 'Categori wajib diisi',
            
            
           
        ]);

        foreach ($this->inputs as $item) {
            Barang::create($item);
        }

        return redirect()->route('barang.index')->with('success', 'Data Berhasil Ditambah!');
    }

    public function render()
    {
        return view('livewire.barang.create', [
            'categories' => Category::all()
        ]);
    }
}