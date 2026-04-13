<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body border-bottom">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0 card-title flex-grow-1">Data Barang</h5>
                        <div class="flex-shrink-0">
                            <button wire:navigate href="{{ route('barang.index') }}" type="button"
                                class="btn btn-primary btn-rounded waves-effect waves-light mb-2">
                                <i class="mdi mdi-arrow-left me-1"></i>Kembali
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form class="repeater" wire:submit.prevent="save">
                        <div class="table-responsive">
                            <table class="table table-bordered table-nowrap align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 10%;">Kode<span class="text-danger"></span></th>
                                        <th style="width: 15%;">Part Number<span class="text-danger"></span></th>
                                        <th style="width: 15%;">Nama<span class="text-danger"></span></th>
                                        <th style="width: 15%;">Kategori <span class="text-danger"></span></th>
                                        <th style="width: 15%;">Merk <span class="text-danger"></span></th>
                                        <th style="width: 15%;">Group <span class="text-danger"></span></th>
                                        <th style="width: 8%;">Stok</th>
                                        {{-- <th style="width: 15%;">Harga</th> --}}
                                        {{-- <th style="width: 20%;">Deskripsi</th> --}}
                                        <th style="width: 5%;" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody data-repeater-list="group-a">
                                    @foreach ($inputs as $index => $item)
                                        <tr data-repeater-item key="row-{{ $index }}">
                                            <td>
                                                <input type="text"
                                                    wire:model="inputs.{{ $index }}.kode_barang"
                                                    class="form-control form-control-sm @error('inputs.' . $index . '.kode_barang') is-invalid @enderror">
                                                @error('inputs.' . $index . '.kode_barang')
                                                    <div class="invalid-feedback font-size-11">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td>
                                                <input type="text"
                                                    wire:model="inputs.{{ $index }}.part_number"
                                                    class="form-control form-control-sm @error('inputs.' . $index . '.part_number') is-invalid @enderror">
                                                @error('inputs.' . $index . '.part_number')
                                                    <div class="invalid-feedback font-size-11">{{ $message }}</div>
                                                @enderror
                                            </td>

                                            <td>
                                                <input type="text"
                                                    wire:model="inputs.{{ $index }}.nama_barang"
                                                    class="form-control form-control-sm @error('inputs.' . $index . '.nama_barang') is-invalid @enderror">
                                                @error('inputs.' . $index . '.nama_barang')
                                                    <div class="invalid-feedback font-size-11">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td>
                                                <select wire:model="inputs.{{ $index }}.category_code"
                                                    class="form-select form-select-sm @error('inputs.' . $index . '.category_code') is-invalid @enderror">
                                                    <option value="">Pilih</option>
                                                    @foreach ($categories as $cat)
                                                        <option value="{{ $cat->kode_category }}">
                                                            {{ $cat->nama_category }}</option>
                                                    @endforeach
                                                </select>
                                                @error('inputs.' . $index . '.category_code')
                                                    <div class="invalid-feedback font-size-11">{{ $message }}
                                                    </div>
                                                @enderror

                                            </td>
                                            <td>
                                                <select wire:model="inputs.{{ $index }}.merk_code"
                                                    class="form-select form-select-sm @error('inputs.' . $index . '.merk_code') is-invalid @enderror">
                                                    <option value="">Pilih</option>
                                                    @foreach ($merks as $cat)
                                                        <option value="{{ $cat->kode_merk }}">
                                                            {{ $cat->nama_merk }}</option>
                                                    @endforeach
                                                </select>
                                                @error('inputs.' . $index . '.merk_code')
                                                    <div class="invalid-feedback font-size-11">{{ $message }}
                                                    </div>
                                                @enderror

                                            </td>
                                            <td>
                                                <select wire:model="inputs.{{ $index }}.group_code"
                                                    class="form-select form-select-sm @error('inputs.' . $index . '.group_code') is-invalid @enderror">
                                                    <option value="">Pilih</option>
                                                    @foreach ($groups as $cat)
                                                        <option value="{{ $cat->kode_group }}">
                                                            {{ $cat->nama_group }}</option>
                                                    @endforeach
                                                </select>
                                                @error('inputs.' . $index . '.group_code')
                                                    <div class="invalid-feedback font-size-11">{{ $message }}
                                                    </div>
                                                @enderror

                                            </td>

                                            <td>
                                                <input type="number" wire:model="inputs.{{ $index }}.stok"
                                                    class="form-control form-control-sm text-center">
                                            </td>
                                            {{-- <td>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text">Rp</span>
                                                    <input type="number"
                                                        wire:model="inputs.{{ $index }}.harga"class="form-control form-control-sm text-center">
                                                </div>
                                            </td> --}}
                                            {{-- <td>
                                                <input type="text" wire:model="inputs.{{ $index }}.deskripsi"
                                                    class="form-control form-control-sm" placeholder="...">
                                            </td> --}}
                                            <td class="text-center">
                                                @if (count($inputs) > 1)
                                                    <button data-repeater-delete type="button"
                                                        wire:click="removeInput({{ $index }})"
                                                        class="btn btn-soft-danger btn-sm waves-effect waves-light">
                                                        <i class="bx bx-trash font-size-16"></i>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4 d-flex justify-content-between">
                            <button data-repeater-create type="button" wire:click="addInput"
                                class="btn btn-success btn-rounded waves-effect waves-light mb-2">
                                <i class="bx bx-plus label-icon"></i>Baris
                            </button>

                            <button type="button" wire:click="save"
                                class="btn btn-success btn-rounded waves-effect waves-light mb-2">
                                <i class="bx bx-save label-icon"></i>
                                <span wire:loading.remove wire:target="save">Simpan</span>
                                <span wire:loading wire:target="save">Sedang Menyimpan...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <style>
        /* Memastikan cell tabel punya posisi relatif */
        table td {
            position: relative;
            vertical-align: top;
            /* Pastikan input tetap di atas */
            padding-bottom: 20px !important;
            /* Beri ruang kosong di bawah untuk tempat error */
        }

        /* Membuat pesan error melayang */
        .invalid-feedback-absolute {
            position: absolute;
            bottom: 2px;
            left: 12px;
            font-size: 10px;
            white-space: nowrap;
            display: block;
            color: #f46a6a;
        }
    </style>
</div>
