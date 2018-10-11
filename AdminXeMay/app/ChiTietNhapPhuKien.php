<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChiTietNhapPhuKien extends Model
{
	protected $table = 'chi_tiet_nhap_phu_kiens';

    function scopeDanhSachChiTietNhapPhuKien($query, $id_nhapphutungphukien){
    	return $query->join('phu_kiens', 'id_phukien', 'phu_kiens.id')
    	->join('xe_mays', 'id_xemays', 'xe_mays.id')
    	->select('chi_tiet_nhap_phu_kiens.id', 'id_nhapphutungphukien', 'tenphukien', 'tenxe','imgphukien', 'chi_tiet_nhap_phu_kiens.soluongnhap', 'gianhap')
    	->where('id_nhapphutungphukien', $id_nhapphutungphukien)
    	->get();
    }
}
