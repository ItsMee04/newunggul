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
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->string('kodeproduk', 100)->index();
            $table->unsignedBigInteger('jenis_id');
            $table->string('nama', 100);
            $table->integer('harga_jual')->nullable();
            $table->integer('harga_beli')->nullable();
            $table->text('keterangan')->nullable();
            $table->decimal('berat', 8, 5);
            $table->integer('karat');
            $table->unsignedBigInteger('kondisi_id');
            $table->string('image', 100)->nullable();
            $table->integer('status')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('jenis_id')->references('id')->on('jenis')->onDelete('cascade');
            $table->foreign('kondisi_id')->references('id')->on('kondisi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
