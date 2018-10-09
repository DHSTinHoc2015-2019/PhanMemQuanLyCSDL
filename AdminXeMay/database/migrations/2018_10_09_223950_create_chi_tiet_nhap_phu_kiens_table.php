<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChiTietNhapPhuKiensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chi_tiet_nhap_phu_kiens', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_nhapphutungphukien')->unsigned();
            $table->foreign('id_nhapphutungphukien')->references('id')->on('nhap_phu_tung_phu_kiens');
            $table->integer('id_phukien')->unsigned();
            $table->foreign('id_phukien')->references('id')->on('phu_kiens');
            $table->integer('gianhap');
            $table->integer('soluongnhap');
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
        Schema::dropIfExists('chi_tiet_nhap_phu_kiens');
    }
}
