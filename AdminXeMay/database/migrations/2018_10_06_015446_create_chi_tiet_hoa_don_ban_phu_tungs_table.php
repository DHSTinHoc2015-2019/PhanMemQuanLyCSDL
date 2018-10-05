<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChiTietHoaDonBanPhuTungsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chi_tiet_hoa_don_ban_phu_tungs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_banphutungphukien')->unsigned();
            $table->foreign('id_banphutungphukien')->references('id')->on('hoa_don_ban_phu_tung_phu_kiens');
            $table->integer('id_phutung')->unsigned();
            $table->foreign('id_phutung')->references('id')->on('phu_tungs');
            $table->integer('dongiaban');
            $table->integer('soluong');
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
        Schema::dropIfExists('chi_tiet_hoa_don_ban_phu_tungs');
    }
}
