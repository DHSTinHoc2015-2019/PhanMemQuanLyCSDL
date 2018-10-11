<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChiTietHoaDonBanPhuTung extends Model
{
    protected $table = 'chi_tiet_hoa_don_ban_phu_tungs';

    function scopeDanhSachChiTietHoaDonBanPhuTung($query, $id_banphutungphukien){
    	return $query->join('phu_tungs', 'id_phutung', 'phu_tungs.id')
    	->join('loai_phu_tungs', 'id_loaiphutung', 'loai_phu_tungs.id')
    	->select('chi_tiet_hoa_don_ban_phu_tungs.id', 'id_banphutungphukien', 'tenphutung', 'loaixe','imgphutung', 'chi_tiet_hoa_don_ban_phu_tungs.soluongban', 'dongiaban')
    	->where('id_banphutungphukien', $id_banphutungphukien)
    	->get();
    }
}
