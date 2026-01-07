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
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('Email', 100)->unique();
            $table->string('Password', 100);
            $table->string('Nama_Pengguna', 100);
            $table->string('NIP', 100);

            // Foreign Key ke tabel divisi
            $table->unsignedBigInteger('Id_Divisi');
            $table->foreign('Id_Divisi')->references('Id_Divisi')->on('divisi')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
