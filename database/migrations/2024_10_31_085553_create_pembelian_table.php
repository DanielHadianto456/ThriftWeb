<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembelianTable extends Migration
{
    public function up()
    {
        Schema::create('pembelian', function (Blueprint $table) {
            $table->increments('pembelian_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('metode_pembayaran_id');
            $table->enum('status', ['BELUM_LUNAS', 'LUNAS']);
            $table->timestamp('pembelian_tanggal');
            $table->integer('pembelian_total_harga');

            $table->foreign('user_id')
                  ->references('user_id')
                  ->on('user')
                  ->onDelete('cascade');
                  
            $table->foreign('metode_pembayaran_id')
                  ->references('metode_pembayaran_id')
                  ->on('metode_pembayaran')
                  ->onDelete('cascade');

        });
    }

    public function down()
    {
        Schema::dropIfExists('pembelian');
    }
}

