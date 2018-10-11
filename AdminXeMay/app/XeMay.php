<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class XeMay extends Model
{
    protected $table = 'xe_mays';

    function scopeDanhSachXeMay($query){
    	return $query->join('loai_bao_hanhs', 'id_loaibaohanh', 'loai_bao_hanhs.id')
    	->select('xe_mays.id', 'tenxe', 'mauxe', 'dongia', 'soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'loai_bao_hanhs.tenloaibaohanh', 'img')
    	->get();
    }

    function scopeDanhSachXeMayTrongCuaHang($query){
        return $query->join('loai_bao_hanhs', 'id_loaibaohanh', 'loai_bao_hanhs.id')
        ->select('xe_mays.id', 'tenxe', 'mauxe', 'dongia', 'soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'loai_bao_hanhs.tenloaibaohanh', 'img')
        ->where('soluong', '>', 0)
        ->get();
    }

    function scopeDanhSachXeMayTheoID($query, $id){
        return $query->join('loai_bao_hanhs', 'id_loaibaohanh', 'loai_bao_hanhs.id')
    	->select('xe_mays.id', 'tenxe', 'mauxe', 'dongia', 'soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'loai_bao_hanhs.tenloaibaohanh', 'img')
    	->where('xe_mays.id', $id)
    	->get();
    }
}
