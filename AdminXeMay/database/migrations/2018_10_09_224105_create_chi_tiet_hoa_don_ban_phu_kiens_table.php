<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChiTietHoaDonBanPhuKiensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chi_tiet_hoa_don_ban_phu_kiens', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_banphutungphukien')->unsigned();
            $table->foreign('id_banphutungphukien')->references('id')->on('hoa_don_ban_phu_tung_phu_kiens');
            $table->integer('id_phukien')->unsigned();
            $table->foreign('id_phukien')->references('id')->on('phu_kiens');
            $table->integer('dongiaban');
            $table->integer('soluongban');
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
        Schema::dropIfExists('chi_tiet_hoa_don_ban_phu_kiens');
    }
}
