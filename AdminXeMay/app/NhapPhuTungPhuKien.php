<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NhapPhuTungPhuKien extends Model
{
    protected $table = 'nhap_phu_tung_phu_kiens';

    function scopeDanhSachPhuTungPhuKien($query){
    	return $query->join('nhan_viens', 'id_nhanvien', '=', 'nhan_viens.id')
    	->join('nha_cung_caps', 'id_nhacungcap', '=', 'nha_cung_caps.id')
    	->select('nhap_phu_tung_phu_kiens.id', 'tennhacungcap', 'hoten', 'nhap_phu_tung_phu_kiens.created_at')
    	->get();
    }
}
