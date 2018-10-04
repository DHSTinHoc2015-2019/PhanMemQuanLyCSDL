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

  //   function scopeHinhAnhXeMayDuaVaoID($query, $id){
  //   	return $query->join('chi_tiet_nhap_xes', 'id_chitietnhapxe', 'chi_tiet_nhap_xes.id')
		// ->join('thong_tin_chung_xes', 'id_thongtinchungxe', 'thong_tin_chung_xes.id')
		// ->select('thong_tin_chung_xes.img')
		// ->where('xe_mays.id', '=', $id)
		// ->get();
  //   }

    function scopeDanhSachXeMayTheoID($query, $id){
        return $query->join('loai_bao_hanhs', 'id_loaibaohanh', 'loai_bao_hanhs.id')
    	->select('xe_mays.id', 'tenxe', 'mauxe', 'dongia', 'soluong', 'namsanxuat', 'noisanxuat', 'dungtichxylanh', 'donvitinh', 'loai_bao_hanhs.tenloaibaohanh', 'img')
    	->where('xe_mays.id', $id)
    	->get();
    }
}
