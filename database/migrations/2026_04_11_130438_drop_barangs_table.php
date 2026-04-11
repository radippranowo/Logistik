<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Menghapus tabel jika ada
        Schema::dropIfExists('barangs');
    }

    public function down(): void
    {
        // Opsional: Mendefinisikan ulang tabel jika ingin melakukan 'rollback'
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }
};
