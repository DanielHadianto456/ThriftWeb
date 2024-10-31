<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePakaianTable extends Migration
{
    public function up()
    {
        Schema::create('pakaian', function (Blueprint $table) {
            $table->increments('pakaian_id');
            $table->unsignedInteger('kategori_pakaian_id');
            $table->string('pakaian_nama', 50);
            $table->string('pakaian_harga', 50);
            $table->string('pakaian_stok', 100);
            $table->string('pakaian_gambar_url', 50);

            $table->foreign('kategori_pakaian_id')
                  ->references('kategori_pakaian_id')
                  ->on('kategori_pakaian')
                  ->onDelete('cascade');
                  
        });
    }

    public function down()
    {
        Schema::dropIfExists('pakaian');
    }
}
