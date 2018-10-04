<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoaiBaoHanhsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loai_bao_hanhs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tenloaibaohanh');
            $table->integer('thoigianbaohanh');
            $table->text('imgBH');
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
        Schema::dropIfExists('loai_bao_hanhs');
    }
}
