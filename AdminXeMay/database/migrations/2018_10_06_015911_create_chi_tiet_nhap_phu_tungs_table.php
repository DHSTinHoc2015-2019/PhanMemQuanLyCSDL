<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChiTietNhapPhuTungsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chi_tiet_nhap_phu_tungs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_nhapphutungphukien')->unsigned();
            $table->foreign('id_nhapphutungphukien')->references('id')->on('nhap_phu_tung_phu_kiens');
            $table->integer('id_phutung')->unsigned();
            $table->foreign('id_phutung')->references('id')->on('phu_tungs');
            $table->integer('soluong');
            $table->integer('gianhap');
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
        Schema::dropIfExists('chi_tiet_nhap_phu_tungs');
    }
}
