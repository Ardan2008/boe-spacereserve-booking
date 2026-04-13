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
        Schema::create('harga_sewa_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('fasilitas_id');
            $table->decimal('harga_lama', 15, 2);
            $table->decimal('harga_baru', 15, 2);
            $table->string('persen_perubahan');
            $table->timestamps();

            $table->foreign('fasilitas_id')->references('id')->on('fasilitas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('harga_sewa_histories');
    }
};
