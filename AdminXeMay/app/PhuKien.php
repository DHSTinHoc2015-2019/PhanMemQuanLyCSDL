<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhuKien extends Model
{
    protected $table  = 'phu_kiens';

    function scopeDanhSachPhuKien($query){
    	return $query->join('xe_mays', 'id_xemays', 'xe_mays.id')
    	->select('phu_kiens.id', 'id_xemays', 'tenphukien', 'tenxe', 'phu_kiens.donvitinh', 'phu_kiens.soluong', 'phu_kiens.dongia', 'imgphukien')
    	->get();
    } 

    function scopePhuKienTheoID($query, $id){
    	return $query->join('xe_mays', 'id_xemays', 'xe_mays.id')
    	->select('phu_kiens.id', 'id_xemays', 'tenphukien', 'tenxe', 'phu_kiens.donvitinh', 'phu_kiens.soluong', 'phu_kiens.dongia', 'imgphukien', 'img')
    	->where('phu_kiens.id', $id)
    	->first();
    }
}
