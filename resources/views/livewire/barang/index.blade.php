<div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Barang</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-8">
                            <div class="d-flex align-items-center gap-2">
                                <div class="search-box">
                                    <div class="position-relative">
                                        <input type="text" wire:model.live="search" class="form-control btn-rounded"
                                            placeholder="Cari..." style="padding-left: 40px;">
                                        <i class="bx bx-search-alt search-icon" style="left: 13px;"></i>
                                    </div>
                                </div>
                                <div class="dropdown custom-no-anim">
                                    <button class="btn btn-light btn-rounded shadow-sm border dropdown-toggle"
                                        type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false" style="min-width: 70px; transition: none;">
                                        {{ $perPage }} <i class="mdi mdi-chevron-down ms-1"></i>
                                    </button>
                                    <ul class="dropdown-menu shadow rounded-4 border-0 mt-2"
                                        style="transition: none; min-width: 60px; position: absolute; z-index: 1000;">
                                        <li><a class="dropdown-item rounded-3" href="javascript:void(0);"
                                                wire:click="$set('perPage', 5)" style="transition: none;">5</a></li>
                                        <li><a class="dropdown-item rounded-3" href="javascript:void(0);"
                                                wire:click="$set('perPage', 10)" style="transition: none;">10</a></li>
                                        <li><a class="dropdown-item rounded-3" href="javascript:void(0);"
                                                wire:click="$set('perPage', 25)" style="transition: none;">50</a></li>
                                        <li><a class="dropdown-item rounded-3" href="javascript:void(0);"
                                                wire:click="$set('perPage', 50)" style="transition: none;">100</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="text-sm-end">
                                <button type="button" class="btn btn-success btn-rounded waves-effect waves-light mb-2"
                                    onclick="window.dispatchEvent(new CustomEvent('open-tambah-modal'))">
                                    <i class="mdi mdi-plus me-1"></i> Add New Barang
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle table-nowrap table-check">
                            <thead class="table-light">
                                <tr>
                                    <th class="align-middle" style="width: 50px;">No</th>
                                    <th class="align-middle">Kode</th>
                                    <th class="align-middle">Nama</th>
                                    <th class="align-middle">Category</th>
                                    <th class="align-middle">Stok</th>
                                    <th class="align-middle">Harga</th>
                                    <th class="align-middle">Deskripsi</th>
                                    <th class="align-middle">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($barangs as $item)
                                    <tr>
                                        {{-- Jika pakai pagination, gunakan rumus ini agar nomor berlanjut di halaman berikutnya --}}
                    <td>{{ ($barangs->currentPage() - 1) * $barangs->perPage() + $loop->iteration }}</td>
                                        <td>{{ $item->kode_barang }}</td>
                                        <td>{{ $item->nama_barang }}</td>
                                        <td>{{ $item->kategori->nama_category }}</td>
                                            <td><span class="badge badge-pill badge-soft-info font-size-12">
                                                {{ $item->stok ?? 'N/A' }}
                                            </span>
                                            </td>
                                        <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                        <td> {{$item->deskripsi}}</td>
                                        <td>  
                                            <div class="d-flex gap-3">
                                                <a href="javascript:void(0);" wire:click="edit({{ $item->id }})"
                                                    class="text-success"
                                                    onclick="window.dispatchEvent(new CustomEvent('open-tambah-modal'))">
                                                    <i class="mdi mdi-pencil font-size-18"></i>
                                                </a>
                                                <a href="javascript:void(0);" wire:click="delete({{ $item->id }})"
                                                    onclick="confirm('Yakin ingin menghapus?') || event.stopImmediatePropagation()"
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
                        <h5 class="modal-title">{{ $isEdit ? 'Edit Barang' : 'Add New Barang' }}</h5>
                        <button type="button" class="btn-close" @click="open = false"></button>
                    </div>
                    <form wire:submit.prevent="store">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label>Kode Barang</label>
                                    <input type="text" wire:model="kode_barang" class="form-control">
                                </div>
                                <div class="col-12 mb-3">
                                    <label>Nama Barang</label>
                                    <input type="text" wire:model="nama_barang" class="form-control">
                                </div>
                                <div class="col-12 mb-3">
                                    <label>Kategori</label>
                                    <select class="form-control" wire:model="category_code">
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->kode_category }}">{{ $cat->nama_category }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6 mb-3">
                                    <label>Stok</label>
                                    <input type="number" wire:model="stok" class="form-control">
                                </div>
                                <div class="col-6 mb-3">
                                    <label>Harga</label>
                                    <input type="number" wire:model="harga" class="form-control">
                                </div>
                                <div class="col-12 mb-3">
                                    <label>Deskripsi</label>
                                    <textarea wire:model="deskripsi" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="open = false">Close</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
