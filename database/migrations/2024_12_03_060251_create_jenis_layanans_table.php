<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJenisLayanansTable extends Migration
{
    public function up()
    {
        Schema::create('jenis_layanans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_layanan');
            $table->text('deskripsi')->nullable();
            $table->decimal('harga', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jenis_layanans');
    }
}
