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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('kodetransaksi', 100);
            $table->string('keranjang_id');
            $table->unsignedBigInteger('pelanggan_id');
            $table->integer('diskon');
            $table->date('tanggal');
            $table->integer('total');
            $table->unsignedBigInteger('user_id');
            $table->integer('status');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('keranjang_id')->references('kodekeranjang')->on('keranjang')->onDelete('cascade');
            $table->foreign('pelanggan_id')->references('id')->on('pelanggan')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
