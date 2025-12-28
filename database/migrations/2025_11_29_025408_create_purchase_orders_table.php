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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_vendor')->constrained('data_vendors')->onDelete('cascade');
            $table->foreignId('id_karyawan')->constrained('users')->onDelete('cascade');
            $table->timestamp('tanggal_pemesanan');
            $table->enum('status', ['Diajukan', 'Disetujui','Ditolak']);
            $table->text('alasan_penolakan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
