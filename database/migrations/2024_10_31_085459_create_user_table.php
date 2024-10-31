<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateUserTable extends Migration
{
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('user_id');
            $table->string('user_username', 50)->unique();
            $table->string('user_password', 255);
            $table->string('user_fullname', 100);
            $table->string('user_email', 50)->unique();
            $table->string('user_nohp', 13);
            $table->string('user_alamat', 200);
            $table->string('user_profil_url', 255)->default('url_placeholder_profil');
            $table->enum('user_level', ['ADMIN', 'PENGGUNA']);
        });

        // Insert default admin user
        DB::table('user')->insert([
            'user_username' => 'demoadmin1',
            'user_password' => Hash::make('demoadmin1'),
            'user_fullname' => 'Admin User',
            'user_email' => 'demoadmin1@gmail.com',
            'user_nohp' => '1234567890',
            'user_alamat' => 'Admin Address',
            'user_profil_url' => 'admin.jpg',
            'user_level' => 'ADMIN',
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('user');
    }
}

