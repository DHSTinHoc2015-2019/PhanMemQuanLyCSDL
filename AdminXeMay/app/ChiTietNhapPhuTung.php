<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChiTietNhapPhuTung extends Model
{
    protected $table = 'chi_tiet_nhap_phu_tungs';

    function scopeDanhSachChiTietNhapPhuTung($query, $id_nhapphutungphukien){
    	return $query->join('phu_tungs', 'id_phutung', 'phu_tungs.id')
    	->join('loai_phu_tungs', 'id_loaiphutung', 'loai_phu_tungs.id')
    	->select('chi_tiet_nhap_phu_tungs.id', 'id_nhapphutungphukien', 'tenphutung', 'loaixe','imgphutung', 'chi_tiet_nhap_phu_tungs.soluongnhap', 'gianhap')
    	->where('id_nhapphutungphukien', $id_nhapphutungphukien)
    	->get();
    }

    // function scopeDanhSachChiTietNhapPhuTungTheoID($query, $id_nhapphutungphukien, $id){
    // 	return $query->join('phu_tungs', 'id_phutung', 'phu_tungs.id')
    // 	->join('loai_phu_tungs', 'id_loaiphutung', 'loai_phu_tungs.id')
    // 	->select('chi_tiet_nhap_phu_tungs.id', 'id_nhapphutungphukien', 'tenphutung', 'loaixe','imgphutung', 'chi_tiet_nhap_phu_tungs.soluong', 'gianhap')
    // 	->where('id_nhapphutungphukien', $id_nhapphutungphukien)
    // 	->where('chi_tiet_nhap_phu_tungs.id', $id)
    // 	->get();
    // }
}
