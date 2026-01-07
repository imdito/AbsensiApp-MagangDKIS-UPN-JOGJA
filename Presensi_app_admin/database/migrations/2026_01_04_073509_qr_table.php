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
        Schema::create('qr', function (Blueprint $table) {
            $table->id('Id_QR');
            $table->date('Tanggal');
            $table->enum('Tipe_QR', ['QR_Masuk', 'QR_Pulang']);
            $table->timestamp('Created_at')->nullable();
            $table->timestamp('Expired_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qr_tokens');
    }
};
