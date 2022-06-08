-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2022 at 07:26 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kasirhjevi`
--

-- --------------------------------------------------------

--
-- Table structure for table `cek`
--

CREATE TABLE `cek` (
  `id` int(11) NOT NULL,
  `nilai` int(11) DEFAULT NULL,
  `ket` varchar(121) DEFAULT NULL,
  `brg` varchar(121) DEFAULT NULL,
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_barang`
--

CREATE TABLE `tbl_barang` (
  `id` int(19) NOT NULL,
  `barang_id` varchar(15) NOT NULL,
  `barcode` varchar(16) DEFAULT NULL,
  `barang_nama` varchar(150) DEFAULT NULL,
  `barang_harpok_grosir` double DEFAULT NULL,
  `barang_harjul_grosir` double DEFAULT NULL,
  `barang_harpok_eceran` double DEFAULT NULL,
  `barang_harjul_eceran` double DEFAULT NULL,
  `barang_harjul_grosir_m` double DEFAULT NULL,
  `barang_harjul_eceran_m` double DEFAULT NULL,
  `barang_stok` float DEFAULT 0,
  `barang_min_stok` float DEFAULT 0,
  `barang_tgl_input` timestamp NULL DEFAULT current_timestamp(),
  `barang_tgl_last_update` datetime DEFAULT NULL,
  `barang_kategori_id` int(11) DEFAULT NULL,
  `barang_user_id` int(11) DEFAULT NULL,
  `barang_satuan_id` int(11) DEFAULT NULL,
  `barang_suplier_id` int(11) DEFAULT NULL,
  `active` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_barang`
--

INSERT INTO `tbl_barang` (`id`, `barang_id`, `barcode`, `barang_nama`, `barang_harpok_grosir`, `barang_harjul_grosir`, `barang_harpok_eceran`, `barang_harjul_eceran`, `barang_harjul_grosir_m`, `barang_harjul_eceran_m`, `barang_stok`, `barang_min_stok`, `barang_tgl_input`, `barang_tgl_last_update`, `barang_kategori_id`, `barang_user_id`, `barang_satuan_id`, `barang_suplier_id`, `active`) VALUES
(25, 'BR000001', 'BR000001', 'Keripik Singkong Balado', 180000, 205000, 18000, 20500, 200000, 20000, 140.9, 10, '2022-05-21 05:29:21', '2022-06-09 00:23:03', 12, 1, 18, 11, '1'),
(26, 'BR000002', 'BR000002', 'Basreng Manis Keju', 150000, 175000, 15000, 17500, 160000, 16000, 84.7, 10, '2022-05-21 10:25:07', '2022-06-09 00:23:03', 12, 1, 18, 11, '1'),
(27, 'BR000003', 'BR000003', 'Kacang Oven', 120000, 150000, 12000, 15000, 145000, 14500, 75.3, 10, '2022-05-21 10:26:33', '2022-06-09 00:23:03', 12, 1, 18, 11, '1'),
(28, 'BR000004', 'BR000004', 'Kerippik Cimol Bojot', 80000, 105000, 90000, 110000, 100000, 100000, 134.8, 10, '2022-06-07 14:24:27', '2022-06-09 00:23:03', 12, 1, 18, 11, '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_beli`
--

CREATE TABLE `tbl_beli` (
  `beli_nofak` varchar(15) DEFAULT NULL,
  `beli_tanggal` date DEFAULT NULL,
  `beli_suplier_id` int(11) DEFAULT NULL,
  `beli_user_id` int(11) DEFAULT NULL,
  `beli_kode` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_beli`
--

INSERT INTO `tbl_beli` (`beli_nofak`, `beli_tanggal`, `beli_suplier_id`, `beli_user_id`, `beli_kode`) VALUES
('ABC321', '2022-06-09', 11, 1, 'BL090622000001'),
('BCV1234', '2022-06-09', 11, 1, 'BL090622000002');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_detail_beli`
--

CREATE TABLE `tbl_detail_beli` (
  `d_beli_id` int(11) NOT NULL,
  `d_beli_nofak` varchar(15) DEFAULT NULL,
  `d_beli_barang_id` varchar(15) DEFAULT NULL,
  `d_beli_harga` double DEFAULT NULL,
  `d_beli_jumlah` int(11) DEFAULT NULL,
  `d_beli_total` double DEFAULT NULL,
  `d_beli_kode` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_detail_beli`
--

INSERT INTO `tbl_detail_beli` (`d_beli_id`, `d_beli_nofak`, `d_beli_barang_id`, `d_beli_harga`, `d_beli_jumlah`, `d_beli_total`, `d_beli_kode`) VALUES
(32, 'ABC321', 'BR000003', 120000, 3, 360000, 'BL090622000001'),
(33, 'ABC321', 'BR000004', 80000, 4, 320000, 'BL090622000001'),
(34, 'ABC321', 'BR000001', 180000, 1, 180000, 'BL090622000001'),
(35, 'ABC321', 'BR000002', 150000, 1, 150000, 'BL090622000001'),
(36, 'BCV1234', 'BR000001', 180000, 1, 180000, 'BL090622000002'),
(37, 'BCV1234', 'BR000002', 150000, 1, 150000, 'BL090622000002'),
(38, 'BCV1234', 'BR000003', 120000, 1, 120000, 'BL090622000002'),
(39, 'BCV1234', 'BR000004', 80000, 1, 80000, 'BL090622000002');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_detail_jual`
--

CREATE TABLE `tbl_detail_jual` (
  `d_jual_id` int(11) NOT NULL,
  `d_jual_nofak` varchar(15) DEFAULT NULL,
  `d_jual_barang_id` varchar(15) DEFAULT NULL,
  `d_jual_barang_nama` varchar(150) DEFAULT NULL,
  `d_jual_barang_satuan` varchar(30) DEFAULT NULL,
  `d_jual_barang_harpok` double DEFAULT NULL,
  `d_jual_barang_harjul` double DEFAULT NULL,
  `d_jual_qty` float DEFAULT NULL,
  `d_jual_diskon` double DEFAULT NULL,
  `d_jual_total` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_detail_jual`
--

INSERT INTO `tbl_detail_jual` (`d_jual_id`, `d_jual_nofak`, `d_jual_barang_id`, `d_jual_barang_nama`, `d_jual_barang_satuan`, `d_jual_barang_harpok`, `d_jual_barang_harjul`, `d_jual_qty`, `d_jual_diskon`, `d_jual_total`) VALUES
(238, '020622000001', 'BR000001', 'Keripik Singkong Balado', 'Kg', 18000, 20500, 1, 0, 20500),
(239, '020622000001', 'BR000003', 'Kacang Oven', 'Ball', 120000, 150000, 2, 0, 300000),
(240, '020622000001', 'BR000002', 'Basreng Manis Keju', 'Ball', 150000, 175000, 1, 0, 175000),
(241, '020622000001', 'BR000001', 'Keripik Singkong Balado', 'Ball', 180000, 205000, 2, 0, 410000),
(242, '020622000002', 'BR000002', 'Basreng Manis Keju', 'Kg', 15000, 17500, 2, 1000, 33000),
(243, '020622000002', 'BR000002', 'Basreng Manis Keju', 'Ball', 150000, 175000, 1, 0, 175000),
(244, '020622000002', 'BR000003', 'Kacang Oven', 'Kg', 12000, 15000, 2, 0, 30000),
(245, '030622000001', 'BR000002', 'Basreng Manis Keju', 'Kg', 15000, 17500, 1, 0, 17500),
(246, '070622000001', 'BR000003', 'Kacang Oven', 'Kg', 12000, 15000, 1, 0, 15000),
(247, '070622000001', 'BR000002', 'Basreng Manis Keju', 'Ball', 150000, 175000, 2, 0, 350000),
(248, '070622000001', 'BR000003', 'Kacang Oven', 'Ball', 120000, 150000, 4, 0, 600000),
(249, '070622000002', 'BR000002', 'Basreng Manis Keju', 'Kg', 15000, 17500, 1, 0, 17500),
(250, '070622000002', 'BR000001', 'Keripik Singkong Balado', 'Ball', 180000, 205000, 1, 0, 205000),
(251, '070622000003', 'BR000002', 'Basreng Manis Keju', 'Ball', 150000, 175000, 2, 0, 350000),
(252, '080622000001', 'BR000001', 'Keripik Singkong Balado', 'Ball', 180000, 205000, 2, 1000, 408000),
(253, '080622000001', 'BR000002', 'Basreng Manis Keju', 'Kg', 15000, 17500, 3, 0, 52500),
(254, '080622000001', 'BR000003', 'Kacang Oven', 'Ball', 120000, 150000, 1, 0, 150000),
(255, '080622000001', 'BR000004', 'Kerippik Cimol Bojot', 'Kg', 90000, 110000, 2, 0, 220000),
(256, '080622000002', 'BR000001', 'Keripik Singkong Balado', 'Ball', 180000, 205000, 1, 0, 205000),
(257, '080622000002', 'BR000002', 'Basreng Manis Keju', 'Kg', 15000, 17500, 2, 0, 35000),
(258, '080622000003', 'BR000002', 'Basreng Manis Keju', 'Ball', 150000, 160000, 1, 0, 160000),
(259, '080622000003', 'BR000002', 'Basreng Manis Keju', 'Kg', 15000, 16000, 4, 0, 64000),
(260, '080622000003', 'BR000004', 'Kerippik Cimol Bojot', 'Ball', 80000, 100000, 2, 1000, 198000),
(261, '080622000004', 'BR000002', 'Basreng Manis Keju', 'Ball', 150000, 160000, 1, 0, 160000),
(262, '080622000005', 'BR000003', 'Kacang Oven', 'Ball', 120000, 145000, 1, 0, 145000),
(263, '080622000006', 'BR000002', 'Basreng Manis Keju', 'Ball', 150000, 160000, 1, 0, 160000),
(264, '080622000007', 'BR000002', 'Basreng Manis Keju', 'Ball', 150000, 160000, 9, 0, 1440000),
(265, '080622000008', 'BR000003', 'Kacang Oven', 'Ball', 120000, 150000, 1, 0, 150000),
(266, '080622000009', 'BR000002', 'Basreng Manis Keju', 'Ball', 150000, 175000, 1, 0, 175000),
(267, '080622000009', 'BR000003', 'Kacang Oven', 'Kg', 12000, 15000, 4, 0, 60000);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jual`
--

CREATE TABLE `tbl_jual` (
  `jual_nofak` varchar(15) NOT NULL,
  `jual_tanggal` timestamp NULL DEFAULT current_timestamp(),
  `jual_total` double DEFAULT NULL,
  `jual_jml_uang` double DEFAULT NULL,
  `jual_kembalian` double DEFAULT NULL,
  `jual_user_id` int(11) DEFAULT NULL,
  `jual_keterangan` varchar(20) DEFAULT NULL,
  `jual_member_id` int(11) DEFAULT NULL,
  `jual_deskripsi` text DEFAULT NULL,
  `jual_status` varchar(1) DEFAULT NULL,
  `jual_utang` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_jual`
--

INSERT INTO `tbl_jual` (`jual_nofak`, `jual_tanggal`, `jual_total`, `jual_jml_uang`, `jual_kembalian`, `jual_user_id`, `jual_keterangan`, `jual_member_id`, `jual_deskripsi`, `jual_status`, `jual_utang`) VALUES
('020622000001', '2022-06-01 23:05:58', 905500, 910000, 4500, 1, 'nonmember', NULL, ' ', '0', NULL),
('020622000002', '2022-06-02 00:53:25', 238000, 250000, 12000, 1, 'member', 14, '', '0', NULL),
('030622000001', '2022-06-03 02:02:00', 17500, 17500, 0, 1, 'member', 14, 'hutangs', '0', NULL),
('070622000001', '2022-06-07 03:35:53', 965000, 1000000, 35000, 1, 'nonmember', NULL, NULL, '0', NULL),
('070622000002', '2022-06-07 14:27:08', 222500, 222500, 0, 1, 'member', 14, 'Hutang', '0', NULL),
('070622000003', '2022-06-07 14:28:45', 350000, 400000, 50000, 1, 'nonmember', NULL, NULL, '0', NULL),
('080622000001', '2022-06-08 01:19:42', 830500, 830500, 0, 1, 'nonmember', NULL, '', '0', NULL),
('080622000002', '2022-06-08 01:28:37', 240000, 250000, 10000, 1, 'nonmember', NULL, '', '0', NULL),
('080622000003', '2022-06-08 01:33:20', 422000, 422000, 0, 1, 'member', 14, 'Hutang', '0', 'Admin  | 2022-Jun-Wed 18:13'),
('080622000004', '2022-06-08 01:37:31', 160000, 170000, 10000, 1, 'member', 14, '', '0', NULL),
('080622000005', '2022-06-08 01:39:36', 145000, 150000, 5000, 1, 'member', NULL, '', '0', NULL),
('080622000006', '2022-06-08 01:49:57', 160000, 160000, 0, 1, 'member', NULL, 'www', '1', NULL),
('080622000007', '2022-06-08 01:52:00', 1440000, 1440000, 0, 1, 'member', 14, 'popo', '0', 'Admin  | 22-06-08 23:23'),
('080622000008', '2022-06-08 01:58:32', 150000, 160000, 10000, 1, 'nonmember', NULL, '', NULL, NULL),
('080622000009', '2022-06-08 09:26:02', 235000, 250000, 15000, 1, 'nonmember', NULL, '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kategori`
--

CREATE TABLE `tbl_kategori` (
  `kategori_id` int(11) NOT NULL,
  `kategori_nama` varchar(35) DEFAULT NULL,
  `active` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_kategori`
--

INSERT INTO `tbl_kategori` (`kategori_id`, `kategori_nama`, `active`) VALUES
(12, 'Makanan', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_member`
--

CREATE TABLE `tbl_member` (
  `id` int(11) NOT NULL,
  `kode` varchar(255) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `notelp` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `point` int(11) DEFAULT NULL,
  `active` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_member`
--

INSERT INTO `tbl_member` (`id`, `kode`, `nama`, `notelp`, `alamat`, `nik`, `point`, `active`) VALUES
(14, 'PLG220001', 'Rizky', '0897654321', 'Jl Seskol', '123456789098765', 226, '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_retur`
--

CREATE TABLE `tbl_retur` (
  `retur_id` int(11) NOT NULL,
  `retur_tanggal` timestamp NULL DEFAULT current_timestamp(),
  `retur_barang_id` varchar(15) DEFAULT NULL,
  `retur_barang_nama` varchar(150) DEFAULT NULL,
  `retur_barang_satuan` varchar(30) DEFAULT NULL,
  `retur_harjul` double DEFAULT NULL,
  `retur_qty` int(11) DEFAULT NULL,
  `retur_subtotal` double DEFAULT NULL,
  `retur_keterangan` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_satuan`
--

CREATE TABLE `tbl_satuan` (
  `satuan_id` int(11) NOT NULL,
  `satuan_nama` varchar(35) DEFAULT NULL,
  `satuan_turunan` varchar(35) DEFAULT NULL,
  `active` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_satuan`
--

INSERT INTO `tbl_satuan` (`satuan_id`, `satuan_nama`, `satuan_turunan`, `active`) VALUES
(18, 'Ball', 'Kg', '1'),
(19, 'Kardus', 'Pcs', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_suplier`
--

CREATE TABLE `tbl_suplier` (
  `suplier_id` int(11) NOT NULL,
  `suplier_nama` varchar(35) DEFAULT NULL,
  `suplier_alamat` varchar(60) DEFAULT NULL,
  `suplier_notelp` varchar(20) DEFAULT NULL,
  `active` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_suplier`
--

INSERT INTO `tbl_suplier` (`suplier_id`, `suplier_nama`, `suplier_alamat`, `suplier_notelp`, `active`) VALUES
(11, 'CV Mulya Abadi', 'Jl Kosong', '08765432123', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_toko`
--

CREATE TABLE `tbl_toko` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `minPoint` int(11) NOT NULL,
  `point` int(11) NOT NULL,
  `jumUang` int(255) NOT NULL,
  `uang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_toko`
--

INSERT INTO `tbl_toko` (`id`, `nama`, `alamat`, `minPoint`, `point`, `jumUang`, `uang`) VALUES
(1, 'Toko kelontong Hj Evi ', 'Jl Barat Daya Cirebon No 123 RT02/32', 210, 2, 26000, 2000);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tukar_point`
--

CREATE TABLE `tbl_tukar_point` (
  `id` int(11) NOT NULL,
  `tanggal` datetime DEFAULT current_timestamp(),
  `id_pelanggan` varchar(255) DEFAULT NULL,
  `tukar_point` int(11) DEFAULT NULL,
  `jumlah_uangkeluar` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `user_id` int(11) NOT NULL,
  `user_nama` varchar(35) DEFAULT NULL,
  `user_username` varchar(30) DEFAULT NULL,
  `user_password` varchar(255) DEFAULT NULL,
  `user_level` varchar(2) DEFAULT NULL,
  `user_status` varchar(2) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `user_nama`, `user_username`, `user_password`, `user_level`, `user_status`) VALUES
(1, 'Admin ', 'admin', '$2y$10$/I7laWi1mlNFxYSv54EUPOH8MuZhmRWxhE.LaddTK9TSmVe.IHP2C', '1', '1'),
(2, 'Kasir Umum', 'kasir', '$2y$10$/I7laWi1mlNFxYSv54EUPOH8MuZhmRWxhE.LaddTK9TSmVe.IHP2C', '2', '1'),
(4, 'Aditya Ahmad', 'aditage', '$2y$10$1QU/f1xVeGBev93Xd0rgZOtjLZ5M3SIXH4u5fFHBIG9lFC4TdrE8O', '1', '0'),
(5, 'Aksyal', 'abe123', '$2y$10$vJfl2U2GdcdCQRmER73WE.zuZiyTkydQWPZEAfyUcONzscKsfvyOq', '1', '1'),
(6, 'Kasir2', 'kasir2', '$2y$10$dnHXMvz6dTDIKd65aCLK/u8IC6NRlW1dBMGetvsEe8EMj5lDU/bEa', '2', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cek`
--
ALTER TABLE `cek`
  ADD KEY `id` (`id`);

--
-- Indexes for table `tbl_barang`
--
ALTER TABLE `tbl_barang`
  ADD PRIMARY KEY (`barang_id`),
  ADD KEY `barang_user_id` (`barang_user_id`),
  ADD KEY `barang_kategori_id` (`barang_kategori_id`),
  ADD KEY `barang_satuan_id` (`barang_satuan_id`),
  ADD KEY `barang_suplier_id` (`barang_suplier_id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `tbl_beli`
--
ALTER TABLE `tbl_beli`
  ADD PRIMARY KEY (`beli_kode`),
  ADD KEY `beli_user_id` (`beli_user_id`),
  ADD KEY `beli_suplier_id` (`beli_suplier_id`),
  ADD KEY `beli_id` (`beli_kode`);

--
-- Indexes for table `tbl_detail_beli`
--
ALTER TABLE `tbl_detail_beli`
  ADD PRIMARY KEY (`d_beli_id`),
  ADD KEY `d_beli_barang_id` (`d_beli_barang_id`),
  ADD KEY `d_beli_nofak` (`d_beli_nofak`),
  ADD KEY `d_beli_kode` (`d_beli_kode`);

--
-- Indexes for table `tbl_detail_jual`
--
ALTER TABLE `tbl_detail_jual`
  ADD PRIMARY KEY (`d_jual_id`),
  ADD KEY `d_jual_barang_id` (`d_jual_barang_id`),
  ADD KEY `d_jual_nofak` (`d_jual_nofak`);

--
-- Indexes for table `tbl_jual`
--
ALTER TABLE `tbl_jual`
  ADD PRIMARY KEY (`jual_nofak`),
  ADD KEY `jual_user_id` (`jual_user_id`),
  ADD KEY `jual_member_id` (`jual_member_id`);

--
-- Indexes for table `tbl_kategori`
--
ALTER TABLE `tbl_kategori`
  ADD PRIMARY KEY (`kategori_id`);

--
-- Indexes for table `tbl_member`
--
ALTER TABLE `tbl_member`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `tbl_retur`
--
ALTER TABLE `tbl_retur`
  ADD PRIMARY KEY (`retur_id`);

--
-- Indexes for table `tbl_satuan`
--
ALTER TABLE `tbl_satuan`
  ADD PRIMARY KEY (`satuan_id`);

--
-- Indexes for table `tbl_suplier`
--
ALTER TABLE `tbl_suplier`
  ADD PRIMARY KEY (`suplier_id`);

--
-- Indexes for table `tbl_tukar_point`
--
ALTER TABLE `tbl_tukar_point`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pelanggan` (`id_pelanggan`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cek`
--
ALTER TABLE `cek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_barang`
--
ALTER TABLE `tbl_barang`
  MODIFY `id` int(19) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tbl_detail_beli`
--
ALTER TABLE `tbl_detail_beli`
  MODIFY `d_beli_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `tbl_detail_jual`
--
ALTER TABLE `tbl_detail_jual`
  MODIFY `d_jual_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=268;

--
-- AUTO_INCREMENT for table `tbl_kategori`
--
ALTER TABLE `tbl_kategori`
  MODIFY `kategori_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_member`
--
ALTER TABLE `tbl_member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_retur`
--
ALTER TABLE `tbl_retur`
  MODIFY `retur_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_satuan`
--
ALTER TABLE `tbl_satuan`
  MODIFY `satuan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_suplier`
--
ALTER TABLE `tbl_suplier`
  MODIFY `suplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_tukar_point`
--
ALTER TABLE `tbl_tukar_point`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_barang`
--
ALTER TABLE `tbl_barang`
  ADD CONSTRAINT `tbl_barang_ibfk_1` FOREIGN KEY (`barang_user_id`) REFERENCES `tbl_user` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_barang_ibfk_2` FOREIGN KEY (`barang_kategori_id`) REFERENCES `tbl_kategori` (`kategori_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_barang_ibfk_3` FOREIGN KEY (`barang_satuan_id`) REFERENCES `tbl_satuan` (`satuan_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_barang_ibfk_4` FOREIGN KEY (`barang_suplier_id`) REFERENCES `tbl_suplier` (`suplier_id`) ON UPDATE CASCADE;

--
-- Constraints for table `tbl_beli`
--
ALTER TABLE `tbl_beli`
  ADD CONSTRAINT `tbl_beli_ibfk_1` FOREIGN KEY (`beli_user_id`) REFERENCES `tbl_user` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_beli_ibfk_2` FOREIGN KEY (`beli_suplier_id`) REFERENCES `tbl_suplier` (`suplier_id`) ON UPDATE CASCADE;

--
-- Constraints for table `tbl_detail_beli`
--
ALTER TABLE `tbl_detail_beli`
  ADD CONSTRAINT `tbl_detail_beli_ibfk_1` FOREIGN KEY (`d_beli_barang_id`) REFERENCES `tbl_barang` (`barang_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_detail_beli_ibfk_2` FOREIGN KEY (`d_beli_kode`) REFERENCES `tbl_beli` (`beli_kode`) ON UPDATE CASCADE;

--
-- Constraints for table `tbl_detail_jual`
--
ALTER TABLE `tbl_detail_jual`
  ADD CONSTRAINT `tbl_detail_jual_ibfk_1` FOREIGN KEY (`d_jual_barang_id`) REFERENCES `tbl_barang` (`barang_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_detail_jual_ibfk_2` FOREIGN KEY (`d_jual_nofak`) REFERENCES `tbl_jual` (`jual_nofak`) ON UPDATE CASCADE;

--
-- Constraints for table `tbl_jual`
--
ALTER TABLE `tbl_jual`
  ADD CONSTRAINT `tbl_jual_ibfk_1` FOREIGN KEY (`jual_user_id`) REFERENCES `tbl_user` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_jual_ibfk_2` FOREIGN KEY (`jual_member_id`) REFERENCES `tbl_member` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `tbl_tukar_point`
--
ALTER TABLE `tbl_tukar_point`
  ADD CONSTRAINT `tbl_tukar_point_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `tbl_member` (`kode`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
