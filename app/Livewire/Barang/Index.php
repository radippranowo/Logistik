<?php

namespace App\Livewire\Barang;

use App\Models\Barang;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
        
  use WithPagination;
  public $search = '';
    public $barang_id, $kode_barang, $nama_barang, $category_code, $stok, $harga, $deskripsi;
    public $isEdit = false;

    public $perPage = 5; // Default menampilkan 10 data

    // Pastikan saat jumlah perPage diubah, halaman balik ke nomor 1
    public function updatingPerPage()
    {
        $this->resetPage();
    }
    // Fungsi Simpan (Tambah & Update)
    public function store()
    {
        $this->validate([
            'kode_barang'   => 'required|unique:barangs,kode_barang,' . $this->barang_id,
            'nama_barang'   => 'required',
            'category_code' => 'required',
            'stok'          => 'required|numeric',
            'harga'         => 'required|numeric',
        ]);

        Barang::updateOrCreate(['id' => $this->barang_id], [
            'kode_barang'   => $this->kode_barang,
            'nama_barang'   => $this->nama_barang,
            'category_code' => $this->category_code,
            'stok'          => $this->stok,
            'harga'         => $this->harga,
            'deskripsi'     => $this->deskripsi,
        ]);

        session()->flash('message', $this->isEdit ? 'Data Berhasil Diubah!' : 'Data Berhasil Ditambah!');
        $this->dispatch('close-modal'); // Menutup modal via Alpine
        $this->resetInput();
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $this->barang_id    = $id;
        $this->kode_barang  = $barang->kode_barang;
        $this->nama_barang  = $barang->nama_barang;
        $this->category_code = $barang->category_code;
        $this->stok         = $barang->stok;
        $this->harga        = $barang->harga;
        $this->deskripsi    = $barang->deskripsi;
        $this->isEdit       = true;
    }

    public function delete($id)
    {
        Barang::find($id)->delete();
        session()->flash('message', 'Data Dihapus!');
    }

    public function resetInput()
    {
        $this->reset(['barang_id', 'kode_barang', 'nama_barang', 'category_code', 'stok', 'harga', 'deskripsi', 'isEdit']);
    }

    public function render()
    {
       return view('livewire.barang.index', [
            'barangs' => Barang::with('kategori')
                ->where('nama_barang', 'like', '%' . $this->search . '%')
                ->latest()
                ->paginate($this->perPage), // Gunakan variabel perPage di sini
            'categories' => Category::all()
        ]);
    

        
    }
}
    

