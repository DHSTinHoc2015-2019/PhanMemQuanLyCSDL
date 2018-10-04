<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNhapXeMaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nhap_xe_mays', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_nhanvien')->unsigned();
            $table->foreign('id_nhanvien')->references('id')->on('nhan_viens');
            $table->integer('id_nhacungcap')->unsigned();
            $table->foreign('id_nhacungcap')->references('id')->on('nha_cung_caps');
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
        Schema::dropIfExists('nhap_xe_mays');
    }
}
