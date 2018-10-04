<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NhaCungCap extends Model
{
    protected $table = 'nha_cung_caps';

    function nhapxe(){
    	return $this->hasMany('App\NhapXe', 'id_nhacungcap', 'id');
    }

    function scopeDanhSach($query){
    	return $query->get();
    }
}
