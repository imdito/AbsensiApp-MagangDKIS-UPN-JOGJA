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
        Schema::create('presensi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('Id_QR');
            $table->unsignedBigInteger('user_id')->unique();
            $table->date('tanggal');
            $table->time('jam_masuk');
            $table->time('jam_pulang');
            $table->enum('status', ['Hadir', 'Izin', 'Tidak Hadir']);
            $table->decimal('Longitude', 11, 8);
            $table->decimal('Latitude', 11, 8);
            $table->timestamp('created_at')->useCurrent()->useCurrentOnUpdate();

            // Foreign Keys
            $table->foreign('Id_QR')->references('Id_QR')->on('qr')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensi');
    }
};
