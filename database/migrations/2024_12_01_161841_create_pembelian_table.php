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
            $table->unsignedBigInteger('suplier_id')->nullable();
            $table->unsignedBigInteger('pelanggan_id')->nullable();
            $table->string('kodeproduk', 100);
            $table->unsignedBigInteger('kondisi_id');
            $table->date('tanggal');
            $table->integer('status')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('suplier_id')->references('id')->on('suplier')->onDelete('cascade');
            $table->foreign('pelanggan_id')->references('id')->on('pelanggan')->onDelete('cascade');
            $table->foreign('kodeproduk')->references('kodeproduk')->on('produk')->onDelete('cascade');
            $table->foreign('kondisi_id')->references('id')->on('kondisi')->onDelete('cascade');
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
