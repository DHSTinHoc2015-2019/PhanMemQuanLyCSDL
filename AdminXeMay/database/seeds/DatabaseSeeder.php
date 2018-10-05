<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        //Seed for table chuc_vus
    	$faker = Faker\Factory::create();
    	DB::table('chuc_vus')->insert([
    		'tenchucvu' => 'Giám đốc',
    		'luongcoban' => 3950000,
    		'hesoluong' => 10,
    		'created_at' => date("Y-m-d"),
    	]);
    	DB::table('chuc_vus')->insert([
    		'tenchucvu' => 'Phó giám đốc',
    		'luongcoban' => 3950000,
    		'hesoluong' => 4,
    		'created_at' => date("Y-m-d"),
    	]);
    	DB::table('chuc_vus')->insert([
    		'tenchucvu' => 'Trưởng phòng',
    		'luongcoban' => 3950000,
    		'hesoluong' => 3,
    		'created_at' => date("Y-m-d"),
    	]);
    	DB::table('chuc_vus')->insert([
    		'tenchucvu' => 'Kế toán',
    		'luongcoban' => 3950000,
    		'hesoluong' => 2.5,
    		'created_at' => date("Y-m-d"),
    	]);
    	DB::table('chuc_vus')->insert([
    		'tenchucvu' => 'Nhân viên sửa chữa',
    		'luongcoban' => 3950000,
    		'hesoluong' => 2,
    		'created_at' => date("Y-m-d"),
    	]);
    	DB::table('chuc_vus')->insert([
    		'tenchucvu' => 'Nhân viên quản lý kho',
    		'luongcoban' => 3950000,
    		'hesoluong' => 2,
    		'created_at' => date("Y-m-d"),
    	]);
    	DB::table('chuc_vus')->insert([
    		'tenchucvu' => 'Nhân viên bán hàng',
    		'luongcoban' => 3950000,
    		'hesoluong' => 2,
    		'created_at' => date("Y-m-d"),
    	]);
    	DB::table('chuc_vus')->insert([
    		'tenchucvu' => 'Bảo vệ',
    		'luongcoban' => 3950000,
    		'hesoluong' => 1.7,
    		'created_at' => date("Y-m-d"),
    	]);

    	//Seed for table nhanv_viens
    	$arrGioiTinh = array("Nam", "Nữ");
    	DB::table('nhan_viens')->insert([
    		'id_chucvu' => 1,
    		'hoten' => 'Trần Giám Đốc',
    		'ngaysinh' => date("Y-m-d"),
    		'gioitinh'=>'Nam',
            'socmnd'=>'197243945',
    		'sodienthoai'=>'0123456789',
    		'quequan'=>'Huế',
            'chuoibaomat'=> substr(md5(rand()), 0, 10),
    		'phucap'=> 0,
    		'img'=> '1.jpg',
    		'created_at' => date("Y-m-d"),
    	]);

    	DB::table('nhan_viens')->insert([
    		'id_chucvu' => 2,
    		'hoten' => 'Trần Phó Giám Đốc',
    		'ngaysinh' => date("Y-m-d"),
    		'gioitinh' => $arrGioiTinh[array_rand($arrGioiTinh, 1)],
            'socmnd'=>'197243945',
    		'sodienthoai'=>'0123456789',
    		'quequan'=>'Huế',
            'chuoibaomat'=> substr(md5(rand()), 0, 10),
    		'phucap'=> 0,
    		'img'=> '2.jpg',
    		'created_at' => date("Y-m-d"),
    	]);

    	DB::table('nhan_viens')->insert([
    		'id_chucvu' => 3,
    		'hoten' => 'Trần Trưởng Phòng',
    		'ngaysinh' => date("Y-m-d"),
    		'gioitinh' => $arrGioiTinh[array_rand($arrGioiTinh, 1)],
            'socmnd'=>'197243945',
    		'sodienthoai'=>'0123456789',
    		'quequan'=>'Huế',
            'chuoibaomat'=> substr(md5(rand()), 0, 10),
    		'phucap'=> 0,
    		'img'=> '3.jpg',
    		'created_at' => date("Y-m-d"),
    	]);

    	DB::table('nhan_viens')->insert([
    		'id_chucvu' => 4,
    		'hoten' => 'Trần Kế Toán',
    		'ngaysinh' => date("Y-m-d"),
    		'gioitinh' => $arrGioiTinh[array_rand($arrGioiTinh, 1)],
            'socmnd'=>'197243945',
    		'sodienthoai'=>'0123456789',
    		'quequan'=>'Huế',
            'chuoibaomat'=> substr(md5(rand()), 0, 10),
    		'phucap'=> 0,
    		'img'=> '4.jpg',
    		'created_at' => date("Y-m-d"),
    	]);

    	DB::table('nhan_viens')->insert([
    		'id_chucvu' => 5,
    		'hoten' => 'Trần Sửa Chữa',
    		'ngaysinh' => date("Y-m-d"),
    		'gioitinh' => $arrGioiTinh[array_rand($arrGioiTinh, 1)],
            'socmnd'=>'197243945',
    		'sodienthoai'=>'0123456789',
    		'quequan'=>'Huế',
            'chuoibaomat'=> substr(md5(rand()), 0, 10),
    		'phucap'=> 0,
    		'img'=> '5.jpg',
    		'created_at' => date("Y-m-d"),
    	]);

    	DB::table('nhan_viens')->insert([
    		'id_chucvu' => 6,
    		'hoten' => 'Trần Quản Lý Kho',
    		'ngaysinh' => date("Y-m-d"),
    		'gioitinh' => $arrGioiTinh[array_rand($arrGioiTinh, 1)],
            'socmnd'=>'197243945',
    		'sodienthoai'=>'0123456789',
    		'quequan'=>'Huế',
            'chuoibaomat'=> substr(md5(rand()), 0, 10),
    		'phucap'=> 0,
    		'img'=> '6.jpg',
    		'created_at' => date("Y-m-d"),
    	]);

    	DB::table('nhan_viens')->insert([
    		'id_chucvu' => 7,
    		'hoten' => 'Trần Bán Hàng 1',
    		'ngaysinh' => date("Y-m-d"),
    		'gioitinh' => $arrGioiTinh[array_rand($arrGioiTinh, 1)],
            'socmnd'=>'197243945',
    		'sodienthoai'=>'0123456789',
    		'quequan'=>'Huế',
            'chuoibaomat'=> substr(md5(rand()), 0, 10),
    		'phucap'=> 0,
    		'img'=> '7.jpg',
    		'created_at' => date("Y-m-d"),
    	]);

    	DB::table('nhan_viens')->insert([
    		'id_chucvu' => 7,
    		'hoten' => 'Trần Bán Hàng 2',
    		'ngaysinh' => date("Y-m-d"),
    		'gioitinh' => $arrGioiTinh[array_rand($arrGioiTinh, 1)],
            'socmnd'=>'197243945',
    		'sodienthoai'=>'0123456789',
    		'quequan'=>'Huế',
            'chuoibaomat'=> substr(md5(rand()), 0, 10),
    		'phucap'=> 0,
    		'img'=> '8.jpg',
    		'created_at' => date("Y-m-d"),
    	]);

    	DB::table('nhan_viens')->insert([
    		'id_chucvu' => 8,
    		'hoten' => 'Trần Bảo Vệ',
    		'ngaysinh' => date("Y-m-d"),
    		'gioitinh' => $arrGioiTinh[array_rand($arrGioiTinh, 1)],
            'socmnd'=>'197243945',
    		'sodienthoai'=>'0123456789',
    		'quequan'=>'Huế',
            'chuoibaomat'=> substr(md5(rand()), 0, 10),
    		'phucap'=> 0,
    		'img'=> '9.jpg',
    		'created_at' => date("Y-m-d"),
    	]);

    	//Seed for table users
    	DB::table('users')->insert([
    		'name' => 'admin',
    		'email' => 'admin@gmail.com',
    		'password' => bcrypt('123456'),
    		'id_nhanvien' => 1,
    		'quyen'=>'admin',
    		'created_at' => date("Y-m-d"),
    	]);
    	$countNhanVien = App\NhanVien::count();
    	for ($i = 2; $i <= $countNhanVien; $i++) {
    		DB::table('users')->insert([
    			'name' => $faker->unique()->userName,
    			'email' => $faker->unique()->safeEmail,
    			'password' => bcrypt('123456'),
    			'id_nhanvien' => $i,
    			'quyen'=>'user',
    			'created_at' => date("Y-m-d"),
    		]);
    	}

        //Seed for table nha_cung_caps
        DB::table('nha_cung_caps')->insert([
            'tennhacungcap' => 'Nhà cung cấp A',
            'diachi' => 'admin@gmail.com',
            'email' => 'admin@gmail.com',
            'sodienthoai' => '0123456789',
            'created_at' => date("Y-m-d"),
        ]);

        //Seed for table khach_hangs
        for ($i=0; $i < 10; $i++) { 
            DB::table('khach_hangs')->insert([
                'tenkhachhang' => $faker->name,
                'ngaysinh' =>$faker->date('Y-m-d', 'now'),
                'gioitinh' => $arrGioiTinh[array_rand($arrGioiTinh, 1)],
                'soCMND' => '197243945',
                'diachi' => $faker->address,
                'sodienthoai' => $faker->phoneNumber,
                'created_at' => date("Y-m-d"),
            ]);
        }
         //Seed for table loai_bao_hanhs
         DB::table('loai_bao_hanhs')->insert([
            'tenloaibaohanh' => 'Chưa chọn',
            'thoigianbaohanh' => 0,
            'imgBH' => '400x600.jpg',
            'created_at' => date("Y-m-d"),
        ]);

        DB::table('loai_bao_hanhs')->insert([
            'tenloaibaohanh' => 'Loại 2 năm',
            'thoigianbaohanh' => 24,
            'imgBH' => 'BH1.jpg',
            'created_at' => date("Y-m-d"),
        ]);

        DB::table('loai_bao_hanhs')->insert([
            'tenloaibaohanh' => 'Loại 3 năm',
            'thoigianbaohanh' => 36,
            'imgBH' => 'BH2.jpg',
            'created_at' => date("Y-m-d"),
        ]);

        //Seed for table xe_mays
        DB::table('xe_mays')->insert([
            'tenxe' => 'Air Blade',
            'mauxe' => 'Xám Đen',
            'dongia' => round($faker->numberBetween(30000000, 50000000), -6),
            'soluong' => 1,
            'namsanxuat' => 2018,
            'dungtichxylanh' => 125,
            'noisanxuat' => 'Nhật Bản',
            'donvitinh' => 'Chiếc',
            'img' => '1.jpg',
            'id_loaibaohanh' => 3,
            'created_at' => date("Y-m-d"),
        ]);

         DB::table('xe_mays')->insert([
            'tenxe' => 'Air Blade',
            'mauxe' => 'Trắng Đen',
            'dongia' => round($faker->numberBetween(30000000, 50000000), -6),
            'soluong' => 2,
            'namsanxuat' => 2018,
            'dungtichxylanh' => 125,
            'noisanxuat' => 'Nhật Bản',
            'donvitinh' => 'Chiếc',
            'img' => '2.jpg',
            'id_loaibaohanh' => 3,
            'created_at' => date("Y-m-d"),
        ]);

         DB::table('xe_mays')->insert([
            'tenxe' => 'Dream',
            'mauxe' => 'Đen',
            'dongia' => round($faker->numberBetween(30000000, 50000000), -6),
            'soluong' => 3,
            'namsanxuat' => 2018,
            'dungtichxylanh' => 125,
            'noisanxuat' => 'Nhật Bản',
            'donvitinh' => 'Chiếc',
            'img' => '3.jpg',
            'id_loaibaohanh' => 2,
            'created_at' => date("Y-m-d"),
        ]); 

        DB::table('xe_mays')->insert([
            'tenxe' => 'Furure',
            'mauxe' => 'Xanh',
            'dongia' => round($faker->numberBetween(30000000, 50000000), -6),
            'soluong' => 3,
            'namsanxuat' => 2018,
            'dungtichxylanh' => 125,
            'noisanxuat' => 'Nhật Bản',
            'donvitinh' => 'Chiếc',
            'img' => '4.jpg',
            'id_loaibaohanh' => 2,
            'created_at' => date("Y-m-d"),
        ]);

        DB::table('xe_mays')->insert([
            'tenxe' => 'Vision',
            'mauxe' => 'Xanh nâu',
            'dongia' => round($faker->numberBetween(30000000, 50000000), -6),
            'soluong' => 3,
            'namsanxuat' => 2018,
            'dungtichxylanh' => 125,
            'noisanxuat' => 'Nhật Bản',
            'donvitinh' => 'Chiếc',
            'img' => '5.jpg',
            'id_loaibaohanh' => 2,
            'created_at' => date("Y-m-d"),
        ]);

        //Seed for table nhap_xe_mays
        for ($i=0; $i < 5; $i++) { 
            DB::table('nhap_xe_mays')->insert([
                'id_nhanvien' => 6,
                'id_nhacungcap' => 1,
                'created_at' => date("Y-m-d"),
            ]);
        }

        
        //Seed for table chi_tiet_nhap_xe_mays
        for ($i=0; $i < 5; $i++) { 
            DB::table('chi_tiet_nhap_xe_mays')->insert([
                'id_nhapxemay' => 1,
                'id_xemay' => $i + 1,
                'dongianhap' => 40000000 + $i * 1000000,
                'soluong' => $i + 2,
                'created_at' => date("Y-m-d"),
            ]);
        }
 		
 		//Seed for table hoa_don_ban_xe_mays
        for ($i=0; $i < 5; $i++) { 
            DB::table('hoa_don_ban_xe_mays')->insert([
                'id_khachhang' => $i + 1,
                'id_nhanvien' => 8,
                'id_xemay' => $i + 1,
                'dongiaban' => 40000000 + $i * 1000000,
                'soluong' => 1,
                'created_at' => date("Y-m-d"),
            ]);
        }


        //Seed for table loai_phu_tungs
        DB::table('loai_phu_tungs')->insert([
            'tenphutung' => 'Lốp xe',
            'donvitinh' => 'Cái',
            'imgphutung' => 'LopXe.jpg',
            'created_at' => date("Y-m-d"),
        ]); 

        DB::table('loai_phu_tungs')->insert([
            'tenphutung' => 'Ắc quy',
            'donvitinh' => 'Cái',
            'imgphutung' => 'AcQuy.jpg',
            'created_at' => date("Y-m-d"),
        ]);

        DB::table('loai_phu_tungs')->insert([
            'tenphutung' => 'Bugi',
            'donvitinh' => 'Cái',
            'imgphutung' => 'Bugi.jpg',
            'created_at' => date("Y-m-d"),
        ]);

        DB::table('loai_phu_tungs')->insert([
            'tenphutung' => 'Má phanh',
            'donvitinh' => 'Cái',
            'imgphutung' => 'MaPhanh.jpg',
            'created_at' => date("Y-m-d"),
        ]);

        DB::table('loai_phu_tungs')->insert([
            'tenphutung' => 'Nhông xích',
            'donvitinh' => 'Cái',
            'imgphutung' => 'NhongXich.jpg',
            'created_at' => date("Y-m-d"),
        ]);

        DB::table('loai_phu_tungs')->insert([
            'tenphutung' => 'Tấm lọc gió',
            'donvitinh' => 'Cái',
            'imgphutung' => 'TamLocGio.jpg',
            'created_at' => date("Y-m-d"),
        ]);


        //Seed for table thong_tin_phu_tungs
        DB::table('phu_tungs')->insert([
            'id_loaiphutung' => 1,
            'loaixe' => 'Air blade 125',
            'soluong' => 5,
            'dongia' => 100000,
            'created_at' => date("Y-m-d"),
        ]);

        DB::table('phu_tungs')->insert([
            'id_loaiphutung' => 1,
            'loaixe' => 'Click',
            'soluong' => 5,
            'dongia' => 100000,
            'created_at' => date("Y-m-d"),
        ]);

        DB::table('phu_tungs')->insert([
            'id_loaiphutung' => 1,
            'loaixe' => 'LEAD 110',
            'soluong' => 5,
            'dongia' => 100000,
            'created_at' => date("Y-m-d"),
        ]);

        DB::table('phu_tungs')->insert([
            'id_loaiphutung' => 1,
            'loaixe' => 'Future 125; Wave RSX 110; Blade 110; Super Dream 110; Wave alpha 100',
            'soluong' => 5,
            'dongia' => 100000,
            'created_at' => date("Y-m-d"),
        ]);

        DB::table('phu_tungs')->insert([
            'id_loaiphutung' => 1,
            'loaixe' => 'SH Mode 125',
            'soluong' => 5,
            'dongia' => 100000,
            'created_at' => date("Y-m-d"),
        ]);

           //Seed for table nhap_phu_tung_phu_kiens
        for ($i=0; $i < 5; $i++) { 
            DB::table('nhap_phu_tung_phu_kiens')->insert([
                'id_nhanvien' => 6,
                'id_nhacungcap' => 1,
                'created_at' => date("Y-m-d"),
            ]);
        }

        //Seed for table chi_tiet_nhap_phu_tungs
        DB::table('chi_tiet_nhap_phu_tungs')->insert([
            'id_nhapphutungphukien' => 1,
            'id_phutung' => 1,
            'soluong' => 3,
            'gianhap' => 350000,
            'created_at' => date("Y-m-d"),
        ]);

        DB::table('chi_tiet_nhap_phu_tungs')->insert([
            'id_nhapphutungphukien' => 1,
            'id_phutung' => 2,
            'soluong' => 4,
            'gianhap' => 307000,
            'created_at' => date("Y-m-d"),
        ]);

        DB::table('chi_tiet_nhap_phu_tungs')->insert([
            'id_nhapphutungphukien' => 1,
            'id_phutung' => 3,
            'soluong' => 5,
            'gianhap' => 319000,
            'created_at' => date("Y-m-d"),
        ]);

        DB::table('chi_tiet_nhap_phu_tungs')->insert([
            'id_nhapphutungphukien' => 1,
            'id_phutung' => 4,
            'soluong' => 6,
            'gianhap' => 253000,
            'created_at' => date("Y-m-d"),
        ]);

        DB::table('chi_tiet_nhap_phu_tungs')->insert([
            'id_nhapphutungphukien' => 1,
            'id_phutung' => 5,
            'soluong' => 7,
            'gianhap' => 392000,
            'created_at' => date("Y-m-d"),
        ]);

     //    //Seed for table bao_hanhs
     //    DB::table('bao_hanhs')->insert([
     //        'id_khachhang' => 1,
     //        'id_xemay' => 1,
     //        'created_at' => date("Y-m-d"),
     //    ]);

     //    //Seed for table chi_tiet_bao_hanhs
     //    DB::table('chi_tiet_bao_hanhs')->insert([
     //        'id_baohanh' => 1,
     //        'id_nhanvien' => 1,
     //        'congviecbaohanh' => 'Vệ sinh, kiểm tra',
     //        'soKM' => 1000,
     //        'sothang' => 4,
     //        'created_at' => date("Y-m-d"),
     //    ]);





     //    //Seed for table thong_tin_phu_kiens
     //    DB::table('thong_tin_phu_kiens')->insert([
     //        'id_thongtinchungxe' => 1,
     //        'tenphukien' => 'Tay phanh',
     //        'imgphukien' => 'TayPhanhAB.jpg',
     //        'created_at' => date("Y-m-d"),
     //    ]);

     //    DB::table('thong_tin_phu_kiens')->insert([
     //        'id_thongtinchungxe' => 1,
     //        'tenphukien' => 'Ốp pô',
     //        'imgphukien' => 'OppoAB.jpg',
     //        'created_at' => date("Y-m-d"),
     //    ]);

     //    DB::table('thong_tin_phu_kiens')->insert([
     //        'id_thongtinchungxe' => 1,
     //        'tenphukien' => 'Kẹp bảo vệ dây phanh trước',
     //        'imgphukien' => 'Kep.jpg',
     //        'created_at' => date("Y-m-d"),
     //    ]);

     //    DB::table('thong_tin_phu_kiens')->insert([
     //        'id_thongtinchungxe' => 1,
     //        'tenphukien' => 'Gác để chân sau',
     //        'imgphukien' => 'GacChanSauAB.jpg',
     //        'created_at' => date("Y-m-d"),
     //    ]);

     //    DB::table('thong_tin_phu_kiens')->insert([
     //        'id_thongtinchungxe' => 1,
     //        'tenphukien' => 'Ốp mặt nạ trước',
     //        'imgphukien' => 'OpMatNaTruoc.jpg',
     //        'created_at' => date("Y-m-d"),
     //    ]);


     //    //Seed for table chi_tiet_nhap_phu_kiens
     //    DB::table('chi_tiet_nhap_phu_kiens')->insert([
     //        'id_nhapphutungphukien' => 1,
     //        'id_thongtinphukien' => 1,
     //        'soluong' => 5,
     //        'gianhap' => 499000,
     //        'created_at' => date("Y-m-d"),
     //    ]);

     //    DB::table('chi_tiet_nhap_phu_kiens')->insert([
     //        'id_nhapphutungphukien' => 1,
     //        'id_thongtinphukien' => 2,
     //        'soluong' => 5,
     //        'gianhap' => 160000,
     //        'created_at' => date("Y-m-d"),
     //    ]);

     //    DB::table('chi_tiet_nhap_phu_kiens')->insert([
     //        'id_nhapphutungphukien' => 1,
     //        'id_thongtinphukien' => 3,
     //        'soluong' => 5,
     //        'gianhap' => 479000,
     //        'created_at' => date("Y-m-d"),
     //    ]);

     //    DB::table('chi_tiet_nhap_phu_kiens')->insert([
     //        'id_nhapphutungphukien' => 1,
     //        'id_thongtinphukien' => 4,
     //        'soluong' => 5,
     //        'gianhap' => 709000,
     //        'created_at' => date("Y-m-d"),
     //    ]);

     //    DB::table('chi_tiet_nhap_phu_kiens')->insert([
     //        'id_nhapphutungphukien' => 1,
     //        'id_thongtinphukien' => 5,
     //        'soluong' => 5,
     //        'gianhap' => 200000,
     //        'created_at' => date("Y-m-d"),
     //    ]);

     //    //Seed for table phu_tungs
     //    DB::table('phu_tungs')->insert([
     //        'id_chitietnhapphutung' => 1,
     //        'giabanphutung' => 400000,
     //        'created_at' => date("Y-m-d"),
     //    ]);

     //    DB::table('phu_tungs')->insert([
     //        'id_chitietnhapphutung' => 2,
     //        'giabanphutung' => 350000,
     //        'created_at' => date("Y-m-d"),
     //    ]);

     //    DB::table('phu_tungs')->insert([
     //        'id_chitietnhapphutung' => 3,
     //        'giabanphutung' => 350000,
     //        'created_at' => date("Y-m-d"),
     //    ]);

     //    DB::table('phu_tungs')->insert([
     //        'id_chitietnhapphutung' => 4,
     //        'giabanphutung' => 300000,
     //        'created_at' => date("Y-m-d"),
     //    ]);

     //    DB::table('phu_tungs')->insert([
     //        'id_chitietnhapphutung' => 5,
     //        'giabanphutung' => 400000,
     //        'created_at' => date("Y-m-d"),
     //    ]);

    }
}
