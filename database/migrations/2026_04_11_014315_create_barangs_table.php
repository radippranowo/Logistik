<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barangs', function (Blueprint $table) {
        $table->id(); // ID Barang (Primary Key)
        $table->string('kode_barang')->unique(); // Kode unik (misal: BRG-001)
        $table->string('nama_barang');
        $table->string('kategori')->nullable();
        $table->integer('stok')->default(0);
        $table->decimal('harga', 15, 2);
        $table->text('deskripsi')->nullable();
        $table->timestamps(); // created_at & updated_at
    });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
