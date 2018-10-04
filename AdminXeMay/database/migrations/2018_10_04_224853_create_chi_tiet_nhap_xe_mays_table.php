<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChiTietNhapXeMaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chi_tiet_nhap_xe_mays', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_nhapxemay')->unsigned();
            $table->foreign('id_nhapxemay')->references('id')->on('nhap_xe_mays');
            $table->integer('id_xemay')->unsigned();
            $table->foreign('id_xemay')->references('id')->on('xe_mays');
            $table->integer('dongianhap');
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
        Schema::dropIfExists('chi_tiet_nhap_xe_mays');
    }
}
