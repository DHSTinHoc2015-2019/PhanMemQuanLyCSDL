<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChiTietHoaDonBanPhuKien extends Model
{
    protected $table = 'chi_tiet_hoa_don_ban_phu_kiens';

    function scopeDanhSachChiTietHoaDonBanPhuKien($query, $id_banphutungphukien){
    	return $query->join('phu_kiens', 'id_phukien', 'phu_kiens.id')
    	->join('xe_mays', 'id_xemays', 'xe_mays.id')
    	->select('chi_tiet_hoa_don_ban_phu_kiens.id', 'id_banphutungphukien', 'tenphukien', 'tenxe','imgphukien', 'chi_tiet_hoa_don_ban_phu_kiens.soluongban', 'dongiaban')
    	->where('id_banphutungphukien', $id_banphutungphukien)
    	->get();
    }
}
