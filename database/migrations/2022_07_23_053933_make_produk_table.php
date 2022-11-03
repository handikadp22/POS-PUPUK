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
        Schema::create('produk', function (Blueprint $table) {
            $table->increments('id_produk');
            $table->integer('id_category');
            $table->string('produk_name')->unique();
            $table->string('merk')->nullable();
            $table->integer('harga_beli');
            $table->integer('harga_kiloan')->nullable();
            $table->integer('harga_botolan')->nullable();
            $table->integer('harga_persak')->nullable();
            $table->integer('harga_customer')->nullable();
            $table->integer('stok');
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
        Schema::dropIfExists('produk');
    }
};
