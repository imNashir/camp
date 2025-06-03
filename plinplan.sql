-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 03, 2025 at 04:44 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `plinplan`
--

-- --------------------------------------------------------

--
-- Table structure for table `alat`
--

CREATE TABLE `alat` (
  `id_alat` int NOT NULL,
  `nama_alat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `harga` int NOT NULL DEFAULT '0',
  `id_kategori` int NOT NULL,
  `gambar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ukuran` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `warna` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jumlah` int NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alat`
--

INSERT INTO `alat` (`id_alat`, `nama_alat`, `harga`, `id_kategori`, `gambar`, `ukuran`, `warna`, `jumlah`, `deskripsi`) VALUES
(12, 'Nesting', 20000, 2, 'default_image.jpg', 'Besar', 'Silver', 20, 'Full set untuk penyewaan, berbahan dasar titanium'),
(15, 'Tenda', 50000, 3, '1719398834_66fbb4ddfc3eb4916a10.jpg', '2P', 'orange', 39, '');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int NOT NULL,
  `nama_kategori` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(2, 'Alat Masak'),
(3, 'Peralatan Camp'),
(5, 'Peralatan Tidur'),
(6, 'Sepatu Outdoor');

-- --------------------------------------------------------

--
-- Table structure for table `pengembalian`
--

CREATE TABLE `pengembalian` (
  `id_pengemb_alat` int NOT NULL,
  `id_alat` int NOT NULL,
  `jumlah_pengemb_alat` int NOT NULL,
  `harga_satuan` float(10,2) NOT NULL,
  `total_harga` float(10,2) NOT NULL,
  `tgl_pengemb_alat` date NOT NULL,
  `disimpan_oleh` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_trans_alat` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengembalian`
--

INSERT INTO `pengembalian` (`id_pengemb_alat`, `id_alat`, `jumlah_pengemb_alat`, `harga_satuan`, `total_harga`, `tgl_pengemb_alat`, `disimpan_oleh`, `id_trans_alat`) VALUES
(2, 12, 3, 20.00, 60.00, '2024-07-01', 'nashir', 0),
(3, 12, 3, 20.00, 60.00, '2024-07-01', 'nashir', 0),
(6, 12, 2, 20.00, 40.00, '2024-07-19', 'susilo', 0),
(7, 15, 5, 50.00, 250.00, '2024-07-20', 'susilo', 0),
(8, 12, 8, 20.00, 160.00, '2024-07-26', 'susilo', 0),
(9, 12, 12, 20.00, 240.00, '2024-07-26', 'susilo', 0),
(10, 12, 2, 0.00, 0.00, '2024-07-26', 'roy', 0),
(11, 12, 2, 0.00, 0.00, '2024-07-26', 'roy', 0),
(12, 12, 2, 0.00, 0.00, '2024-07-26', 'roy', 0),
(13, 12, 2, 0.00, 0.00, '2024-07-26', 'roy', 0),
(14, 12, 2, 0.00, 0.00, '2024-07-26', 'roy', 0),
(15, 12, 2, 0.00, 0.00, '2024-07-26', 'roy', 0),
(16, 12, 2, 0.00, 0.00, '2024-07-26', 'roy', 0),
(17, 12, 2, 0.00, 0.00, '2024-07-26', 'roy', 0),
(18, 12, 2, 0.00, 0.00, '2024-07-26', 'roy', 12),
(19, 12, 2, 0.00, 0.00, '2024-07-26', 'roy', 12),
(20, 12, 2, 0.00, 0.00, '2024-07-26', 'roy', 12),
(21, 12, 2, 0.00, 0.00, '2024-07-26', 'roy', 12),
(23, 15, 2, 0.00, 100000.00, '2024-07-12', 'roy', 5),
(24, 15, 4, 0.00, 250000.00, '2024-07-19', 'susilo', 7),
(25, 12, 10, 0.00, 200000.00, '2024-07-26', 'roy', 18),
(26, 15, 15, 50.00, 750.00, '2025-06-04', 'susilo', 0),
(27, 12, 30, 0.00, 1800000.00, '2025-06-03', 'susilo', 19),
(28, 12, 6, 0.00, 120000.00, '2024-07-26', 'roy', 17),
(29, 15, 20, 0.00, 3000000.00, '2025-06-02', 'susilo', 20),
(30, 15, 16, 0.00, 250000.00, '2024-07-19', 'susilo', 8),
(31, 12, 1000000000, 0.00, 740000.00, '2025-06-02', 'susilo', 21),
(32, 12, 2147483647, 0.00, 2200000.00, '2025-06-02', 'susilo', 22),
(33, 12, -2147483648, 0.00, 2200000.00, '2025-06-02', 'susilo', 22),
(34, 12, 4, 0.00, 400000.00, '2025-06-02', 'roy', 2);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_trans_alat` int NOT NULL,
  `id_alat` int NOT NULL,
  `jumlah_trans_alat` int NOT NULL,
  `total_harga` decimal(10,2) NOT NULL,
  `tgl_trans_alat` date NOT NULL,
  `tgl_est` date DEFAULT NULL,
  `disimpan_oleh` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('Disetujui','Tunggu','Tolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_trans_alat`, `id_alat`, `jumlah_trans_alat`, `total_harga`, `tgl_trans_alat`, `tgl_est`, `disimpan_oleh`, `status`) VALUES
(1, 12, 30, '1800000.00', '2025-06-12', '2025-06-10', 'susilo', 'Disetujui'),
(2, 12, 0, '400000.00', '2025-06-02', '2025-06-06', 'roy', 'Disetujui');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `username` char(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_lengkap` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `nama_lengkap`, `role`) VALUES
(1, 'roy', '67B9D3A2C85B9710B672665870641211BFF29FF6\r\n', 'El Roy Tamba', 'Pelanggan'),
(6, 'susilo', 'B6B96869B71DAFB56205F142E2946A7CECAEC677', 'Susilo Aditya Pratama', 'Admin'),
(8, 'nashirKun', '$2y$10$2R2TSUD24mWPvd3yX4CDLuT40m7QOhe3gtPTidP0BDtgLtOFK0vOi', 'nashirKun', 'Pelanggan');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alat`
--
ALTER TABLE `alat`
  ADD PRIMARY KEY (`id_alat`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD PRIMARY KEY (`id_pengemb_alat`),
  ADD KEY `id_trans_alat` (`id_trans_alat`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_trans_alat`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alat`
--
ALTER TABLE `alat`
  MODIFY `id_alat` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pengembalian`
--
ALTER TABLE `pengembalian`
  MODIFY `id_pengemb_alat` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_trans_alat` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
