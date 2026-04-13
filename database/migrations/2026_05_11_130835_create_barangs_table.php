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
        // $table->id();
        // $table->string('kode_barang')->unique();
        // $table->string('nama_barang');
        // // Relasi: Mengambil kode_category dari tabel categorys
        // $table->string('category_code'); 
        // $table->foreign('category_code')->references('kode_category')->on('categorys');
        
        // $table->integer('stok');
        // $table->decimal('harga', 15, 2);
        // $table->text('deskripsi')->nullable();
        // $table->timestamps();

            $table->id();
            $table->string('kode_barang')->unique();
            $table->string('part_number')->unique();
            $table->string('nama_barang');
            // Relasi: Mengambil kode_category dari tabel categorys
            $table->string('category_code'); 
            $table->foreign('category_code')->references('kode_category')->on('categorys');
           
            $table->string('merk_code'); 
            $table->foreign('merk_code')->references('kode_merk')->on('merks');
           
            $table->string('group_code'); 
            $table->foreign('group_code')->references('kode_group')->on('groups');
            
            $table->integer('stok');
            $table->decimal('harga', 15, 2);
            $table->text('deskripsi')->nullable();
            $table->timestamps();

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
