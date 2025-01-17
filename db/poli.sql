-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Des 2024 pada 09.18
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
-- Database: `poliklinik`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admins`
--

CREATE TABLE `admins` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(11) NOT NULL,
  `password` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'superadmin', '123');

-- --------------------------------------------------------

--
-- Struktur dari tabel `daftar_poli`
--

CREATE TABLE `daftar_poli` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_pasien` int(11) UNSIGNED NOT NULL,
  `id_jadwal` int(11) UNSIGNED NOT NULL,
  `keluhan` text NOT NULL,
  `no_antrian` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `daftar_poli`
--

-- INSERT INTO `daftar_poli` (`id`, `id_pasien`, `id_jadwal`, `keluhan`, `no_antrian`) VALUES
-- (1, 5, 1, 'Pusing, Mual dan Demam', 1),
-- (2, 2, 1, 'Sakit Perut', 2),
-- (3, 1, 1, 'Batuk, Pilek', 3),
-- (4, 5, 5, 'Diare', 1),
-- (5, 5, 1, 'Mual', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_periksa`
--

CREATE TABLE `detail_periksa` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_periksa` int(11) UNSIGNED NOT NULL,
  `id_obat` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detail_periksa`
--

-- INSERT INTO `detail_periksa` (`id`, `id_periksa`, `id_obat`) VALUES
-- (1, 5, 5),
-- (2, 8, 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `dokter`
--

CREATE TABLE `dokter` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama_dokter` varchar(255) NOT NULL,
  `alamat_dokter` varchar(255) NOT NULL,
  `no_hp` varchar(255) NOT NULL,
  `password` varchar(11) NOT NULL,
  `id_poli` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `dokter`
--

INSERT INTO `dokter` (`id`, `nama_dokter`, `alamat_dokter`, `no_hp`, `password`, `id_poli`) VALUES
(1, 'dr Jeje', 'Semarang', '085711112222', '123', 2),
(2, 'dr Lila', 'Kudus', '085722223333', '123', 1),
(3, 'dr Johana', 'Jogja', '085733334444', '123', 1),
(4, 'dr Grace', 'Pati', '085744445555', '123', 2);
-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal_periksa`
--

CREATE TABLE `jadwal_periksa` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_dokter` int(11) UNSIGNED NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu') NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `status_jadwal` enum('1','0') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jadwal_periksa`
--

INSERT INTO `jadwal_periksa` (`id`, `id_dokter`, `hari`, `jam_mulai`, `jam_selesai`, `status_jadwal`) VALUES
(1, 1, 'Selasa', '08:00:00', '10:00:00', '1'),
(2, 1, 'Selasa', '18:00:00', '22:00:00', '0'),
(3, 2, 'Senin', '16:00:00', '20:00:00', ''),
(4, 2, 'Selasa', '07:00:00', '09:00:00', ''),
(5, 2, 'Rabu', '12:00:00', '15:00:00', ''),
(6, 3, 'Senin', '12:00:00', '15:00:00', ''),
(7, 3, 'Senin', '16:00:00', '18:00:00', ''),
(8, 3, 'Rabu', '07:00:00', '09:00:00', ''),
(9, 4, 'Selasa', '12:00:00', '15:00:00', ''),
(10, 4, 'Rabu', '16:00:00', '20:00:00', ''),
(11, 4, 'Kamis', '07:00:00', '09:00:00', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `obat`
--

CREATE TABLE `obat` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama_obat` varchar(50) NOT NULL,
  `kemasan` varchar(35) NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `obat`
--

INSERT INTO `obat` (`id`, `nama_obat`, `kemasan`, `harga`) VALUES
(1, 'Ibuprofen', '200mg', 35000),
(2, 'Vitamin C', '100ml', 20000),
(3, 'Paracetamol', '150gr', 30000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pasien`
--

CREATE TABLE `pasien` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama_pasien` varchar(255) NOT NULL,
  `alamat_pasien` varchar(255) NOT NULL,
  `no_ktp` varchar(255) NOT NULL,
  `no_hp` varchar(50) NOT NULL,
  `no_rm` varchar(25) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pasien`
--

INSERT INTO `pasien` (`id`, `nama_pasien`, `alamat_pasien`, `no_ktp`, `no_hp`, `no_rm`, `password`) VALUES
(1, 'Jessie', 'Semarang', '33333333333', '081234567890', '202401-001', '123'),
(2, 'Lila', 'Kudus', '444444444444', '081234567891', '202401-002', '123'),
(3, 'Carlos', 'Jepata', '555555555', '081234567891', '202401-003', '123'),
(4, 'Gracia', 'Pati', '666666666666', '081234567893', '202401-004', '123'),
(5, 'Aditama', 'Bondo', '7777777777', '081234567894', '202401-005', '123'),
(6, 'Choco', 'Sadewa', '8888888888', '081234567895', '202401-006', '123'),
(7, 'Kayllalee', 'Semarang', '99999999', '081234567896', '202401-007', '123');

-- --------------------------------------------------------

--
-- Struktur dari tabel `periksa`
--

CREATE TABLE `periksa` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_daftar_poli` int(11) UNSIGNED NOT NULL,
  `tgl_periksa` datetime DEFAULT NULL,
  `catatan` varchar(50) NOT NULL,
  `biaya_periksa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `periksa`
--

-- INSERT INTO `periksa` (`id`, `id_daftar_poli`, `tgl_periksa`, `catatan`, `biaya_periksa`) VALUES
-- (5, 15, '2024-01-08 21:06:00', 'Istirahat', 180000),
-- (6, 16, NULL, '', 0),
-- (7, 17, NULL, '', 0),
-- (8, 18, '2024-01-08 21:31:00', 'Jangan makan', 180000),
-- (9, 19, NULL, '', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `poli`
--

CREATE TABLE `poli` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama_poli` varchar(255) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `poli`
--

INSERT INTO `poli` (`id`, `nama_poli`, `keterangan`) VALUES
(1, 'Poliklinik Gigi', 'Poli gigi'),
(2, 'Poliklinik Anak', 'Poliklinik anak');

-- Create feedback_pasien table with proper AUTO_INCREMENT primary key
CREATE TABLE feedback_pasien (
  id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  id_periksa int(11) UNSIGNED NOT NULL,
  rating int(1) NOT NULL,
  komentar text NOT NULL,
  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Add foreign key constraint
ALTER TABLE feedback_pasien
  ADD CONSTRAINT fk_feedback_periksa
  FOREIGN KEY (id_periksa)
  REFERENCES periksa(id)
  ON DELETE CASCADE;

-- Add index for better performance
ALTER TABLE feedback_pasien
  ADD INDEX idx_id_periksa (id_periksa);
--
-- Indexes for dumped tables
--


--
-- Indeks untuk tabel `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `daftar_poli`
--
ALTER TABLE `daftar_poli`
  ADD PRIMARY KEY (`id`),
  ADD KEY `poli_idPasien` (`id_pasien`),
  ADD KEY `poli_idJadwal` (`id_jadwal`);

--
-- Indeks untuk tabel `detail_periksa`
--
ALTER TABLE `detail_periksa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `poli_idPeriksa` (`id_periksa`),
  ADD KEY `poli_idObat` (`id_obat`);

--
-- Indeks untuk tabel `dokter`
--
ALTER TABLE `dokter`
  ADD PRIMARY KEY (`id`),
  ADD KEY `poli_idPoli` (`id_poli`);

--
-- Indeks untuk tabel `jadwal_periksa`
--
ALTER TABLE `jadwal_periksa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `poli_idDokter` (`id_dokter`);

--
-- Indeks untuk tabel `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `periksa`
--
ALTER TABLE `periksa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `poli_idDaftarPoli` (`id_daftar_poli`);

--
-- Indeks untuk tabel `poli`
--
ALTER TABLE `poli`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `daftar_poli`
--
ALTER TABLE `daftar_poli`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `detail_periksa`
--
ALTER TABLE `detail_periksa`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `dokter`
--
ALTER TABLE `dokter`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `jadwal_periksa`
--
ALTER TABLE `jadwal_periksa`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `obat`
--
ALTER TABLE `obat`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `pasien`
--
ALTER TABLE `pasien`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `periksa`
--
ALTER TABLE `periksa`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `poli`
--
ALTER TABLE `poli`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `daftar_poli`
--
ALTER TABLE `daftar_poli`
  ADD CONSTRAINT `poli_idJadwal` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal_periksa` (`id`),
  ADD CONSTRAINT `poli_idPasien` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id`);

--
-- Ketidakleluasaan untuk tabel `detail_periksa`
--
ALTER TABLE `detail_periksa`
  ADD CONSTRAINT `poli_idObat` FOREIGN KEY (`id_obat`) REFERENCES `obat` (`id`),
  ADD CONSTRAINT `poli_idPeriksa` FOREIGN KEY (`id_periksa`) REFERENCES `periksa` (`id`);

--
-- Ketidakleluasaan untuk tabel `dokter`
--
ALTER TABLE `dokter`
  ADD CONSTRAINT `poli_idPoli` FOREIGN KEY (`id_poli`) REFERENCES `poli` (`id`);

--
-- Ketidakleluasaan untuk tabel `jadwal_periksa`
--
ALTER TABLE `jadwal_periksa`
  ADD CONSTRAINT `poli_idDokter` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id`);

--
-- Ketidakleluasaan untuk tabel `periksa`
--
ALTER TABLE `periksa`
  ADD CONSTRAINT `poli_idDaftarPoli` FOREIGN KEY (`id_daftar_poli`) REFERENCES `daftar_poli` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
