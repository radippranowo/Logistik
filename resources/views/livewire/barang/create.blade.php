<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body border-bottom">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0 card-title flex-grow-1">BARANG</h5>
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
                                        {{-- SANGAT PENTING: Gunakan ID unik dari array, jangan pakai $index --}}
                                        <tr wire:key="row-{{ $item['id'] }}">
                                            <td>
                                                <input type="text"
                                                    wire:model.live="inputs.{{ $index }}.kode_barang"
                                                    class="form-control form-control-sm @error('inputs.' . $index . '.kode_barang') is-invalid @enderror">
                                                @error('inputs.' . $index . '.kode_barang')
                                                    <div class="invalid-feedback-absolute">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td>
                                                <input type="text"
                                                    wire:model.blur="inputs.{{ $index }}.part_number"
                                                    class="form-control form-control-sm @error('inputs.' . $index . '.part_number') is-invalid @enderror">
                                                @error('inputs.' . $index . '.part_number')
                                                    <div class="invalid-feedback-absolute">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td>
                                                <input type="text"
                                                    wire:model.blur="inputs.{{ $index }}.nama_barang"
                                                    class="form-control form-control-sm @error('inputs.' . $index . '.nama_barang') is-invalid @enderror">
                                                @error('inputs.' . $index . '.nama_barang')
                                                    <div class="invalid-feedback-absolute">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td>
                                                <select wire:model.change="inputs.{{ $index }}.category_code"
                                                    class="form-select form-select-sm @error('inputs.' . $index . '.category_code') is-invalid @enderror">
                                                    <option value="">Pilih</option>
                                                    @foreach ($categories as $cat)
                                                        <option value="{{ $cat->kode_category }}">
                                                            {{ $cat->nama_category }}</option>
                                                    @endforeach
                                                </select>
                                                @error('inputs.' . $index . '.category_code')
                                                    <div class="invalid-feedback-absolute">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td>
                                                <select wire:model.change="inputs.{{ $index }}.merk_code"
                                                    class="form-select form-select-sm @error('inputs.' . $index . '.merk_code') is-invalid @enderror">
                                                    <option value="">Pilih</option>
                                                    @foreach ($merks as $merk)
                                                        <option value="{{ $merk->kode_merk }}">{{ $merk->nama_merk }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('inputs.' . $index . '.merk_code')
                                                    <div class="invalid-feedback-absolute">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td>
                                                <select wire:model.change="inputs.{{ $index }}.group_code"
                                                    class="form-select form-select-sm @error('inputs.' . $index . '.group_code') is-invalid @enderror">
                                                    <option value="">Pilih</option>
                                                    @foreach ($groups as $group)
                                                        <option value="{{ $group->kode_group }}">
                                                            {{ $group->nama_group }}</option>
                                                    @endforeach
                                                </select>
                                                @error('inputs.' . $index . '.group_code')
                                                    <div class="invalid-feedback-absolute">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td>
                                                <input type="number" wire:model.blur="inputs.{{ $index }}.stok"
                                                    class="form-control form-control-sm text-center">
                                            </td>
                                            <td class="text-center">
                                                @if (count($inputs) > 1)
                                                    <button type="button"
                                                        wire:click="removeInput('{{ $item['id'] }}')"
                                                        wire:loading.attr="disabled"
                                                        wire:target="removeInput('{{ $item['id'] }}')"
                                                        class="btn btn-soft-danger btn-sm border-0 shadow-sm">

                                                        <i wire:loading.remove
                                                            wire:target="removeInput('{{ $item['id'] }}')"
                                                            class="bx bx-trash font-size-16"></i>

                                                        <span wire:loading
                                                            wire:target="removeInput('{{ $item['id'] }}')"
                                                            class="spinner-border spinner-border-sm" role="status">
                                                        </span>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4 d-flex justify-content-between">
                            <button type="button" wire:click="addInput" wire:loading.attr="disabled"
                                class="btn btn-success btn-rounded waves-effect waves-light mb-2">

                                <span wire:loading.remove wire:target="addInput">
                                    <i class="bx bx-plus label-icon"></i> Baris
                                </span>
                                <span wire:loading wire:target="addInput">
                                    <span class="spinner-border spinner-border-sm me-1" role="status"
                                        aria-hidden="true"></span>
                                    Sedang Menambah...
                                </span>
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
