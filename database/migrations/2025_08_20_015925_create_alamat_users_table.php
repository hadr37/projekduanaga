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
    Schema::create('alamat_users', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
        $table->string('namapenerima');
        $table->string('no_telepon');
        $table->text('alamat');
        $table->unsignedBigInteger('kecamatan_id')->nullable();
        $table->unsignedBigInteger('kabupaten_id')->nullable();
        $table->unsignedBigInteger('provinsi_id')->nullable();
        $table->boolean('is_default')->default(false);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alamat_users');
    }
};
