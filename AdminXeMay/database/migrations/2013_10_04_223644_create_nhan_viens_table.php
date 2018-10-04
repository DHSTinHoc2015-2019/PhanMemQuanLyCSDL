<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNhanViensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nhan_viens', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_chucvu')->unsigned();
            $table->foreign('id_chucvu')->references('id')->on('chuc_vus');
            $table->string('hoten');
            $table->date('ngaysinh');
            $table->string('gioitinh', 10);
            $table->string('socmnd');
            $table->string('sodienthoai');
            $table->string('quequan');
            $table->string('chuoibaomat');
            $table->integer('phucap')->unsigned()->default(0);
            $table->text('img')->nullable();
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
        Schema::dropIfExists('nhan_viens');
    }
}
