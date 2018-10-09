<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhuKiensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phu_kiens', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tenphukien');
            $table->integer('dongia');
            $table->integer('soluong');
            $table->string('donvitinh');
            $table->text('imgphukien')->nullable();
            $table->integer('id_xemays')->unsigned();
            $table->foreign('id_xemays')->references('id')->on('xe_mays');
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
        Schema::dropIfExists('phu_kiens');
    }
}
