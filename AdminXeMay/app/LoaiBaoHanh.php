<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoaiBaoHanh extends Model
{
    protected $table = 'loai_bao_hanhs';

    function scopeDanhSachBaoHanh($query){
    	return $query->where('id', '<>', 1)->get();
    }
}
