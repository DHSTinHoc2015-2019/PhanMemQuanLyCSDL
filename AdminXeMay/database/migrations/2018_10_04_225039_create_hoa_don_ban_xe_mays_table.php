<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHoaDonBanXeMaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hoa_don_ban_xe_mays', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_khachhang')->unsigned();
            $table->foreign('id_khachhang')->references('id')->on('khach_hangs');
            $table->integer('id_nhanvien')->unsigned();
            $table->foreign('id_nhanvien')->references('id')->on('nhan_viens');
            $table->integer('id_xemay')->unsigned();
            $table->foreign('id_xemay')->references('id')->on('xe_mays');
            $table->integer('dongiaban');
            $table->integer('soluong');
            $table->double('thueVAT')->nullable();
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
        Schema::dropIfExists('hoa_don_ban_xe_mays');
    }
}
