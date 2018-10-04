<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChucVu extends Model
{
    protected $table = 'chuc_vus';

    function nhanvien(){
    	return $this->hasMany('App\NhanVien', 'id_chucvu', 'id');
    }

  	//Select * from chuc_vus
    function scopeDanhSach($query){
    	return $query->get();
    }
}
