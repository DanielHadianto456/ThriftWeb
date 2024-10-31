<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembelianDetailTable extends Migration
{
    public function up()
    {
        Schema::create('pembelian_detail', function (Blueprint $table) {
            $table->increments('pembelian_detail_id');
            $table->unsignedInteger('pembelian_id');
            $table->unsignedInteger('pakaian_id');
            $table->integer('pembelian_detail_jumlah');
            $table->integer('pembelian_detail_total_harga');

            $table->foreign('pembelian_id')
                  ->references('pembelian_id')
                  ->on('pembelian')
                  ->onDelete('cascade');
                  
            $table->foreign('pakaian_id')
                  ->references('pakaian_id')
                  ->on('pakaian')
                  ->onDelete('cascade');

        });
    }

    public function down()
    {
        Schema::dropIfExists('pembelian_detail');
    }
}

