<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateXeMaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xe_mays', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tenxe');
            $table->string('mauxe');
            $table->integer('dongia');
            $table->integer('soluong');
            $table->integer('namsanxuat')->nullable();
            $table->double('dungtichxylanh')->nullable();
            $table->string('noisanxuat')->nullable();
            $table->string('donvitinh')->nullable();
            $table->text('img')->nullable();
            $table->integer('id_loaibaohanh')->unsigned();
            $table->foreign('id_loaibaohanh')->references('id')->on('loai_bao_hanhs');
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
        Schema::dropIfExists('xe_mays');
    }
}
