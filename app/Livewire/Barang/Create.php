<?php

namespace App\Livewire\Barang;

use App\Models\Barang;
use App\Models\Category;
use App\Models\Group;
use App\Models\Merk;
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
        // Gunakan key unik 'id' agar Livewire tidak bingung saat re-render
        $this->inputs[] = [
            'id' => uniqid(), 
            'kode_barang' => '',
            'part_number' => '',
            'nama_barang' => '',
            'category_code' => '',
            'merk_code' => '',
            'group_code' => '',
            'stok' => 0,
            'harga' => 0,
            'deskripsi' => ''
        ];
    }

    public function removeInput($index)
    {
       // Langsung hapus dari array berdasarkan index
    unset($this->inputs[$index]);
    
    // Reset index array agar tetap berurutan (0, 1, 2...)
    $this->inputs = array_values($this->inputs);
    }

    public function save()
    {
        $this->validate([
            'inputs.*.kode_barang' => 'required|unique:barangs,kode_barang',
            'inputs.*.part_number' => 'unique:barangs,part_number',
            'inputs.*.nama_barang' => 'required|min:3',
            'inputs.*.category_code' => 'required',
            'inputs.*.merk_code' => 'required',
            'inputs.*.group_code' => 'required',
            'inputs.*.stok' => 'required|numeric',
        ], [
            'inputs.*.kode_barang.required' => 'Wajib diisi',
            'inputs.*.kode_barang.unique' => 'Sudah ada',
            'inputs.*.part_number.unique' => 'Sudah ada',
            'inputs.*.nama_barang.required' => 'Wajib diisi',
            'inputs.*.category_code.required' => 'Wajib diisi',
            'inputs.*.merk_code.required' => 'Wajib diisi',
            'inputs.*.group_code.required' => 'Wajib diisi',
            // ... pesan lainnya
        ]);

        foreach ($this->inputs as $item) {
            // Hapus 'id' sementara sebelum insert ke database jika 'id' bukan kolom tabel
            $data = $item;
            unset($data['id']); 
            
            Barang::create($data);
        }

        session()->flash('success', 'Data Berhasil Disimpan');
        return $this->redirectRoute('barang.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.barang.create', [
            'categories' => Category::all(),
            'merks' => Merk::all(),
            'groups' => Group::all()
        ]);
    }
}