<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Mengubah tabel users
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('created_id')->nullable();
            $table->unsignedBigInteger('updated_id')->nullable();
            $table->unsignedBigInteger('deleted_id')->nullable();
            $table->softDeletes(); // Menambah kolom deleted_at
        });

        // Mengubah tabel presensi_apel
        Schema::table('presensi', function (Blueprint $table) {
            $table->unsignedBigInteger('created_id')->nullable();
            $table->unsignedBigInteger('updated_id')->nullable();
            $table->unsignedBigInteger('deleted_id')->nullable();
            $table->softDeletes();
        });

        Schema::table('qr', function (Blueprint $table) {
            $table->unsignedBigInteger('created_id')->nullable();
            $table->unsignedBigInteger('updated_id')->nullable();
            $table->unsignedBigInteger('deleted_id')->nullable();
            $table->softDeletes();
        });

        Schema::table('bidang', function (Blueprint $table) {
            $table->unsignedBigInteger('created_id')->nullable();
            $table->unsignedBigInteger('updated_id')->nullable();
            $table->unsignedBigInteger('deleted_id')->nullable();
            $table->softDeletes();
        });



    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['created_id', 'updated_id', 'deleted_id', 'deleted_at']);
        });

        Schema::table('presensi', function (Blueprint $table) {
            $table->dropColumn(['created_id', 'updated_id', 'deleted_id', 'deleted_at']);
        });

        Schema::table('qr', function (Blueprint $table) {
            $table->dropColumn(['created_id', 'updated_id', 'deleted_id', 'deleted_at']);
        });

        Schema::table('bidang', function (Blueprint $table) {
            $table->dropColumn(['created_id', 'updated_id', 'deleted_id', 'deleted_at']);
        });

    }
};
