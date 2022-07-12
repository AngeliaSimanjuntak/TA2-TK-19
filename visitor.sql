-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Jul 2022 pada 09.54
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `visitor`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `device`
--

CREATE TABLE `device` (
  `id` int(11) NOT NULL,
  `lokasi_id` int(11) NOT NULL,
  `nama` varchar(128) NOT NULL,
  `mode` varchar(10) NOT NULL DEFAULT 'SCAN'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `device`
--

INSERT INTO `device` (`id`, `lokasi_id`, `nama`, `mode`) VALUES
(1, 1, 'Museum TB SIlalahi Center', 'SCAN'),
(2, 2, 'Hutanta Cafe', 'SCAN'),
(3, 3, 'Geopark Kaldera Toba', 'SCAN'),
(4, 4, 'Bukit Gibeon', 'SCAN');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lokasi`
--

CREATE TABLE `lokasi` (
  `id` int(11) NOT NULL,
  `nama_lokasi` varchar(128) NOT NULL,
  `alamat` text NOT NULL,
  `jam_operasional` varchar(50) NOT NULL,
  `jml_maximum` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `lokasi`
--

INSERT INTO `lokasi` (`id`, `nama_lokasi`, `alamat`, `jam_operasional`, `jml_maximum`) VALUES
(1, 'Museum TB Silalahi Center', 'Jl. Dr. TB. Silalahi No.88, Silalahi Pagar Batu, Kec. Balige, Toba, Sumatera Utara 20553', '08:30 - 17:30', 180),
(2, 'Hutanta Cafe', 'Jl. P. Siantar No.KM 2, Sibola Hotangsas, Kec. Balige, Toba, Sumatera Utara 22312', '11:45 - 23:55', 100),
(3, 'Geopark Kaldera Toba', 'Jl. Simbolon Purba, Pangururan, Kabupaten Samosir, Sumatera Utara, Kode pos: 22392', '08:00 - 18:00', 200),
(4, 'Bukit Gibeon', 'Parsaoran Sibisa, Ajibata, Sionggang Utara, Lumban Julu, Kabupaten Toba Samosir, Sumatera Utara', '08:00 - 19:00', 150);

-- --------------------------------------------------------

--
-- Struktur dari tabel `nik`
--

CREATE TABLE `nik` (
  `id` int(11) NOT NULL,
  `nik` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `secret_key`
--

CREATE TABLE `secret_key` (
  `id` int(11) NOT NULL,
  `secret_key` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `secret_key`
--

INSERT INTO `secret_key` (`id`, `secret_key`) VALUES
(1, 'visitor2022');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `uuid` int(11) NOT NULL,
  `nama` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `gambar_wajah` varchar(128) DEFAULT NULL,
  `level` enum('admin','visitor') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `uuid`, `nama`, `email`, `password`, `gambar_wajah`, `level`) VALUES
(1, 0, 'Developer', 'dev@gmail.com', '$2a$12$PAn6qB36CWoYa1eGIWDXKe2xowui.JSR5zVSWaiom.jtxiJPg8PVG', 'admin.png', 'admin'),
(16, 220709553, 'Angelia Sondang Simanjuntak', 'angelia.simanjuntak3@gmail.com', '$2y$10$jMhzaGgV0RNQl2Ll4miirOlOeoZs56k9qAtQlX3pOtr/GCpU2dx42', 'angelia_sondang_simanjuntak.jpeg', 'visitor'),
(17, 220709245, 'Roma Asi Simamora', 'romaasisimamora19@gmail.com', '$2y$10$r0xjf8PLi.jau5jml4P30OMEHLrPtptgHLiNSj1.gLdpLDfSzpjBW', 'roma_asi_simamora.jpeg', 'visitor'),
(18, 220709704, 'Putri Anjelia Pasaribu', 'pasaribuputri88@gmail.com', '$2y$10$yZLxhfSXvtncDt45/cggyuoQj.X/EUlseU.bqZ/uZTGqXrPGCAwjm', 'putri_anjelia_pasaribu.jpeg', 'visitor');

-- --------------------------------------------------------

--
-- Struktur dari tabel `visitor`
--

CREATE TABLE `visitor` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `lokasi_id` int(11) NOT NULL,
  `device_id` int(11) NOT NULL,
  `checkin` int(11) NOT NULL DEFAULT 0,
  `waktu_checkin` varchar(50) DEFAULT NULL,
  `foto_checkin` varchar(128) DEFAULT NULL,
  `checkout` int(11) NOT NULL DEFAULT 0,
  `waktu_checkout` varchar(50) DEFAULT NULL,
  `foto_checkout` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `visitor`
--

INSERT INTO `visitor` (`id`, `user_id`, `lokasi_id`, `device_id`, `checkin`, `waktu_checkin`, `foto_checkin`, `checkout`, `waktu_checkout`, `foto_checkout`) VALUES
(17, 17, 1, 1, 1, '2022-07-12 13:01:18', '', 1, '2022-07-12 13:03:02', ''),
(18, 16, 1, 1, 1, '2022-07-12 13:21:43', '', 1, '2022-07-12 13:22:24', '');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `device`
--
ALTER TABLE `device`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `lokasi`
--
ALTER TABLE `lokasi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `nik`
--
ALTER TABLE `nik`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `secret_key`
--
ALTER TABLE `secret_key`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `visitor`
--
ALTER TABLE `visitor`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `device`
--
ALTER TABLE `device`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `lokasi`
--
ALTER TABLE `lokasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `nik`
--
ALTER TABLE `nik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `secret_key`
--
ALTER TABLE `secret_key`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `visitor`
--
ALTER TABLE `visitor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
