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
        $this->inputs[] = [
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
        unset($this->inputs[$index]);
        $this->inputs = array_values($this->inputs);
    }

    public function save()
    {
        // Validasi untuk semua input di dalam array
        $this->validate([
            'inputs.*.kode_barang' => 'required|unique:barangs,kode_barang',
            'inputs.*.part_number' => 'unique:barangs,part_number',
            'inputs.*.nama_barang' => 'required|min:3',
            'inputs.*.category_code' => 'required',
            'inputs.*.merk_code' => 'required',
            'inputs.*.group_code' => 'required',
            'inputs.*.stok' => 'required|numeric',
            'inputs.*.harga' => 'required|numeric',
        ], [
            'inputs.*.kode_barang.required' => 'Kode wajib diisi',
            'inputs.*.part_number.unique' => 'Part number sudah tersedia',
            'inputs.*.nama_barang.required' => 'Nama wajib diisi',
            'inputs.*.category_code' => 'Categori wajib diisi',
            'inputs.*.merk_code' => 'Merk wajib diisi',
            'inputs.*.group_code' => 'Group wajib diisi',
            
            
           
        ]);

        foreach ($this->inputs as $item) {
            Barang::create($item);
        }

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