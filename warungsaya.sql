-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 29 Agu 2025 pada 10.53
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `warungsaya`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$rH4NjGP/NGj25dJn/kQQROfiZzC0sDTziIekDiz4bSmD7vj/PNvhy');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id` int(11) NOT NULL,
  `pesanan_id` int(11) DEFAULT NULL,
  `produk_id` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `harga_satuan` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detail_pesanan`
--

INSERT INTO `detail_pesanan` (`id`, `pesanan_id`, `produk_id`, `jumlah`, `harga_satuan`) VALUES
(1, 1, 2, 1, 28000000.00),
(2, 2, 2, 1, 28000000.00),
(3, 3, 2, 1, 28000000.00),
(4, 4, 4, 1, 14999000.00),
(5, 5, 4, 1, 14999000.00),
(6, 5, 5, 1, 16999000.00),
(7, 5, 3, 1, 21999000.00),
(8, 5, 2, 1, 17560000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `id` int(11) NOT NULL,
  `nama_pelanggan` varchar(100) DEFAULT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `metode_bayar` varchar(20) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pesanan`
--

INSERT INTO `pesanan` (`id`, `nama_pelanggan`, `no_hp`, `alamat`, `metode_bayar`, `total`, `tanggal`) VALUES
(1, 'Ardiansyah', '081564743303', 'Kuningan', 'Tunai', 28000000.00, '2025-08-28 05:05:07'),
(2, 'Davin', '089788879876', 'Pal Merah', 'Tunai', 28000000.00, '2025-08-28 06:35:45'),
(3, 'Jafar', '088634498274', 'Cilowa', 'Transfer', 28000000.00, '2025-08-28 16:32:24'),
(4, 'Nabila', '087898876543', 'Karangtawang', 'OVO', 14999000.00, '2025-08-28 17:05:23'),
(5, 'Raka', '085797714976', 'Purwasari 2113', 'GoPay', 71557000.00, '2025-08-29 04:03:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `stok` int(11) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `gambar` varchar(100) DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id`, `nama`, `harga`, `stok`, `deskripsi`, `created_at`, `gambar`) VALUES
(2, 'Iphone 15 Pro Max', 17560000.00, 4, 'iPhone terbaru dengan material Titanium yang ringan & premium, layar 6,7\" Super Retina XDR 120Hz, chipset A17 Pro super cepat, serta sistem kamera 48MP Pro Camera dengan zoom hingga 5x (eksklusif Pro Max). Memori besar 512GB, cocok untuk kebutuhan profesional & hiburan.\r\n✨ Unit Brand New In Box (BNIB) • Garansi Resmi iBox 1 Tahun', '2025-08-28 04:53:59', '68b0895c21baf_iphone15promax.jpg'),
(3, 'Iphone 16 Pro Max', 21999000.00, 4, 'Smartphone flagship dengan desain elegan berbahan titanium, layar 6,9\" Super Retina XDR ProMotion, serta performa super cepat dari chip A18 Pro. Dilengkapi 48MP Pro Camera System dengan zoom hingga 5x, Face ID, 5G, dan baterai tahan lama.', '2025-08-28 16:54:11', '68b089b2e8f78_iphone-16-pro-max-1725955180295512439.jpg'),
(4, 'Asus ROG Phone 8 Pro', 14999000.00, 3, 'Smartphone gaming premium dengan layar 6,78\" AMOLED 165Hz, ditenagai Snapdragon 8 Gen 3, RAM hingga 24GB, dan memori besar hingga 1TB. Dilengkapi sistem pendingin canggih, kamera 50MP Sony IMX890, audio Dolby Atmos, baterai 5500mAh dengan fast charging 65W.\r\nDirancang untuk performa ekstrem, grafis halus, dan pengalaman gaming terbaik.', '2025-08-28 17:01:17', '68b08b5d45296_rog8pro.jfif'),
(5, 'Asus ROG Phone 9 Pro', 16999000.00, 4, 'Flagship gaming phone dengan layar 6,78″ Samsung AMOLED 165-185 Hz super responsif, ditenagai Snapdragon 8 Elite, RAM hingga 24 GB, dan penyimpanan hingga 1 TB. Didukung oleh Gimbal-OIS 50 MP, telefoto 32 MP 3× zoom, baterai besar 5.800 mAh dengan 65 W fast charge & wireless charging, serta fitur unik seperti AniMe Vision mini-LED, AirTrigger, dan sistem pendingin eksklusif AeroActive Cooler X Pro.', '2025-08-28 17:04:12', '68b08c0c23b42_rog9pro.jfif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'Ardi', '085797714976', '$2y$10$40xgERcGRJMQf3ElQ3LnFuOq1kTwQcXaQcOJWdfi3JCOSH1IBQrla', '2025-08-29 01:22:26');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pesanan_id` (`pesanan_id`),
  ADD KEY `produk_id` (`produk_id`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD CONSTRAINT `detail_pesanan_ibfk_1` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`),
  ADD CONSTRAINT `detail_pesanan_ibfk_2` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
