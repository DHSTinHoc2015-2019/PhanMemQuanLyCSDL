<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhuTungsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phu_tungs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_loaiphutung')->unsigned();
            $table->foreign('id_loaiphutung')->references('id')->on('loai_phu_tungs');
            $table->string('loaixe');
            $table->integer('soluong');
            $table->integer('dongia');
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
        Schema::dropIfExists('phu_tungs');
    }
}
