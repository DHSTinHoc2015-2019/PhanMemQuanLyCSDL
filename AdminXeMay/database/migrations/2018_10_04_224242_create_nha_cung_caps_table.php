<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNhaCungCapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nha_cung_caps', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tennhacungcap');
            $table->string('diachi');
            $table->string('email');
            $table->string('sodienthoai');
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
        Schema::dropIfExists('nha_cung_caps');
    }
}
