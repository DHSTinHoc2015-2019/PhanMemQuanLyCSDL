<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhuTung extends Model
{
     protected $table  = 'phu_tungs';

    function scopeDanhSachPhuTung($query){
    	return $query->join('loai_phu_tungs', 'id_loaiphutung', 'loai_phu_tungs.id')
    	->select('phu_tungs.id', 'id_loaiphutung', 'tenphutung', 'donvitinh', 'loaixe', 'soluong', 'dongia', 'imgphutung')
    	->get();
    } 

    function scopePhuTungTheoID($query, $id){
    	return $query->join('loai_phu_tungs', 'id_loaiphutung', 'loai_phu_tungs.id')
    	->select('phu_tungs.id', 'id_loaiphutung', 'tenphutung', 'donvitinh', 'loaixe', 'soluong', 'dongia', 'imgphutung')
    	->where('phu_tungs.id', $id)
    	->first();
    }
}
