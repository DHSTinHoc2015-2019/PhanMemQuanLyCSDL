<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHoaDonBanPhuTungPhuKiensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hoa_don_ban_phu_tung_phu_kiens', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_khachhang')->unsigned();
            $table->foreign('id_khachhang')->references('id')->on('khach_hangs');
            $table->integer('id_nhanvien')->unsigned();
            $table->foreign('id_nhanvien')->references('id')->on('nhan_viens');
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
        Schema::dropIfExists('hoa_don_ban_phu_tung_phu_kiens');
    }
}
