<?php

namespace App\Livewire\Category;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $category_id, $kode_category, $nama_category;
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
            'kode_category' => 'required|unique:categorys,kode_category,' . $this->category_id,
            'nama_category' => 'required',
        ]);

        Category::updateOrCreate(['id' => $this->category_id], [
            'kode_category' => $this->kode_category,
            'nama_category' => $this->nama_category,
        ]);

        $this->dispatch('close-modal'); // Menutup modal via Alpine
        $this->resetInput();
    }

    public function edit($id)
    {
        $cat = Category::findOrFail($id);
        $this->category_id = $id;
        $this->kode_category = $cat->kode_category;
        $this->nama_category = $cat->nama_category;
        $this->isEdit = true;
    }

    public function delete($id)
    {
        Category::find($id)->delete();
    }

    public function resetInput()
    {
        $this->reset(['category_id', 'kode_category', 'nama_category', 'isEdit']);
    }

    public function render()
    {
        return view('livewire.category.index', [
            'categories' => Category::where('nama_category', 'like', '%' . $this->search . '%')
                ->orWhere('kode_category', 'like', '%' . $this->search . '%')
                ->latest()
                 ->paginate($this->perPage),
        ]);
    }
}
