<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKategoriPakaianTable extends Migration
{
    public function up()
    {
        Schema::create('kategori_pakaian', function (Blueprint $table) {
            $table->increments('kategori_pakaian_id');
            $table->string('kategori_pakaian_nama', 50);
        });
    }

    public function down()
    {
        Schema::dropIfExists('kategori_pakaian');
    }
}

