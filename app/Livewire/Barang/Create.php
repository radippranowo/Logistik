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

   public function removeInput($id)
{
    // Cari index berdasarkan ID unik, bukan urutan baris
    $index = array_search($id, array_column($this->inputs, 'id'));

    if ($index !== false) {
        unset($this->inputs[$index]);
        // Re-index tetap perlu agar looping @foreach tidak error
        $this->inputs = array_values($this->inputs);
    }
}
public function updated($propertyName)
{
    // Ini akan menjalankan validasi hanya pada field yang sedang diubah saja
    $this->validateOnly($propertyName, [
        'inputs.*.kode_barang' => 'required|unique:barangs,kode_barang',
        'inputs.*.part_number' => 'unique:barangs,part_number',
        'inputs.*.nama_barang' => 'required|min:3',
        'inputs.*.category_code' => 'required',
        'inputs.*.merk_code' => 'required',
        'inputs.*.group_code' => 'required',
        'inputs.*.stok' => 'required|numeric',
    ], [
        'inputs.*.kode_barang.required' => 'Wajib diisi',
        'inputs.*.kode_barang.unique' => 'Kode Sudah ada',
        'inputs.*.part_number.unique' => 'Sudah ada',
        'inputs.*.nama_barang.required' => 'Wajib diisi',
        'inputs.*.category_code.required' => 'Wajib diisi',
        'inputs.*.merk_code.required' => 'Wajib diisi',
        'inputs.*.group_code.required' => 'Wajib diisi',
    ]);
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