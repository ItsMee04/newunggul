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
        Schema::create('pembelian_produk', function (Blueprint $table) {
            $table->id();
            $table->string('kodepembelianproduk', 100)->index();
            $table->unsignedBigInteger('produk_id');
            $table->integer('harga');
            $table->integer('total');
            $table->unsignedBigInteger('kondisi_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('status');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('produk_id')->references('id')->on('produk')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('kondisi_id')->references('id')->on('kondisi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian_produk');
    }
};
