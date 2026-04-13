<?php

namespace App\Livewire\Group;

use App\Models\Group;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $group_id, $kode_group, $nama_group;
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
            'kode_group' => 'required|unique:groups,kode_group,' . $this->group_id,
            'nama_group' => 'required',
        ]);

        Group::updateOrCreate(['id' => $this->group_id], [
            'kode_group' => $this->kode_group,
            'nama_group' => $this->nama_group,
        ]);

        $this->dispatch('close-modal'); // Menutup modal via Alpine
        $this->resetInput();
    }

    public function edit($id)
    {
        $cat = Group::findOrFail($id);
        $this->group_id = $id;
        $this->kode_group = $cat->kode_group;
        $this->nama_group = $cat->nama_group;
        $this->isEdit = true;
    }

    public function delete($id)
    {
        Group::find($id)->delete();
    }

    public function resetInput()
    {
        $this->reset(['group_id', 'kode_group', 'nama_group', 'isEdit']);
    }

    public function render()
    {
        return view('livewire.group.index', [
            'groups' => Group::where('nama_group', 'like', '%' . $this->search . '%')
                ->orWhere('kode_group', 'like', '%' . $this->search . '%')
                ->latest()
                 ->paginate($this->perPage),
        ]);
    }
}
