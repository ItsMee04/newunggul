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
        Schema::create('pembelian', function (Blueprint $table) {
            $table->id();
            $table->string('kodepembelian', 100);
            $table->string('kodepembelianproduk');
            $table->unsignedBigInteger('suplier_id')->nullable();
            $table->unsignedBigInteger('pelanggan_id')->nullable();
            $table->string('kodeproduk', 100);
            $table->date('tanggal');
            $table->integer('status')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('suplier_id')->references('id')->on('suplier')->onDelete('cascade');
            $table->foreign('pelanggan_id')->references('id')->on('pelanggan')->onDelete('cascade');
            $table->foreign('kodepembelianproduk')->references('kodepembelianproduk')->on('pembelian_produk')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian');
    }
};
