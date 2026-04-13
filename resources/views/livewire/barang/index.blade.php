<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body border-bottom">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0 card-title flex-grow-1">Data Barang</h5>
                        <div class="flex-shrink-0">
                            <button wire:navigate href="{{ route('barang.create') }}" type="button"
                                class="btn btn-success btn-rounded waves-effect waves-light mb-2">
                                <i class="mdi mdi-plus me-1"></i>Barang
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-8">
                            <div class="d-flex align-items-center gap-2">
                                <div class="search-box">
                                    <div class="position-relative">
                                        <input wire:model.live.debounce.500ms="search" type="text"
                                            class="form-control btn-rounded" placeholder="Cari barang..."
                                            style="padding-left: 40px;">
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

                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle table-nowrap table-check">
                            <thead class="table-light">
                                <tr>
                                    <th class="align-middle" style="width: 50px;">No</th>
                                    <th class="align-middle">Kode</th>
                                    <th class="align-middle">Part Number</th>
                                    <th class="align-middle">Nama</th>
                                    <th class="align-middle">Kategori</th>
                                    <th class="align-middle">Merk</th>
                                    <th class="align-middle">Group</th>
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
                                        <td>{{ ($barangs->currentPage() - 1) * $barangs->perPage() + $loop->iteration }}
                                        </td>
                                        <td>{{ $item->kode_barang }}</td>
                                        <td>{{ $item->part_number }}</td>
                                        <td>{{ $item->nama_barang }}</td>
                                        <td>{{ $item->kategori->nama_category }}</td>
                                        <td>{{ $item->merk->nama_merk }}</td>
                                        <td>{{ $item->group->nama_group }}</td>
                                        <td><span class="badge badge-pill badge-soft-info font-size-12">
                                                {{ $item->stok ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                        <td> {{ $item->deskripsi }}</td>
                                        <td>
                                            <div class="d-flex gap-3">
                                                <a href="javascript:void(0);" wire:click="edit({{ $item->id }})"
                                                    class="text-success">
                                                    <i class="mdi mdi-pencil font-size-18"></i>
                                                </a>
                                                <a href="javascript:void(0);" class="text-danger"
                                                    wire:click="$dispatch('confirm-delete', { id: {{ $item->id }}, nama: '{{ $item->nama_barang }}' })">
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

    <div wire:ignore.self class="modal fade orderdetailsModal" id="modalEditBarang" tabindex="-1" role="dialog"
        aria-labelledby="orderdetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-m" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderdetailsModalLabel">Edit Data Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit.prevent="update">
                    <div class="modal-body">
                        <div wire:loading wire:target="edit" class="text-center p-5 w-100">
                            <div class="spinner-border text-primary" role="status"></div>
                            <p class="mt-2 text-muted">Sinkronisasi data...</p>
                        </div>

                        <div class="row" wire:loading.remove wire:target="edit">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Kode Barang</label>
                                <input type="text" wire:model="kode_barang"
                                    class="form-control @error('kode_barang') is-invalid @enderror">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Part Number</label>
                                <input type="text" wire:model="part_number" class="form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Nama Barang</label>
                                <input type="text" wire:model="nama_barang" class="form-control">
                            </div>

                            <div class="col-md-4 mb-3" wire:ignore>
                                <label class="form-label">Kategori</label>
                                <select wire:model="category_code" class="form-control select2">
                                    <option value="">Pilih</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->kode_category }}">{{ $cat->nama_category }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3" wire:ignore>
                                <label class="form-label">Merk</label>
                                <select wire:model="merk_code" class="form-control select2">
                                    <option value="">Pilih</option>
                                    @foreach ($merks as $m)
                                        <option value="{{ $m->kode_merk }}">{{ $m->nama_merk }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3" wire:ignore>
                                <label class="form-label">Group</label>
                                <select wire:model="group_code" class="form-control select2">
                                    <option value="">Pilih</option>
                                    @foreach ($groups as $g)
                                        <option value="{{ $g->kode_group }}">{{ $g->nama_group }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Stok</label>
                                <input type="number" wire:model="stok" class="form-control">
                            </div>
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Harga Satuan</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" wire:model="harga" class="form-control">
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Deskripsi</label>
                                <textarea wire:model="deskripsi" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary px-4" wire:loading.attr="disabled">Update
                            Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('livewire:init', () => {
            // Inisialisasi modal menggunakan class bawaan Anda
            const editModal = new bootstrap.Modal(document.querySelector('.orderdetailsModal'));

            Livewire.on('open-edit-modal', () => {
                editModal.show();
            });

            Livewire.on('close-modal', () => {
                editModal.hide();
            });
        });
    </script>
    {{-- <script>
    document.addEventListener('livewire:navigated', () => { // Gunakan ini jika pakai Livewire 3
        initSelect2();
    });

    function initSelect2() {
        $('#select2-category').select2({
            dropdownParent: $('.modal'), // Agar dropdown muncul di atas modal
            width: '100%' // Agar lebar select penuh
        });

        // Sinkronisasi Select2 dengan Livewire
        $('#select2-category').on('change', function(e) {
            var data = $('#select2-category').select2("val");
            @this.set('category_code', data);
        });
    }

    // Inisialisasi ulang saat modal dibuka via Alpine
    window.addEventListener('open-tambah-modal', () => {
        setTimeout(() => {
            initSelect2();
        }, 100);
    });
</script> --}}

    <script>
        // Listener Konfirmasi Hapus
        window.addEventListener('confirm-delete', event => {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Barang " + event.detail.nama + " akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#34c38f', // warna sukses bootstrap
                cancelButtonColor: '#f46a6a', // warna danger bootstrap
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Memanggil fungsi delete di Class Livewire
                    @this.call('delete', event.detail.id);
                }
            });
        });

        // Listener Sukses (Bisa digunakan untuk Save/Edit/Delete)
        window.addEventListener('swal:success', event => {
            Swal.fire({
                title: 'Berhasil!',
                text: event.detail.message,
                icon: 'success',
                timer: 2000,
                showConfirmButton: false
            });
        });
    </script>
    @if (session()->has('success'))
        <script>
            Swal.fire({
                title: "Berhasil!",
                text: "{{ session('success') }}",
                icon: "success"
            });
        </script>
    @endif
</div>
