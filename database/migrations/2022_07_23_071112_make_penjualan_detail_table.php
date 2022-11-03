<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualanDetail', function (Blueprint $table) {
            $table->increments('id_penjualanDetail');
            $table->integer('id_penjualan');
            $table->integer('id_produk');
            $table->integer('harga_jual');
            $table->integer('jumlah');
            $table->integer('sub_total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penjualanDetail');
    }
};
