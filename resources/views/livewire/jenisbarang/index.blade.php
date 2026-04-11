<div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Master Kategori</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <div class="search-box me-2 mb-2 d-inline-block">
                                <div class="position-relative">
                                    <input type="text" wire:model.live="search" class="form-control"
                                        placeholder="Cari Kategori...">
                                    <i class="bx bx-search-alt search-icon"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="text-sm-end">
                                <button type="button" wire:click="resetInput"
                                    class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2" 
                                    onclick="window.dispatchEvent(new CustomEvent('open-tambah-modal'))">
                                    <i class="mdi mdi-plus me-1"></i> Add New Category
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle table-nowrap table-check">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 20px;" class="align-middle">No</th>
                                    <th class="align-middle">Kode Kategori</th>
                                    <th class="align-middle">Nama Kategori</th>
                                    <th class="align-middle">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $index => $item)
                                    <tr>
                                        <td>{{ $categories->firstItem() + $index }}</td>
                                        <td><span class="badge badge-soft-primary font-size-12">{{ $item->kode_category }}</span></td>
                                        <td>{{ $item->nama_category }}</td>
                                        <td>
                                            <div class="d-flex gap-3">
                                                <a href="javascript:void(0);" wire:click="edit({{ $item->id }})" class="text-success" 
                                                   onclick="window.dispatchEvent(new CustomEvent('open-tambah-modal'))">
                                                    <i class="mdi mdi-pencil font-size-18"></i>
                                                </a>
                                                <a href="javascript:void(0);" wire:click="delete({{ $item->id }})" 
                                                   onclick="confirm('Menghapus kategori akan berdampak pada data barang terkait. Yakin?') || event.stopImmediatePropagation()" 
                                                   class="text-danger">
                                                    <i class="mdi mdi-delete font-size-18"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-3">
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div x-data="{ open: false }" x-init="window.addEventListener('open-tambah-modal', () => { open = true });
    window.addEventListener('close-modal', () => { open = false });" x-cloak wire:ignore>

        <div class="modal fade" :class="open ? 'show d-block' : 'd-none'" x-show="open" @click.self="open = false"
            @keydown.escape.window="open = false" style="background-color: rgba(0,0,0,0.5); z-index: 1060;">

            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $isEdit ? 'Edit Kategori' : 'Tambah Kategori Baru' }}</h5>
                        <button type="button" class="btn-close" @click="open = false"></button>
                    </div>
                    <form wire:submit.prevent="store">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label>Kode Kategori</label>
                                    <input type="text" wire:model="kode_category" class="form-control" placeholder="Misal: CTG01">
                                    @error('kode_category') <span class="text-danger small">{{ $message }}</span> @error
                                </div>
                                <div class="col-12 mb-3">
                                    <label>Nama Kategori</label>
                                    <input type="text" wire:model="nama_category" class="form-control" placeholder="Misal: Alat Berat">
                                    @error('nama_category') <span class="text-danger small">{{ $message }}</span> @error
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="open = false">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Kategori</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>