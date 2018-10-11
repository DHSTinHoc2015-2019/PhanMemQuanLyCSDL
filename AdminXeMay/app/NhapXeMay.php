<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NhapXeMay extends Model
{
    protected $table = 'nhap_xe_mays';
    
    public function nhacungcap(){
    	return $this->belongsTo('App\NhaCungCap', 'id_nhacungcap', 'id');
    }

    public function nhanvien(){
    	return $this->belongsTo('App\NhanVien', 'id_nhanvien', 'id');
    }

    public function chitietnhapxe(){
    	return $this->hasMany('App\ChiTietNhapXe', 'id_nhapxe', 'id');
    }

    public function scopeDanhSach($query){
        return $query->join('nhan_viens', 'id_nhanvien', '=', 'nhan_viens.id')
        ->join('nha_cung_caps', 'id_nhacungcap', '=', 'nha_cung_caps.id')
        ->select('nhap_xe_mays.id', 'tennhacungcap', 'hoten', 'nhap_xe_mays.created_at')
        ->get();
    }

    public function scopeDanhSachTheoID($query, $id){
    	return $query->join('nhan_viens', 'id_nhanvien', '=', 'nhan_viens.id')
    	->join('nha_cung_caps', 'id_nhacungcap', '=', 'nha_cung_caps.id')
    	->select('nhap_xe_mays.id', 'tennhacungcap', 'nha_cung_caps.diachi', 'nha_cung_caps.sodienthoai', 'nha_cung_caps.email', 'hoten', 'nhap_xe_mays.created_at')
        ->where('nhap_xe_mays.id', $id)
    	->first();
    }
}
