<?php

namespace App\Livewire\Barang;

use App\Models\Barang;
use App\Models\Category;
use App\Models\Group;
use App\Models\Merk;
use Livewire\Component;

class Create extends Component
{
    public $inputs = [];

    public function mount()
    {
        $this->addInput();
    }

    public function addInput()
    {
        $this->inputs[] = [
            'id' => uniqid(),
            'kode_barang' => '',
            'part_number' => '',
            'nama_barang' => '',
            'category_code' => '',
            'merk_code' => '',
            'group_code' => '',
            'stok' => 0,
            'harga' => 0,
        ];
    }

    public function removeInput($index)
    {
        unset($this->inputs[$index]);
        $this->inputs = array_values($this->inputs);
    }

    /**
     * 🔥 VALIDASI LIVE (AUTO JALAN)
     */
    public function updated($propertyName)
    {
        // reset error field itu saja
        $this->resetErrorBag($propertyName);

        // validasi field yang berubah
        $this->validateOnly($propertyName, $this->rules(), $this->messages());

        // cek duplicate
        $this->validateDuplicate();
    }

    /**
     * RULES
     */
    protected function rules()
    {
        return [
            'inputs.*.kode_barang' => 'required|unique:barangs,kode_barang',
            'inputs.*.part_number' => 'unique:barangs,part_number',
            'inputs.*.nama_barang' => 'required|min:3',
            'inputs.*.category_code' => 'required',
            'inputs.*.merk_code' => 'required',
            'inputs.*.group_code' => 'required',
            'inputs.*.stok' => 'required|numeric',
        ];
    }

    /**
     * MESSAGES
     */
    protected function messages()
    {
        return [
            'inputs.*.kode_barang.required' => 'Wajib diisi',
            'inputs.*.kode_barang.unique' => 'Sudah ada',
            'inputs.*.part_number.unique' => 'Sudah ada',
            'inputs.*.nama_barang.required' => 'Wajib diisi',
            'inputs.*.nama_barang.min' => 'Minimal 3 karakter',
            'inputs.*.category_code.required' => 'Wajib dipilih',
            'inputs.*.merk_code.required' => 'Wajib dipilih',
            'inputs.*.group_code.required' => 'Wajib dipilih',
        ];
    }

    /**
     * 🔥 CEK DUPLICATE (FORM + DATABASE)
     */
    public function validateDuplicate()
    {
        $kodeList = [];

        foreach ($this->inputs as $index => $item) {

            // skip kosong
            if (empty($item['kode_barang'])) continue;

            // 🔥 duplicate antar row
            if (in_array($item['kode_barang'], $kodeList)) {
                $this->addError("inputs.$index.kode_barang", 'kode sudah ada di form ');
            }

            $kodeList[] = $item['kode_barang'];

            // 🔥 duplicate database
            if (Barang::where('kode_barang', $item['kode_barang'])->exists()) {
                $this->addError("inputs.$index.kode_barang", 'Kode sudah ada di database');
            }
        }
    }

    /**
     * 🔥 SAVE FINAL
     */
    public function save()
    {
        $this->resetErrorBag();

        $this->validate($this->rules(), $this->messages());

        $this->validateDuplicate();

        // kalau masih ada error → stop
        if ($this->getErrorBag()->isNotEmpty()) {
            return;
        }

        foreach ($this->inputs as $item) {
            $data = $item;
            unset($data['id']);

            Barang::create($data);
        }

        session()->flash('success', 'Data berhasil disimpan');

        return $this->redirectRoute('barang.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.barang.create', [
            'categories' => Category::all(),
            'merks' => Merk::all(),
            'groups' => Group::all(),
        ]);
    }
}