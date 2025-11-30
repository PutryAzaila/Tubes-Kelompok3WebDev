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
        Schema::create('data_vendors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kategori_vendor')->constrained('kategori_vendors')->onDelete('cascade');
            $table->string('nama_vendor');
            $table->text('alamat_vendor');
            $table->string('no_telp_vendor');
            $table->text('deskripsi_vendor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_vendors');
    }
};
