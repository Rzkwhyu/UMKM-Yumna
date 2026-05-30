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
        Schema::create('stok_barangs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barang_id'); 
            $table->foreign('barang_id')->references('id')->on('barangs')->onDelete('cascade');
            $table->date('tanggal_masuk');
            $table->string('no_transaksi');
            $table->unsignedBigInteger('suplier_id'); 
            $table->foreign('suplier_id')->references('id')->on('supliers')->onDelete('cascade');
            $table->integer('qty');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_barangs');
    }
};
