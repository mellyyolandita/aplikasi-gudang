-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 22, 2024 at 07:06 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gudang`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_barang`
--

CREATE TABLE `tbl_barang` (
  `id_barang` varchar(5) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `harga` int(11) DEFAULT NULL,
  `harga_jual` int(11) DEFAULT NULL,
  `stok_minimum` int(11) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `satuan` int(11) NOT NULL,
  `foto` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_barang`
--

INSERT INTO `tbl_barang` (`id_barang`, `nama_barang`, `harga`, `harga_jual`, `stok_minimum`, `stok`, `satuan`, `foto`) VALUES
('B0003', 'Parang', 10000, 150000, 20, 20, 4, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_barang_keluar`
--

CREATE TABLE `tbl_barang_keluar` (
  `id_transaksi` varchar(10) NOT NULL,
  `tanggal` date NOT NULL,
  `barang` varchar(5) NOT NULL,
  `penerima` varchar(50) NOT NULL,
  `harga` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `total_harga` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_barang_keluar`
--

INSERT INTO `tbl_barang_keluar` (`id_transaksi`, `tanggal`, `barang`, `penerima`, `harga`, `jumlah`, `total_harga`) VALUES
('TK-0000001', '2024-01-22', 'B0003', 'Siti Fatimah', 150000, 10, 1500000);

--
-- Triggers `tbl_barang_keluar`
--
DELIMITER $$
CREATE TRIGGER `hapus_stok_keluar` BEFORE DELETE ON `tbl_barang_keluar` FOR EACH ROW BEGIN
UPDATE tbl_barang SET stok=stok+OLD.jumlah
WHERE id_barang=OLD.barang;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `stok_keluar` AFTER INSERT ON `tbl_barang_keluar` FOR EACH ROW BEGIN
UPDATE tbl_barang SET stok=stok-NEW.jumlah
WHERE id_barang=NEW.barang;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_barang_masuk`
--

CREATE TABLE `tbl_barang_masuk` (
  `id_transaksi` varchar(10) NOT NULL,
  `tanggal` date NOT NULL,
  `barang` varchar(5) NOT NULL,
  `supplier` varchar(50) NOT NULL,
  `harga` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `total_harga` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_barang_masuk`
--

INSERT INTO `tbl_barang_masuk` (`id_transaksi`, `tanggal`, `barang`, `supplier`, `harga`, `jumlah`, `total_harga`) VALUES
('TM-0000001', '2024-01-22', 'B0003', 'CV. Datok Keras', 10000, 20, 200000),
('TM-0002', '2024-01-22', 'B0003', 'Malaysia', 10000, 10, 100000);

--
-- Triggers `tbl_barang_masuk`
--
DELIMITER $$
CREATE TRIGGER `hapus_stok_masuk` BEFORE DELETE ON `tbl_barang_masuk` FOR EACH ROW BEGIN
UPDATE tbl_barang SET stok=stok-OLD.jumlah
WHERE id_barang=OLD.barang;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `stok_masuk` AFTER INSERT ON `tbl_barang_masuk` FOR EACH ROW BEGIN
UPDATE tbl_barang SET stok=stok+NEW.jumlah
WHERE id_barang=NEW.barang;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_keadaan_barang`
--

CREATE TABLE `tbl_keadaan_barang` (
  `id_keadaan` varchar(11) CHARACTER SET latin1 NOT NULL,
  `barang` varchar(5) CHARACTER SET latin1 NOT NULL,
  `tanggal_cek` date NOT NULL,
  `stok` int(11) NOT NULL,
  `kondisi_barang` varchar(100) CHARACTER SET latin1 NOT NULL,
  `keterangan` varchar(255) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_keadaan_barang`
--

INSERT INTO `tbl_keadaan_barang` (`id_keadaan`, `barang`, `tanggal_cek`, `stok`, `kondisi_barang`, `keterangan`) VALUES
('KB0001', 'B0003', '2024-01-22', 10, 'Berkarat', 'Kena air dari atap yang bocor');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pengiriman`
--

CREATE TABLE `tbl_pengiriman` (
  `id_pengiriman` varchar(11) CHARACTER SET latin1 NOT NULL,
  `tanggal` date NOT NULL,
  `tipe_proses` varchar(30) CHARACTER SET latin1 NOT NULL,
  `gudang_pengirim` varchar(30) CHARACTER SET latin1 NOT NULL,
  `gudang` varchar(30) CHARACTER SET latin1 NOT NULL,
  `keterangan` varchar(100) CHARACTER SET latin1 NOT NULL,
  `status` varchar(30) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_pengiriman`
--

INSERT INTO `tbl_pengiriman` (`id_pengiriman`, `tanggal`, `tipe_proses`, `gudang_pengirim`, `gudang`, `keterangan`, `status`) VALUES
('P0001', '2024-01-03', 'Terima Barang', 'Gudang 59 Basirih', 'Gudang 59 Belakang', 'Menghabiskan Sisa Sisa Barang', 'Belum Diterima'),
('P0002', '2024-01-16', 'Terima Barang', 'Gudang 59 Basirih', 'Gudang 59 Belakang', 'Kelebihan Barang', 'Belum Diterima');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_penyesuaian`
--

CREATE TABLE `tbl_penyesuaian` (
  `id_penyesuaian` varchar(10) CHARACTER SET latin1 NOT NULL,
  `tanggal` date NOT NULL,
  `barang` varchar(5) CHARACTER SET latin1 NOT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `keterangan` varchar(100) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_satuan`
--

CREATE TABLE `tbl_satuan` (
  `id_satuan` int(11) NOT NULL,
  `nama_satuan` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_satuan`
--

INSERT INTO `tbl_satuan` (`id_satuan`, `nama_satuan`) VALUES
(1, 'Cm'),
(2, 'Kg'),
(3, 'Meter'),
(4, 'Buah'),
(5, 'Pcs');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id_user` int(11) NOT NULL,
  `nama_user` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `hak_akses` enum('Administrator','Admin Gudang','Kepala Gudang') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id_user`, `nama_user`, `username`, `password`, `hak_akses`) VALUES
(1, 'Admin', 'administrator', '$2y$12$Yi/I5f1jPoQNQnh6lWoVfuz.RtZ3OHcKN6PU.I62P0fYK1tJ7xMRi', 'Administrator'),
(2, 'Admin Gudang', 'admin gudang', '$2y$12$BeRYh13zfPXej97VgcfeNucYJGTElha5sRyIUQm1278D2u2Aqf6DS', 'Admin Gudang'),
(3, 'Kepala Gudang', 'kepala gudang', '$2y$12$odXcPs.RLJJH6Ghv3s42c.5zg5qAOz/S3Adr0lXGNcVSJ6f1hHS6G', 'Kepala Gudang');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_barang`
--
ALTER TABLE `tbl_barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD KEY `satuan` (`satuan`);

--
-- Indexes for table `tbl_barang_keluar`
--
ALTER TABLE `tbl_barang_keluar`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `barang` (`barang`);

--
-- Indexes for table `tbl_barang_masuk`
--
ALTER TABLE `tbl_barang_masuk`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `barang` (`barang`);

--
-- Indexes for table `tbl_keadaan_barang`
--
ALTER TABLE `tbl_keadaan_barang`
  ADD PRIMARY KEY (`id_keadaan`),
  ADD KEY `barang` (`barang`);

--
-- Indexes for table `tbl_pengiriman`
--
ALTER TABLE `tbl_pengiriman`
  ADD PRIMARY KEY (`id_pengiriman`);

--
-- Indexes for table `tbl_penyesuaian`
--
ALTER TABLE `tbl_penyesuaian`
  ADD PRIMARY KEY (`id_penyesuaian`),
  ADD KEY `barang` (`barang`);

--
-- Indexes for table `tbl_satuan`
--
ALTER TABLE `tbl_satuan`
  ADD PRIMARY KEY (`id_satuan`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_satuan`
--
ALTER TABLE `tbl_satuan`
  MODIFY `id_satuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_barang`
--
ALTER TABLE `tbl_barang`
  ADD CONSTRAINT `tbl_barang_ibfk_1` FOREIGN KEY (`satuan`) REFERENCES `tbl_satuan` (`id_satuan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_barang_keluar`
--
ALTER TABLE `tbl_barang_keluar`
  ADD CONSTRAINT `tbl_barang_keluar_ibfk_1` FOREIGN KEY (`barang`) REFERENCES `tbl_barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_barang_masuk`
--
ALTER TABLE `tbl_barang_masuk`
  ADD CONSTRAINT `tbl_barang_masuk_ibfk_1` FOREIGN KEY (`barang`) REFERENCES `tbl_barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_keadaan_barang`
--
ALTER TABLE `tbl_keadaan_barang`
  ADD CONSTRAINT `tbl_keadaan_barang_ibfk_1` FOREIGN KEY (`barang`) REFERENCES `tbl_barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_penyesuaian`
--
ALTER TABLE `tbl_penyesuaian`
  ADD CONSTRAINT `tbl_penyesuaian_ibfk_1` FOREIGN KEY (`barang`) REFERENCES `tbl_barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
