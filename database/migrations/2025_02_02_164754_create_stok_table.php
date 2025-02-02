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
        Schema::create('stok', function (Blueprint $table) {
            $table->id();
            $table->string('kodetransaksi', 100);
            $table->unsignedBigInteger('nampan_id');
            $table->date('tanggal');
            $table->text('keterangan');
            $table->integer('status');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('nampan_id')->references('id')->on('nampan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok');
    }
};
