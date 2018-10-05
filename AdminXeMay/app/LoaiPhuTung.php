<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoaiPhuTung extends Model
{
    protected $table = 'loai_phu_tungs';

    function scopeDanhSachLoaiPhuTung($query){
    	return $query->get();
    }
}
