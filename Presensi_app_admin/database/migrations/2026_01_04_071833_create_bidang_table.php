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
        Schema::create('bidang', function (Blueprint $table) {
            $table->id('id_bidang'); // Langsung id_bidang
            $table->string('kode_bidang', 20)->unique();
            $table->string('nama_bidang', 100);

            $table->foreignId('id_skpd')
                ->nullable()
                ->constrained('skpd')
                ->onDelete('set null')
                ->onUpdate('set null');
            $table->string('nama_bidang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('divisi');
    }
};
