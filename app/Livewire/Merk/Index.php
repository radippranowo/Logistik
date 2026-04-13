<?php

namespace App\Livewire\Merk;

use App\Models\Merk;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $merk_id, $kode_merk, $nama_merk;
    public $search = '';
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
            'kode_merk' => 'required|unique:merks,kode_merk,' . $this->merk_id,
            'nama_merk' => 'required',
        ]);

        Merk::updateOrCreate(['id' => $this->merk_id], [
            'kode_merk' => $this->kode_merk,
            'nama_merk' => $this->nama_merk,
        ]);

        $this->dispatch('close-modal'); // Menutup modal via Alpine
        $this->resetInput();
    }

    public function edit($id)
    {
        $cat = Merk::findOrFail($id);
        $this->merk_id = $id;
        $this->kode_merk = $cat->kode_merk;
        $this->nama_merk = $cat->nama_merk;
        $this->isEdit = true;
    }

    public function delete($id)
    {
        Merk::find($id)->delete();
    }

    public function resetInput()
    {
        $this->reset(['merk_id', 'kode_merk', 'nama_merk', 'isEdit']);
    }

    public function render()
    {
        return view('livewire.merk.index', [
            'merks' => Merk::where('nama_merk', 'like', '%' . $this->search . '%')
                ->orWhere('kode_merk', 'like', '%' . $this->search . '%')
                ->latest()
                 ->paginate($this->perPage),
        ]);
    }
}
