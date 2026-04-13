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
        Schema::table('fasilitas', function (Blueprint $table) {
            $table->enum('tipe', ['asrama', 'aula'])->default('asrama')->after('nama');
            $table->text('detail')->nullable()->after('deskripsi');
            $table->decimal('harga_bulanan', 15, 2)->nullable()->after('harga');
            $table->integer('max_dewasa')->nullable()->after('harga_bulanan');
            $table->integer('max_anak')->nullable()->after('max_dewasa');
            $table->integer('max_durasi_harian')->nullable()->after('max_anak');
            $table->string('jam_operasional')->nullable()->after('max_durasi_harian');
            $table->json('gallery')->nullable()->after('image');
            $table->json('labels')->nullable()->after('gallery');
            $table->string('harga_thumbnail')->nullable()->after('labels');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fasilitas', function (Blueprint $table) {
            $table->dropColumn([
                'tipe',
                'detail',
                'harga_bulanan',
                'max_dewasa',
                'max_anak',
                'max_durasi_harian',
                'jam_operasional',
                'gallery',
                'labels',
                'harga_thumbnail'
            ]);
        });
    }
};
