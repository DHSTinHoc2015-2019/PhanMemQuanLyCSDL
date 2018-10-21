-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 21, 2018 at 09:55 PM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pmqtcsdl`
--
CREATE DATABASE IF NOT EXISTS `pmqtcsdl` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `pmqtcsdl`;

-- --------------------------------------------------------

--
-- Table structure for table `chi_tiet_hoa_don_ban_phu_kiens`
--

CREATE TABLE `chi_tiet_hoa_don_ban_phu_kiens` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_banphutungphukien` int(10) UNSIGNED NOT NULL,
  `id_phukien` int(10) UNSIGNED NOT NULL,
  `dongiaban` int(11) NOT NULL,
  `soluongban` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chi_tiet_hoa_don_ban_phu_kiens`
--

INSERT INTO `chi_tiet_hoa_don_ban_phu_kiens` (`id`, `id_banphutungphukien`, `id_phukien`, `dongiaban`, `soluongban`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 550000, 1, '2018-10-14 17:00:00', NULL),
(2, 1, 2, 200000, 1, '2018-10-14 17:00:00', NULL),
(3, 1, 3, 550000, 1, '2018-10-14 17:00:00', NULL),
(4, 1, 4, 750000, 1, '2018-10-14 17:00:00', NULL),
(5, 1, 5, 250000, 1, '2018-10-14 17:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `chi_tiet_hoa_don_ban_phu_tungs`
--

CREATE TABLE `chi_tiet_hoa_don_ban_phu_tungs` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_banphutungphukien` int(10) UNSIGNED NOT NULL,
  `id_phutung` int(10) UNSIGNED NOT NULL,
  `dongiaban` int(11) NOT NULL,
  `soluongban` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chi_tiet_hoa_don_ban_phu_tungs`
--

INSERT INTO `chi_tiet_hoa_don_ban_phu_tungs` (`id`, `id_banphutungphukien`, `id_phutung`, `dongiaban`, `soluongban`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 400000, 1, '2018-10-14 17:00:00', NULL),
(2, 1, 2, 400000, 1, '2018-10-14 17:00:00', NULL),
(3, 1, 3, 400000, 1, '2018-10-14 17:00:00', NULL),
(4, 1, 4, 400000, 1, '2018-10-14 17:00:00', NULL),
(5, 1, 5, 350000, 1, '2018-10-14 17:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `chi_tiet_nhap_phu_kiens`
--

CREATE TABLE `chi_tiet_nhap_phu_kiens` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_nhapphutungphukien` int(10) UNSIGNED NOT NULL,
  `id_phukien` int(10) UNSIGNED NOT NULL,
  `gianhap` int(11) NOT NULL,
  `soluongnhap` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chi_tiet_nhap_phu_kiens`
--

INSERT INTO `chi_tiet_nhap_phu_kiens` (`id`, `id_nhapphutungphukien`, `id_phukien`, `gianhap`, `soluongnhap`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 499000, 5, '2018-10-14 17:00:00', NULL),
(2, 1, 2, 160000, 5, '2018-10-14 17:00:00', NULL),
(3, 1, 3, 479000, 5, '2018-10-14 17:00:00', NULL),
(4, 1, 4, 709000, 5, '2018-10-14 17:00:00', NULL),
(5, 1, 5, 200000, 5, '2018-10-14 17:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `chi_tiet_nhap_phu_tungs`
--

CREATE TABLE `chi_tiet_nhap_phu_tungs` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_nhapphutungphukien` int(10) UNSIGNED NOT NULL,
  `id_phutung` int(10) UNSIGNED NOT NULL,
  `gianhap` int(11) NOT NULL,
  `soluongnhap` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chi_tiet_nhap_phu_tungs`
--

INSERT INTO `chi_tiet_nhap_phu_tungs` (`id`, `id_nhapphutungphukien`, `id_phutung`, `gianhap`, `soluongnhap`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 350000, 3, '2018-10-14 17:00:00', NULL),
(2, 1, 2, 307000, 4, '2018-10-14 17:00:00', NULL),
(3, 1, 3, 319000, 5, '2018-10-14 17:00:00', NULL),
(4, 1, 4, 253000, 6, '2018-10-14 17:00:00', NULL),
(5, 1, 5, 392000, 7, '2018-10-14 17:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `chi_tiet_nhap_xe_mays`
--

CREATE TABLE `chi_tiet_nhap_xe_mays` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_nhapxemay` int(10) UNSIGNED NOT NULL,
  `id_xemay` int(10) UNSIGNED NOT NULL,
  `dongianhap` int(11) NOT NULL,
  `soluong` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chi_tiet_nhap_xe_mays`
--

INSERT INTO `chi_tiet_nhap_xe_mays` (`id`, `id_nhapxemay`, `id_xemay`, `dongianhap`, `soluong`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 40000000, 2, '2018-10-14 17:00:00', NULL),
(2, 1, 2, 41000000, 3, '2018-10-14 17:00:00', NULL),
(3, 1, 3, 42000000, 4, '2018-10-14 17:00:00', NULL),
(4, 1, 4, 43000000, 5, '2018-10-14 17:00:00', NULL),
(5, 1, 5, 44000000, 6, '2018-10-14 17:00:00', NULL),
(6, 2, 6, 17000000, 11, '2018-10-19 19:24:56', '2018-10-19 19:24:56'),
(7, 2, 7, 17000000, 8, '2018-10-19 19:25:12', '2018-10-19 19:25:12'),
(8, 2, 8, 17000000, 5, '2018-10-19 19:25:30', '2018-10-19 19:25:30'),
(9, 2, 9, 17000000, 5, '2018-10-19 19:25:48', '2018-10-19 19:25:48'),
(10, 3, 11, 49000000, 3, '2018-10-19 19:34:48', '2018-10-19 19:34:48'),
(11, 3, 10, 49000000, 4, '2018-10-19 19:35:21', '2018-10-19 19:35:21'),
(12, 3, 12, 49000000, 5, '2018-10-19 19:35:35', '2018-10-19 19:35:35'),
(13, 3, 13, 49000000, 2, '2018-10-19 19:35:54', '2018-10-19 19:35:54'),
(14, 4, 14, 35290000, 3, '2018-10-19 19:41:11', '2018-10-19 19:41:11'),
(15, 4, 15, 35290000, 2, '2018-10-19 19:41:27', '2018-10-19 19:41:27'),
(16, 4, 16, 35290000, 2, '2018-10-19 19:41:47', '2018-10-19 19:41:47');

-- --------------------------------------------------------

--
-- Table structure for table `chuc_vus`
--

CREATE TABLE `chuc_vus` (
  `id` int(10) UNSIGNED NOT NULL,
  `tenchucvu` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `luongcoban` int(10) UNSIGNED NOT NULL,
  `hesoluong` double NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chuc_vus`
--

INSERT INTO `chuc_vus` (`id`, `tenchucvu`, `luongcoban`, `hesoluong`, `created_at`, `updated_at`) VALUES
(1, 'Giám đốc', 3950000, 10, '2018-10-14 17:00:00', NULL),
(2, 'Phó giám đốc', 3950000, 6, '2018-10-14 17:00:00', '2018-10-19 15:43:14'),
(3, 'Trưởng phòng', 3950000, 5, '2018-10-14 17:00:00', '2018-10-19 15:40:20'),
(4, 'Kế toán', 3950000, 2.5, '2018-10-14 17:00:00', NULL),
(5, 'Nhân viên sửa chữa', 3950000, 2, '2018-10-14 17:00:00', NULL),
(6, 'Nhân viên quản lý kho', 3950000, 2, '2018-10-14 17:00:00', NULL),
(7, 'Nhân viên bán hàng', 3950000, 2, '2018-10-14 17:00:00', NULL),
(8, 'Bảo vệ', 3950000, 1.1, '2018-10-14 17:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hoa_don_ban_phu_tung_phu_kiens`
--

CREATE TABLE `hoa_don_ban_phu_tung_phu_kiens` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_khachhang` int(10) UNSIGNED NOT NULL,
  `id_nhanvien` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hoa_don_ban_phu_tung_phu_kiens`
--

INSERT INTO `hoa_don_ban_phu_tung_phu_kiens` (`id`, `id_khachhang`, `id_nhanvien`, `created_at`, `updated_at`) VALUES
(1, 6, 7, '2018-10-14 17:00:00', NULL),
(2, 7, 7, '2018-10-14 17:00:00', NULL),
(3, 8, 7, '2018-10-14 17:00:00', NULL),
(4, 9, 7, '2018-10-14 17:00:00', NULL),
(5, 10, 7, '2018-10-14 17:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hoa_don_ban_xe_mays`
--

CREATE TABLE `hoa_don_ban_xe_mays` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_khachhang` int(10) UNSIGNED NOT NULL,
  `id_nhanvien` int(10) UNSIGNED NOT NULL,
  `id_xemay` int(10) UNSIGNED NOT NULL,
  `dongiaban` int(11) NOT NULL,
  `soluong` int(11) NOT NULL,
  `thueVAT` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hoa_don_ban_xe_mays`
--

INSERT INTO `hoa_don_ban_xe_mays` (`id`, `id_khachhang`, `id_nhanvien`, `id_xemay`, `dongiaban`, `soluong`, `thueVAT`, `created_at`, `updated_at`) VALUES
(1, 1, 8, 1, 40000000, 1, 1, '2018-10-14 17:00:00', NULL),
(2, 2, 8, 2, 41000000, 1, 0, '2018-10-08 17:00:00', NULL),
(3, 3, 8, 3, 42000000, 1, 0, '2018-09-19 17:00:00', NULL),
(4, 4, 8, 4, 43000000, 1, 0, '2018-10-17 17:00:00', NULL),
(5, 5, 8, 5, 44000000, 1, 0, '2018-10-14 17:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `khach_hangs`
--

CREATE TABLE `khach_hangs` (
  `id` int(10) UNSIGNED NOT NULL,
  `tenkhachhang` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ngaysinh` date DEFAULT NULL,
  `gioitinh` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `soCMND` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diachi` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sodienthoai` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `khach_hangs`
--

INSERT INTO `khach_hangs` (`id`, `tenkhachhang`, `ngaysinh`, `gioitinh`, `soCMND`, `diachi`, `sodienthoai`, `created_at`, `updated_at`) VALUES
(1, 'Nikko Dickinson Sr.', '2010-11-14', 'Nam', '197243945', '8140 Una Tunnel\nWest Deanton, VT 46901-8440', '+1 (729) 766-2989', '2018-10-14 17:00:00', NULL),
(2, 'Candelario Kuhlman', '2003-05-02', 'Nam', '197243945', '89866 Eloisa Ferry Apt. 879\nNorth Nikitaville, ME 15752', '384.906.6226 x60635', '2018-10-14 17:00:00', NULL),
(3, 'Albina Vandervort', '2008-10-30', 'Nam', '197243945', '833 Archibald Lakes\nAshtynfurt, NJ 74170-7360', '661.717.5845 x7327', '2018-10-14 17:00:00', NULL),
(4, 'Micah Crona', '1985-02-14', 'Nam', '197243945', '757 White Street Suite 802\nNorth Myrl, IA 49911-6601', '670-604-4808 x190', '2018-10-14 17:00:00', NULL),
(5, 'Prof. Gaylord Schoen', '1977-10-08', 'Nam', '197243945', '8124 Adella Forge\nSchustermouth, AK 26809-9082', '476.953.1303 x46235', '2018-10-14 17:00:00', NULL),
(6, 'Jaime Waelchi', '1988-12-18', 'Nam', '197243945', '7178 Ernser Meadows Suite 153\nFisherberg, NH 08270', '1-465-706-4865 x94064', '2018-10-14 17:00:00', NULL),
(7, 'Jacey Von', '1980-01-14', 'Nữ', '197243945', '787 Mills Stream\nWest Raheem, DE 22024-8180', '559.261.1473', '2018-10-14 17:00:00', NULL),
(8, 'Everette Miller', '1971-11-19', 'Nữ', '197243945', '9377 O\'Kon Square Apt. 508\nEast Breanne, CT 05605-8122', '307-609-5746 x76337', '2018-10-14 17:00:00', NULL),
(9, 'Mr. Herbert Green', '1989-04-01', 'Nam', '197243945', '4246 Dickinson Haven\nRennershire, ND 94064', '758-223-0028 x0578', '2018-10-14 17:00:00', NULL),
(10, 'Fabiola Langosh', '1988-03-15', 'Nữ', '197243945', '74777 Gerhold Stravenue\nWest Colby, KY 11920', '1-467-530-5451', '2018-10-14 17:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `loai_bao_hanhs`
--

CREATE TABLE `loai_bao_hanhs` (
  `id` int(10) UNSIGNED NOT NULL,
  `tenloaibaohanh` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thoigianbaohanh` int(11) NOT NULL,
  `imgBH` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loai_bao_hanhs`
--

INSERT INTO `loai_bao_hanhs` (`id`, `tenloaibaohanh`, `thoigianbaohanh`, `imgBH`, `created_at`, `updated_at`) VALUES
(1, 'Chưa chọn', 0, '400x600.jpg', '2018-10-14 17:00:00', NULL),
(2, 'Loại 2 năm', 24, 'BH1.jpg', '2018-10-14 17:00:00', NULL),
(3, 'Loại 3 năm', 36, 'BH2.jpg', '2018-10-14 17:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `loai_phu_tungs`
--

CREATE TABLE `loai_phu_tungs` (
  `id` int(10) UNSIGNED NOT NULL,
  `tenphutung` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `donvitinh` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `imgphutung` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loai_phu_tungs`
--

INSERT INTO `loai_phu_tungs` (`id`, `tenphutung`, `donvitinh`, `imgphutung`, `created_at`, `updated_at`) VALUES
(1, 'Lốp xe', 'Cái', 'LopXe.jpg', '2018-10-14 17:00:00', NULL),
(2, 'Ắc quy', 'Cái', 'AcQuy.jpg', '2018-10-14 17:00:00', NULL),
(3, 'Bugi', 'Cái', 'Bugi.jpg', '2018-10-14 17:00:00', NULL),
(4, 'Má phanh', 'Cái', 'MaPhanh.jpg', '2018-10-14 17:00:00', NULL),
(5, 'Nhông xích', 'Cái', 'NhongXich.jpg', '2018-10-14 17:00:00', NULL),
(6, 'Tấm lọc gió', 'Cái', 'TamLocGio.jpg', '2018-10-14 17:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2013_10_04_223518_create_chuc_vus_table', 1),
(2, '2013_10_04_223644_create_nhan_viens_table', 1),
(3, '2014_10_12_000000_create_users_table', 1),
(4, '2014_10_12_100000_create_password_resets_table', 1),
(5, '2018_10_04_224242_create_nha_cung_caps_table', 1),
(6, '2018_10_04_224345_create_khach_hangs_table', 1),
(7, '2018_10_04_224440_create_loai_bao_hanhs_table', 1),
(8, '2018_10_04_224446_create_xe_mays_table', 1),
(9, '2018_10_04_224805_create_nhap_xe_mays_table', 1),
(10, '2018_10_04_224853_create_chi_tiet_nhap_xe_mays_table', 1),
(11, '2018_10_04_225039_create_hoa_don_ban_xe_mays_table', 1),
(12, '2018_10_06_012122_create_nhap_phu_tung_phu_kiens_table', 1),
(13, '2018_10_06_014720_create_loai_phu_tungs_table', 1),
(14, '2018_10_06_015116_create_phu_tungs_table', 1),
(15, '2018_10_06_015350_create_hoa_don_ban_phu_tung_phu_kiens_table', 1),
(16, '2018_10_06_015446_create_chi_tiet_hoa_don_ban_phu_tungs_table', 1),
(17, '2018_10_06_015911_create_chi_tiet_nhap_phu_tungs_table', 1),
(18, '2018_10_09_222536_create_phu_kiens_table', 1),
(19, '2018_10_09_223950_create_chi_tiet_nhap_phu_kiens_table', 1),
(20, '2018_10_09_224105_create_chi_tiet_hoa_don_ban_phu_kiens_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `nhan_viens`
--

CREATE TABLE `nhan_viens` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_chucvu` int(10) UNSIGNED NOT NULL,
  `hoten` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ngaysinh` date NOT NULL,
  `gioitinh` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `socmnd` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sodienthoai` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quequan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `chuoibaomat` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phucap` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `img` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nhan_viens`
--

INSERT INTO `nhan_viens` (`id`, `id_chucvu`, `hoten`, `ngaysinh`, `gioitinh`, `socmnd`, `sodienthoai`, `quequan`, `chuoibaomat`, `phucap`, `img`, `created_at`, `updated_at`) VALUES
(1, 1, 'Trần Giám Đốc', '1997-10-15', 'Nam', '197243945', '0123456789', 'Huế', '8be1e500a81', 0, '1.jpg', '2018-10-14 17:00:00', '2018-10-19 14:43:50'),
(2, 2, 'Trần Phó Giám Đốc', '1997-10-15', 'Nam', '197243945', '0123456789', 'Huế', '6bab5870a22', 0, '2.jpg', '2018-10-14 17:00:00', '2018-10-19 14:44:06'),
(3, 3, 'Trần Trưởng Phòng', '1990-10-15', 'Nữ', '197243945', '0123456789', 'Huế', '2d3b193fa73', 0, '3.jpg', '2018-10-14 17:00:00', '2018-10-19 14:44:43'),
(4, 4, 'Trần Kế Toán', '1985-10-15', 'Nam', '197243945', '0123456789', 'Huế', '07b645e41e4', 0, '4.jpg', '2018-10-14 17:00:00', '2018-10-19 14:44:56'),
(5, 5, 'Trần Sửa Chữa', '1980-10-15', 'Nam', '197243945', '0123456789', 'Huế', 'b07cb1c4915', 0, '5.jpg', '2018-10-14 17:00:00', '2018-10-19 14:45:10'),
(6, 6, 'Trần Quản Lý Kho', '1996-10-15', 'Nữ', '197243945', '0123456789', 'Huế', '3a299219346', 0, '6.jpg', '2018-10-14 17:00:00', '2018-10-19 14:45:23'),
(7, 7, 'Trần Bán Hàng 1', '1994-10-15', 'Nam', '197243945', '0123456789', 'Huế', '14539a22c67', 0, '7.jpg', '2018-10-14 17:00:00', '2018-10-19 14:46:01'),
(8, 7, 'Trần Bán Hàng 2', '1995-10-15', 'Nữ', '197243945', '0123456789', 'Huế', '627beeb9558', 0, '8.jpg', '2018-10-14 17:00:00', '2018-10-19 14:45:36'),
(9, 8, 'Trần Bảo Vệ', '1985-10-15', 'Nam', '197243945', '0123456789', 'Huế', '06e8d1c2069', 0, '9.jpg', '2018-10-14 17:00:00', '2018-10-19 14:46:28');

-- --------------------------------------------------------

--
-- Table structure for table `nhap_phu_tung_phu_kiens`
--

CREATE TABLE `nhap_phu_tung_phu_kiens` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_nhanvien` int(10) UNSIGNED NOT NULL,
  `id_nhacungcap` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nhap_phu_tung_phu_kiens`
--

INSERT INTO `nhap_phu_tung_phu_kiens` (`id`, `id_nhanvien`, `id_nhacungcap`, `created_at`, `updated_at`) VALUES
(1, 6, 1, '2018-10-14 17:00:00', NULL),
(2, 6, 1, '2018-10-14 17:00:00', NULL),
(3, 6, 1, '2018-10-14 17:00:00', NULL),
(4, 6, 1, '2018-10-14 17:00:00', NULL),
(5, 6, 1, '2018-10-14 17:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `nhap_xe_mays`
--

CREATE TABLE `nhap_xe_mays` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_nhanvien` int(10) UNSIGNED NOT NULL,
  `id_nhacungcap` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nhap_xe_mays`
--

INSERT INTO `nhap_xe_mays` (`id`, `id_nhanvien`, `id_nhacungcap`, `created_at`, `updated_at`) VALUES
(1, 6, 1, '2018-10-14 17:00:00', NULL),
(2, 6, 1, '2018-10-14 17:00:00', NULL),
(3, 6, 1, '2018-10-14 17:00:00', NULL),
(4, 6, 1, '2018-10-14 17:00:00', NULL),
(5, 6, 1, '2018-10-14 17:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `nha_cung_caps`
--

CREATE TABLE `nha_cung_caps` (
  `id` int(10) UNSIGNED NOT NULL,
  `tennhacungcap` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `diachi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sodienthoai` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nha_cung_caps`
--

INSERT INTO `nha_cung_caps` (`id`, `tennhacungcap`, `diachi`, `email`, `sodienthoai`, `created_at`, `updated_at`) VALUES
(1, 'Nhà cung cấp A', 'admin@gmail.com', 'admin@gmail.com', '0123456789', '2018-10-14 17:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `phu_kiens`
--

CREATE TABLE `phu_kiens` (
  `id` int(10) UNSIGNED NOT NULL,
  `tenphukien` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dongia` int(11) NOT NULL,
  `soluong` int(11) NOT NULL,
  `donvitinh` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `imgphukien` text COLLATE utf8mb4_unicode_ci,
  `id_xemays` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `phu_kiens`
--

INSERT INTO `phu_kiens` (`id`, `tenphukien`, `dongia`, `soluong`, `donvitinh`, `imgphukien`, `id_xemays`, `created_at`, `updated_at`) VALUES
(1, 'Tay phanh', 499000, 5, 'Cái', 'TayPhanhAB.jpg', 1, '2018-10-14 17:00:00', NULL),
(2, 'Ốp pô', 160000, 5, 'Cái', 'OppoAB.jpg', 1, '2018-10-14 17:00:00', NULL),
(3, 'Kẹp bảo vệ dây phanh trước', 479000, 5, 'Cái', 'Kep.jpg', 1, '2018-10-14 17:00:00', NULL),
(4, 'Gác để chân sau', 709000, 5, 'Cái', 'GacChanSauAB.jpg', 1, '2018-10-14 17:00:00', NULL),
(5, 'Ốp mặt nạ trước', 200000, 5, 'Cái', 'OpMatNaTruoc.jpg', 1, '2018-10-14 17:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `phu_tungs`
--

CREATE TABLE `phu_tungs` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_loaiphutung` int(10) UNSIGNED NOT NULL,
  `loaixe` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `soluong` int(11) NOT NULL,
  `dongia` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `phu_tungs`
--

INSERT INTO `phu_tungs` (`id`, `id_loaiphutung`, `loaixe`, `soluong`, `dongia`, `created_at`, `updated_at`) VALUES
(1, 1, 'Air blade 125', 5, 100000, '2018-10-14 17:00:00', NULL),
(2, 1, 'Click', 5, 100000, '2018-10-14 17:00:00', NULL),
(3, 1, 'LEAD 110', 5, 100000, '2018-10-14 17:00:00', NULL),
(4, 1, 'Future 125; Wave RSX 110; Blade 110; Super Dream 110; Wave alpha 100', 5, 100000, '2018-10-14 17:00:00', NULL),
(5, 1, 'SH Mode 125', 5, 100000, '2018-10-14 17:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_nhanvien` int(10) UNSIGNED NOT NULL,
  `quyen` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `id_nhanvien`, `quyen`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', NULL, '$2y$10$xc.vtGDyqGMlvQtOVPK2Y.xJJgKbV4VxrxwVIAx9vJqBFin8s0rTi', 1, 'admin', NULL, '2018-10-14 17:00:00', NULL),
(2, 'alexys25', 'lturner@example.org', NULL, '$2y$10$KBkpiLI0cGLiI5pmIo.URux6Y1WIumCuU5hmnHh5HqrQvRONSCFY2', 2, 'user', NULL, '2018-10-14 17:00:00', NULL),
(3, 'fritsch.emery', 'clemens.damore@example.com', NULL, '$2y$10$puyytwryi8tsP7usRlYIeOb8Eb9AQrnYDqtTXi.Yy7pjnyDGjSSfi', 3, 'user', NULL, '2018-10-14 17:00:00', NULL),
(4, 'emmett10', 'ephraim.schmeler@example.com', NULL, '$2y$10$/2WQM6MLK.HJ3TRM9H/KfeO4LrHKwbrBd70xBfT8F/GNi6LTob/Ry', 4, 'user', NULL, '2018-10-14 17:00:00', NULL),
(5, 'ullrich.trevor', 'schimmel.cory@example.net', NULL, '$2y$10$RrWR3/ZjDdWMCTh83df1u.1pYp.XPMX0sZNp0yQQQlBkGH8ecTfKq', 5, 'user', NULL, '2018-10-14 17:00:00', NULL),
(6, 'alisha.prohaska', 'gutkowski.aubree@example.net', NULL, '$2y$10$iFE4M4xpuFtvGaP2H6qUdejq2eSraIs1vNnVR2PbWF7dQYpSnUY0W', 6, 'user', NULL, '2018-10-14 17:00:00', NULL),
(7, 'apfannerstill', 'xoreilly@example.org', NULL, '$2y$10$Zt23eCRrSIwQTnJDYXeaUuRz7FpX/BeDkRIEeDatgPA1TFbDoMKSC', 7, 'user', NULL, '2018-10-14 17:00:00', NULL),
(8, 'salma.kilback', 'melvin.torp@example.com', NULL, '$2y$10$IceanbgQoYD83AIFfj12rO1ofBHlrV/PJ2CI1/MfYUZfk8FqLbkFO', 8, 'user', NULL, '2018-10-14 17:00:00', NULL),
(9, 'haag.ryleigh', 'vtillman@example.com', NULL, '$2y$10$LoVxyX7pU7eMpERjuQfzOeiZIF.N5NC4yx.VJoOaq1DoBUb0fVLZ6', 9, 'user', NULL, '2018-10-14 17:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `xe_mays`
--

CREATE TABLE `xe_mays` (
  `id` int(10) UNSIGNED NOT NULL,
  `tenxe` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mauxe` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dongia` int(11) NOT NULL,
  `soluong` int(11) NOT NULL,
  `namsanxuat` int(11) DEFAULT NULL,
  `dungtichxylanh` double DEFAULT NULL,
  `noisanxuat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `donvitinh` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `img` text COLLATE utf8mb4_unicode_ci,
  `id_loaibaohanh` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `xe_mays`
--

INSERT INTO `xe_mays` (`id`, `tenxe`, `mauxe`, `dongia`, `soluong`, `namsanxuat`, `dungtichxylanh`, `noisanxuat`, `donvitinh`, `img`, `id_loaibaohanh`, `created_at`, `updated_at`) VALUES
(1, 'Air Blade', 'Xám Đen', 45000000, 1, 2018, 125, 'Nhật Bản', 'Chiếc', '1.jpg', 3, '2018-10-14 17:00:00', NULL),
(2, 'Air Blade', 'Trắng Đen', 43000000, 2, 2018, 125, 'Nhật Bản', 'Chiếc', '2.jpg', 3, '2018-10-14 17:00:00', NULL),
(3, 'Dream', 'Đen', 46000000, 3, 2018, 125, 'Nhật Bản', 'Chiếc', '3.jpg', 2, '2018-10-14 17:00:00', NULL),
(4, 'Furure', 'Xanh', 47000000, 4, 2018, 125, 'Nhật Bản', 'Chiếc', '4.jpg', 2, '2018-10-14 17:00:00', NULL),
(5, 'Vision', 'Xanh nâu', 45000000, 5, 2018, 125, 'Nhật Bản', 'Chiếc', '5.jpg', 2, '2018-10-14 17:00:00', NULL),
(6, 'Wave Alpha', 'Cam', 18000000, 11, 2017, 110, 'Nhật Bản', 'Chiếc', '1539976489Wave Alpha Cam.png', 2, '2018-10-19 19:14:49', '2018-10-19 19:24:55'),
(7, 'Wave Alpha', 'Đỏ', 18000000, 8, 2018, 110, 'Nhật Bản', 'Chiếc', '1539976571Wave Alpha Đỏ.png', 2, '2018-10-19 19:16:11', '2018-10-19 19:25:11'),
(8, 'Wave Alpha', 'Xanh', 18000000, 5, 2018, 110, 'Nhật Bản', 'Chiếc', '1539976636Wave Alpha Xanh.png', 2, '2018-10-19 19:17:16', '2018-10-19 19:25:29'),
(9, 'Wave Alpha', 'Trắng', 18000000, 5, 2018, 110, 'Nhật Bản', 'Chiếc', '1539976713Wave Alpha Trắng.png', 2, '2018-10-19 19:18:33', '2018-10-19 19:25:48'),
(10, 'Sh Mode', 'Đỏ', 51490000, 4, 2018, 125, 'Nhật Bản', 'Chiếc', '1539977422Sh Mode Đỏ.png', 3, '2018-10-19 19:30:22', '2018-10-19 19:35:20'),
(11, 'Sh Mode', 'Trắng', 51490000, 3, 2018, 125, 'Nhật Bản', 'Chiếc', '1539977495Sh Mode Trắng.png', 3, '2018-10-19 19:31:35', '2018-10-19 19:34:48'),
(12, 'Sh Mode', 'Xanh Ngọc', 51490000, 5, 2018, 125, 'Nhật Bản', 'Chiếc', '1539977582Sh Mode Xanh Ngọc.png', 2, '2018-10-19 19:33:02', '2018-10-19 19:35:35'),
(13, 'Sh Mode', 'Xanh Tím', 51490000, 2, 2018, 125, 'Nhật Bản', 'Chiếc', '1539977653Sh Mode Xanh Tím.png', 3, '2018-10-19 19:34:13', '2018-10-19 19:35:54'),
(14, 'Lead', 'Đen', 39290000, 3, 2018, 125, 'Nhật Bản', 'Chiếc', '1539977889Lead Đen.png', 2, '2018-10-19 19:38:09', '2018-10-19 19:41:11'),
(15, 'Lead', 'Đỏ', 39290000, 2, 2018, 125, 'Nhật Bản', 'Chiếc', '1539977956Lead Đỏ.png', 2, '2018-10-19 19:39:16', '2018-10-19 19:41:27'),
(16, 'Lead', 'Trắng', 39290000, 2, 2018, 125, 'Nhật Bản', 'Chiếc', '1539978035Lead Trắng.png', 2, '2018-10-19 19:40:36', '2018-10-19 19:41:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chi_tiet_hoa_don_ban_phu_kiens`
--
ALTER TABLE `chi_tiet_hoa_don_ban_phu_kiens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chi_tiet_hoa_don_ban_phu_kiens_id_banphutungphukien_foreign` (`id_banphutungphukien`),
  ADD KEY `chi_tiet_hoa_don_ban_phu_kiens_id_phukien_foreign` (`id_phukien`);

--
-- Indexes for table `chi_tiet_hoa_don_ban_phu_tungs`
--
ALTER TABLE `chi_tiet_hoa_don_ban_phu_tungs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chi_tiet_hoa_don_ban_phu_tungs_id_banphutungphukien_foreign` (`id_banphutungphukien`),
  ADD KEY `chi_tiet_hoa_don_ban_phu_tungs_id_phutung_foreign` (`id_phutung`);

--
-- Indexes for table `chi_tiet_nhap_phu_kiens`
--
ALTER TABLE `chi_tiet_nhap_phu_kiens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chi_tiet_nhap_phu_kiens_id_nhapphutungphukien_foreign` (`id_nhapphutungphukien`),
  ADD KEY `chi_tiet_nhap_phu_kiens_id_phukien_foreign` (`id_phukien`);

--
-- Indexes for table `chi_tiet_nhap_phu_tungs`
--
ALTER TABLE `chi_tiet_nhap_phu_tungs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chi_tiet_nhap_phu_tungs_id_nhapphutungphukien_foreign` (`id_nhapphutungphukien`),
  ADD KEY `chi_tiet_nhap_phu_tungs_id_phutung_foreign` (`id_phutung`);

--
-- Indexes for table `chi_tiet_nhap_xe_mays`
--
ALTER TABLE `chi_tiet_nhap_xe_mays`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chi_tiet_nhap_xe_mays_id_nhapxemay_foreign` (`id_nhapxemay`),
  ADD KEY `chi_tiet_nhap_xe_mays_id_xemay_foreign` (`id_xemay`);

--
-- Indexes for table `chuc_vus`
--
ALTER TABLE `chuc_vus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hoa_don_ban_phu_tung_phu_kiens`
--
ALTER TABLE `hoa_don_ban_phu_tung_phu_kiens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hoa_don_ban_phu_tung_phu_kiens_id_khachhang_foreign` (`id_khachhang`),
  ADD KEY `hoa_don_ban_phu_tung_phu_kiens_id_nhanvien_foreign` (`id_nhanvien`);

--
-- Indexes for table `hoa_don_ban_xe_mays`
--
ALTER TABLE `hoa_don_ban_xe_mays`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hoa_don_ban_xe_mays_id_khachhang_foreign` (`id_khachhang`),
  ADD KEY `hoa_don_ban_xe_mays_id_nhanvien_foreign` (`id_nhanvien`),
  ADD KEY `hoa_don_ban_xe_mays_id_xemay_foreign` (`id_xemay`);

--
-- Indexes for table `khach_hangs`
--
ALTER TABLE `khach_hangs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loai_bao_hanhs`
--
ALTER TABLE `loai_bao_hanhs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loai_phu_tungs`
--
ALTER TABLE `loai_phu_tungs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nhan_viens`
--
ALTER TABLE `nhan_viens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nhan_viens_id_chucvu_foreign` (`id_chucvu`);

--
-- Indexes for table `nhap_phu_tung_phu_kiens`
--
ALTER TABLE `nhap_phu_tung_phu_kiens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nhap_phu_tung_phu_kiens_id_nhanvien_foreign` (`id_nhanvien`),
  ADD KEY `nhap_phu_tung_phu_kiens_id_nhacungcap_foreign` (`id_nhacungcap`);

--
-- Indexes for table `nhap_xe_mays`
--
ALTER TABLE `nhap_xe_mays`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nhap_xe_mays_id_nhanvien_foreign` (`id_nhanvien`),
  ADD KEY `nhap_xe_mays_id_nhacungcap_foreign` (`id_nhacungcap`);

--
-- Indexes for table `nha_cung_caps`
--
ALTER TABLE `nha_cung_caps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `phu_kiens`
--
ALTER TABLE `phu_kiens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `phu_kiens_id_xemays_foreign` (`id_xemays`);

--
-- Indexes for table `phu_tungs`
--
ALTER TABLE `phu_tungs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `phu_tungs_id_loaiphutung_foreign` (`id_loaiphutung`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_id_nhanvien_foreign` (`id_nhanvien`);

--
-- Indexes for table `xe_mays`
--
ALTER TABLE `xe_mays`
  ADD PRIMARY KEY (`id`),
  ADD KEY `xe_mays_id_loaibaohanh_foreign` (`id_loaibaohanh`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chi_tiet_hoa_don_ban_phu_kiens`
--
ALTER TABLE `chi_tiet_hoa_don_ban_phu_kiens`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `chi_tiet_hoa_don_ban_phu_tungs`
--
ALTER TABLE `chi_tiet_hoa_don_ban_phu_tungs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `chi_tiet_nhap_phu_kiens`
--
ALTER TABLE `chi_tiet_nhap_phu_kiens`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `chi_tiet_nhap_phu_tungs`
--
ALTER TABLE `chi_tiet_nhap_phu_tungs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `chi_tiet_nhap_xe_mays`
--
ALTER TABLE `chi_tiet_nhap_xe_mays`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `chuc_vus`
--
ALTER TABLE `chuc_vus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `hoa_don_ban_phu_tung_phu_kiens`
--
ALTER TABLE `hoa_don_ban_phu_tung_phu_kiens`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `hoa_don_ban_xe_mays`
--
ALTER TABLE `hoa_don_ban_xe_mays`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `khach_hangs`
--
ALTER TABLE `khach_hangs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `loai_bao_hanhs`
--
ALTER TABLE `loai_bao_hanhs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `loai_phu_tungs`
--
ALTER TABLE `loai_phu_tungs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `nhan_viens`
--
ALTER TABLE `nhan_viens`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `nhap_phu_tung_phu_kiens`
--
ALTER TABLE `nhap_phu_tung_phu_kiens`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `nhap_xe_mays`
--
ALTER TABLE `nhap_xe_mays`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `nha_cung_caps`
--
ALTER TABLE `nha_cung_caps`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `phu_kiens`
--
ALTER TABLE `phu_kiens`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `phu_tungs`
--
ALTER TABLE `phu_tungs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `xe_mays`
--
ALTER TABLE `xe_mays`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chi_tiet_hoa_don_ban_phu_kiens`
--
ALTER TABLE `chi_tiet_hoa_don_ban_phu_kiens`
  ADD CONSTRAINT `chi_tiet_hoa_don_ban_phu_kiens_id_banphutungphukien_foreign` FOREIGN KEY (`id_banphutungphukien`) REFERENCES `hoa_don_ban_phu_tung_phu_kiens` (`id`),
  ADD CONSTRAINT `chi_tiet_hoa_don_ban_phu_kiens_id_phukien_foreign` FOREIGN KEY (`id_phukien`) REFERENCES `phu_kiens` (`id`);

--
-- Constraints for table `chi_tiet_hoa_don_ban_phu_tungs`
--
ALTER TABLE `chi_tiet_hoa_don_ban_phu_tungs`
  ADD CONSTRAINT `chi_tiet_hoa_don_ban_phu_tungs_id_banphutungphukien_foreign` FOREIGN KEY (`id_banphutungphukien`) REFERENCES `hoa_don_ban_phu_tung_phu_kiens` (`id`),
  ADD CONSTRAINT `chi_tiet_hoa_don_ban_phu_tungs_id_phutung_foreign` FOREIGN KEY (`id_phutung`) REFERENCES `phu_tungs` (`id`);

--
-- Constraints for table `chi_tiet_nhap_phu_kiens`
--
ALTER TABLE `chi_tiet_nhap_phu_kiens`
  ADD CONSTRAINT `chi_tiet_nhap_phu_kiens_id_nhapphutungphukien_foreign` FOREIGN KEY (`id_nhapphutungphukien`) REFERENCES `nhap_phu_tung_phu_kiens` (`id`),
  ADD CONSTRAINT `chi_tiet_nhap_phu_kiens_id_phukien_foreign` FOREIGN KEY (`id_phukien`) REFERENCES `phu_kiens` (`id`);

--
-- Constraints for table `chi_tiet_nhap_phu_tungs`
--
ALTER TABLE `chi_tiet_nhap_phu_tungs`
  ADD CONSTRAINT `chi_tiet_nhap_phu_tungs_id_nhapphutungphukien_foreign` FOREIGN KEY (`id_nhapphutungphukien`) REFERENCES `nhap_phu_tung_phu_kiens` (`id`),
  ADD CONSTRAINT `chi_tiet_nhap_phu_tungs_id_phutung_foreign` FOREIGN KEY (`id_phutung`) REFERENCES `phu_tungs` (`id`);

--
-- Constraints for table `chi_tiet_nhap_xe_mays`
--
ALTER TABLE `chi_tiet_nhap_xe_mays`
  ADD CONSTRAINT `chi_tiet_nhap_xe_mays_id_nhapxemay_foreign` FOREIGN KEY (`id_nhapxemay`) REFERENCES `nhap_xe_mays` (`id`),
  ADD CONSTRAINT `chi_tiet_nhap_xe_mays_id_xemay_foreign` FOREIGN KEY (`id_xemay`) REFERENCES `xe_mays` (`id`);

--
-- Constraints for table `hoa_don_ban_phu_tung_phu_kiens`
--
ALTER TABLE `hoa_don_ban_phu_tung_phu_kiens`
  ADD CONSTRAINT `hoa_don_ban_phu_tung_phu_kiens_id_khachhang_foreign` FOREIGN KEY (`id_khachhang`) REFERENCES `khach_hangs` (`id`),
  ADD CONSTRAINT `hoa_don_ban_phu_tung_phu_kiens_id_nhanvien_foreign` FOREIGN KEY (`id_nhanvien`) REFERENCES `nhan_viens` (`id`);

--
-- Constraints for table `hoa_don_ban_xe_mays`
--
ALTER TABLE `hoa_don_ban_xe_mays`
  ADD CONSTRAINT `hoa_don_ban_xe_mays_id_khachhang_foreign` FOREIGN KEY (`id_khachhang`) REFERENCES `khach_hangs` (`id`),
  ADD CONSTRAINT `hoa_don_ban_xe_mays_id_nhanvien_foreign` FOREIGN KEY (`id_nhanvien`) REFERENCES `nhan_viens` (`id`),
  ADD CONSTRAINT `hoa_don_ban_xe_mays_id_xemay_foreign` FOREIGN KEY (`id_xemay`) REFERENCES `xe_mays` (`id`);

--
-- Constraints for table `nhan_viens`
--
ALTER TABLE `nhan_viens`
  ADD CONSTRAINT `nhan_viens_id_chucvu_foreign` FOREIGN KEY (`id_chucvu`) REFERENCES `chuc_vus` (`id`);

--
-- Constraints for table `nhap_phu_tung_phu_kiens`
--
ALTER TABLE `nhap_phu_tung_phu_kiens`
  ADD CONSTRAINT `nhap_phu_tung_phu_kiens_id_nhacungcap_foreign` FOREIGN KEY (`id_nhacungcap`) REFERENCES `nha_cung_caps` (`id`),
  ADD CONSTRAINT `nhap_phu_tung_phu_kiens_id_nhanvien_foreign` FOREIGN KEY (`id_nhanvien`) REFERENCES `nhan_viens` (`id`);

--
-- Constraints for table `nhap_xe_mays`
--
ALTER TABLE `nhap_xe_mays`
  ADD CONSTRAINT `nhap_xe_mays_id_nhacungcap_foreign` FOREIGN KEY (`id_nhacungcap`) REFERENCES `nha_cung_caps` (`id`),
  ADD CONSTRAINT `nhap_xe_mays_id_nhanvien_foreign` FOREIGN KEY (`id_nhanvien`) REFERENCES `nhan_viens` (`id`);

--
-- Constraints for table `phu_kiens`
--
ALTER TABLE `phu_kiens`
  ADD CONSTRAINT `phu_kiens_id_xemays_foreign` FOREIGN KEY (`id_xemays`) REFERENCES `xe_mays` (`id`);

--
-- Constraints for table `phu_tungs`
--
ALTER TABLE `phu_tungs`
  ADD CONSTRAINT `phu_tungs_id_loaiphutung_foreign` FOREIGN KEY (`id_loaiphutung`) REFERENCES `loai_phu_tungs` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_id_nhanvien_foreign` FOREIGN KEY (`id_nhanvien`) REFERENCES `nhan_viens` (`id`);

--
-- Constraints for table `xe_mays`
--
ALTER TABLE `xe_mays`
  ADD CONSTRAINT `xe_mays_id_loaibaohanh_foreign` FOREIGN KEY (`id_loaibaohanh`) REFERENCES `loai_bao_hanhs` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
