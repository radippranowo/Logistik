<?php

namespace App\Livewire\Barang;

use App\Models\Barang;
use App\Models\Category;
use App\Models\Group;
use App\Models\Merk;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{

    use WithPagination;
    public $search = '';
    public $barang_id, $kode_barang, $part_number, $nama_barang, $category_code, $merk_code, $group_code, $stok, $harga, $deskripsi;
    public $isEdit = false;

    public $perPage = 5; // Default menampilkan 10 data


    // Pastikan saat jumlah perPage diubah, halaman balik ke nomor 1
    public function updatingPerPage()
    {
        $this->resetPage();
    }
    // Fungsi Simpan (Tambah & Update)

    public function rules()
    {
        return [
            'kode_barang' => 'required|unique:barangs,kode_barang,' . $this->barang_id,
            'part_number' => 'required|unique:barangs,part_number,' . $this->barang_id,
            'nama_barang' => 'required|',
            'category_code' => 'required|',
            'merk_code' => 'required|',
            'group_code' => 'required|',
        ];
    }

    public function messages()
    {
        return [
            'kode_barang.required' => 'Kode barang wajib diisi!',
            'kode_barang.unique'   => 'Kode ini sudah terdaftar!',
            'part_number.unique'   => 'Part Number ini sudah terdaftar!',
            'nama_barang.required' => 'Nama barang tidak boleh kosong!',
            'category_code.required' => 'Categori tidak boleh kosong!',
            'merk_code.required' => 'Merk tidak boleh kosong!',
            'group_code.required' => 'Group tidak boleh kosong!',
        ];
    }

    public function store()
    {

        $this->validate();

        // Jika lolos validasi, lanjut simpan
        Barang::updateOrCreate(['id' => $this->barang_id], [
            'kode_barang'   => $this->kode_barang,
            'part_number'   => $this->part_number,
            'nama_barang'   => $this->nama_barang,
            'category_code' => $this->category_code,
            'merk_code' => $this->merk_code,
            'group_code' => $this->group_code,
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
        $this->resetValidation();
        $barang = Barang::findOrFail($id);
        $this->barang_id    = $id;
        $this->kode_barang  = $barang->kode_barang;
        $this->part_number  = $barang->part_number;
        $this->nama_barang  = $barang->nama_barang;
        $this->category_code = $barang->category_code;
        $this->merk_code = $barang->merk_code;
        $this->group_code = $barang->group_code;
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
        $this->reset(['barang_id', 'kode_barang', 'part_number','nama_barang', 'category_code', 'merk_code', 'group_code', 'stok', 'harga', 'deskripsi', 'isEdit']);
    }

    public function render()
    {
        return view('livewire.barang.index', [
            'barangs' => Barang::with(['kategori', 'merk', 'group']) // Masukkan semua nama relasi dalam array
                ->where('nama_barang', 'like', '%' . $this->search . '%')
                ->latest()
                ->paginate($this->perPage),
            'categories' => Category::all(),
            'merks' => Merk::all(),
            'groups' => Group::all()
        ]);
    }
}
