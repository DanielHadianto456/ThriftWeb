<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetodePembayaranTable extends Migration
{
    public function up()
    {
        Schema::create('metode_pembayaran', function (Blueprint $table) {
            $table->increments('metode_pembayaran_id');
            $table->unsignedInteger('user_id');
            $table->enum('metode_pembayaran_jenis', ['DANA', 'OVO', 'BCA', 'COD']);
            $table->string('metode_pembayaran_nomor', 50)->nullable();

            $table->foreign('user_id')
                  ->references('user_id')
                  ->on('user')
                  ->onDelete('cascade');

        });
    }

    public function down()
    {
        Schema::dropIfExists('metode_pembayaran');
    }
}
