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
            $table->unsignedBigInteger('jenis_id');
            $table->string('nama', 100);
            $table->integer('harga_beli')->nullable();
            $table->decimal('berat', 5, 2);
            $table->integer('karat');
            $table->string('kondisi', 100);
            $table->string('keterangan', 100);
            $table->string('image', 100)->nullable();
            $table->integer('status')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('jenis_id')->references('id')->on('jenis')->onDelete('cascade');
            $table->foreign('suplier_id')->references('id')->on('suplier')->onDelete('cascade');
            $table->foreign('pelanggan_id')->references('id')->on('pelanggan')->onDelete('cascade');
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
