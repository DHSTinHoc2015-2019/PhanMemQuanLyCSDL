<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NhanVien extends Model
{
    protected $table = 'nhan_viens';

    public function users(){
    	return $this->hasOne('App\User', 'id_nhanvien', 'id');
    }

    public function chucvu(){
    	return $this->belongsTo('App\ChucVu', 'id_chucvu', 'id');
    }

    public function nhapxe(){
        return $this->hasMany('App\NhapXe', 'id_nhanvien', 'id');
    }

    //select count(*) from nhan_viens where chuoibaomat like '%...%'
    function scopeKiemTraChuoiBaoMat($query, $str){
    	return $query->where('chuoibaomat', 'like', $str)->count();
    }

    //select id from nhan_viens where chuoibaomat like '%...%'
    function scopeTimIDTheoChuoiBaoMat($query, $str){
        return $query->select('id')->where('chuoibaomat', 'like', $str)->pluck('id');
    }
    //max id
    function scopeMaxID($query){
        return $query->max('id');
    }

    function scopeDanhSach($query){
        return $query->join('chuc_vus', 'id_chucvu', '=', 'chuc_vus.id')
        ->select('nhan_viens.id', 'hoten', 'ngaysinh', 'gioitinh', 'socmnd', 'sodienthoai', 'quequan', 'chuoibaomat', 'img','luongcoban','hesoluong', 'phucap', 'tenchucvu')->get();
    }

    function scopeDanhSachTheoChucVu($query, $chucvu){
        return $query->join('chuc_vus', 'id_chucvu', '=', 'chuc_vus.id')
        ->select('nhan_viens.id', 'hoten', 'ngaysinh', 'gioitinh', 'socmnd', 'sodienthoai', 'quequan', 'chuoibaomat', 'img','luongcoban','hesoluong', 'phucap', 'tenchucvu')
        ->where('tenchucvu', $chucvu)
        ->get();
    }

    function scopeDanhSachTheoGioiTinh($query, $gioitinh){
        return $query->join('chuc_vus', 'id_chucvu', '=', 'chuc_vus.id')
        ->select('nhan_viens.id', 'hoten', 'ngaysinh', 'gioitinh', 'socmnd', 'sodienthoai', 'quequan', 'chuoibaomat', 'img','luongcoban','hesoluong', 'phucap', 'tenchucvu')
        ->where('gioitinh', $gioitinh)
        ->get();
    }
}
