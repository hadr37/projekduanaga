<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('pesanan_details', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pesanan_id')->constrained()->onDelete('cascade');
        $table->foreignId('barang_id')->constrained()->onDelete('cascade');
        $table->integer('jumlah');
        $table->decimal('harga', 15, 2); // harga satuan saat dibeli
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan_details');
    }
};
