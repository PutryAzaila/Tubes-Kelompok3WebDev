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
        Schema::create('barang_keluars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('detail_barang_id')->constrained('detail_barangs')->onDelete('cascade');
            $table->integer('jumlah');
            $table->timestamp('tanggal');
            $table->string('alamat');
            $table->enum('status', ['Pemeliharaan', 'Penjualan', 'Instalasi']);
            $table->text('catatan_barang_keluar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_keluars');
    }
};
