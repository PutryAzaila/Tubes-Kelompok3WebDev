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
        Schema::create('perangkats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kategori_perangkat')->constrained('kategori_perangkats')->onDelete('cascade');
            $table->string('serial_number')->unique();
            $table->string('nama_perangkat');
            $table->enum('status', ['Rusak', 'Hilang', 'Return','Berfungsi']);
            $table->text('catatan_perangkat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perangkats');
    }
};
