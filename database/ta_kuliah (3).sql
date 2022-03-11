-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 07 Mar 2022 pada 10.52
-- Versi server: 10.4.17-MariaDB
-- Versi PHP: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ta_kuliah`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `divisi`
--

CREATE TABLE `divisi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `divisi`
--

INSERT INTO `divisi` (`id`, `nama`) VALUES
(1, 'IT'),
(2, 'Accounting'),
(3, 'Logistik'),
(4, 'Produksi'),
(5, 'Gudang');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jabatan`
--

CREATE TABLE `jabatan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `pass_grade` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `jabatan`
--

INSERT INTO `jabatan` (`id`, `nama`, `pass_grade`) VALUES
(1, 'Staff', 75),
(2, 'Supervisor', 80),
(3, 'Manager', 90),
(4, 'General Manger', 90);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal`
--

CREATE TABLE `jadwal` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `waktu_mulai` datetime NOT NULL,
  `waktu_selesai` datetime NOT NULL,
  `ket` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `jadwal`
--

INSERT INTO `jadwal` (`id`, `waktu_mulai`, `waktu_selesai`, `ket`) VALUES
(1, '2022-02-24 11:40:48', '2022-02-26 11:40:48', 'Open Recrutimen IT'),
(2, '2022-03-03 11:40:48', '2022-03-09 11:40:48', 'Open Recruitment Administrasi'),
(3, '2022-03-09 11:52:24', '2022-03-17 11:52:24', 'Open Recruitment Logistik dan Produksi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jawaban`
--

CREATE TABLE `jawaban` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `soal_detail_id` bigint(20) UNSIGNED NOT NULL,
  `jawaban` varchar(255) NOT NULL,
  `status` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `jawaban`
--

INSERT INTO `jawaban` (`id`, `soal_detail_id`, `jawaban`, `status`) VALUES
(1, 1, 'wilayah', NULL),
(2, 1, 'tempat', NULL),
(3, 1, 'habitat', NULL),
(4, 1, 'ruang', 1),
(5, 2, 'Eurasia, Indo-Australia, dan Pasifik', 1),
(6, 2, 'Eurasia, Pasifik, dan Amerika', NULL),
(7, 2, 'India, Eurasia, dan Hindia', NULL),
(8, 2, 'Pasifik, Indo-Australia, dan Antartika', NULL),
(9, 3, '12.00 WIT', 1),
(10, 3, '11.00 WIT', NULL),
(11, 3, '9.00 WIT', NULL),
(12, 3, '8.00 WIT', NULL),
(13, 4, 'jalan raya', NULL),
(14, 4, 'danau', NULL),
(15, 4, 'permukiman', 1),
(16, 4, 'hutan', NULL),
(17, 5, 'Sungai Serayu', NULL),
(18, 5, 'Sungai Mamberamo', NULL),
(19, 5, 'Batang Hari', 1),
(20, 5, 'Sungai Barito', NULL),
(21, 6, 'emas', 1),
(22, 6, 'minyak bumi', NULL),
(23, 6, 'timah', NULL),
(24, 6, 'tembaga', NULL),
(25, 7, 'Batak', NULL),
(26, 7, 'Minahasa', NULL),
(27, 7, 'Anak Dalam', NULL),
(28, 7, 'Minangkabau', 1),
(29, 8, 'menggiatkan kampanye banyak anak banyak rezeki', NULL),
(30, 8, 'mendorong pernikahan usia muda', NULL),
(31, 8, 'menghilangkan undang-undang yang mengatur batas usia menikah', NULL),
(32, 8, 'meningkatkan program keluarga berencana', 1),
(33, 9, 'intensitas curah hujan yang sangat tinggi', NULL),
(34, 9, 'berkurangnya daerah resapan air', 1),
(35, 9, 'meningkatnya sampah di perkotaan', NULL),
(36, 9, 'penyempitan badan aliran sungai', NULL),
(37, 10, 'sosial dan budaya', NULL),
(38, 10, 'komposisi penduduk', NULL),
(39, 10, 'penggunaan lahan', NULL),
(40, 10, 'orientasi mata pencaharian', 1),
(41, 11, 'sosial', NULL),
(42, 11, 'ekonomi', 1),
(43, 11, 'kebudayaan', NULL),
(44, 11, 'pendidikan', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jadwal_id` bigint(20) UNSIGNED NOT NULL,
  `jabatan_id` bigint(20) UNSIGNED NOT NULL,
  `divisi_id` bigint(20) UNSIGNED NOT NULL,
  `kuota` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pendaftaran`
--

INSERT INTO `pendaftaran` (`id`, `jadwal_id`, `jabatan_id`, `divisi_id`, `kuota`) VALUES
(1, 1, 1, 1, 2),
(2, 2, 2, 2, 1),
(3, 2, 3, 2, 1),
(4, 3, 1, 3, 4),
(5, 3, 1, 4, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `soal`
--

CREATE TABLE `soal` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_soal` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `waktu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `soal`
--

INSERT INTO `soal` (`id`, `kode_soal`, `nama`, `waktu`) VALUES
(1, 'S001', 'Tes Karyawan Gudang', 120),
(2, 'S002', 'Tes Loker IT dan Admin', 60);

-- --------------------------------------------------------

--
-- Struktur dari tabel `soal_detail`
--

CREATE TABLE `soal_detail` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `soal_id` bigint(11) UNSIGNED NOT NULL,
  `deskripsi` text NOT NULL,
  `bobot` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `soal_detail`
--

INSERT INTO `soal_detail` (`id`, `soal_id`, `deskripsi`, `bobot`) VALUES
(1, 1, 'Tempat di permukaan bumi, baik secara keseluruhan maupun hanya sebagian yang digunakan oleh makhluk hidup untuk   tinggal disebut….', 20),
(2, 1, 'Secara geologis, Indonesia terletak di zona pertemuan tiga lempeng besar dunia, yaitu….', 20),
(3, 1, 'Jika di Bogor menunjukkan waktu pukul 10.00 WIB, maka waktu di Jayapura menunjukkan waktu pukul', 20),
(4, 1, 'Contoh objek yang bisa digambarkan dengan warna hijau pada peta adalah', 20),
(5, 1, 'Berikut ini sungai yang terdapat di Pulau Sumatra adalah', 20),
(6, 2, 'Daerah yang ditunjukkan oleh huruf X merupakan daerah penghasil….', 20),
(7, 2, 'Suku yang berasal dari Provinsi Sumatra Barat adalah', 20),
(8, 2, 'Indonesia merupakan negara dengan jumlah penduduk terbanyak keempat di dunia. Hal ini disebabkan oleh pertumbuhan penduduknya yang tinggi. Upaya yang bisa dilakukan untuk menekan angka pertumbuhan penduduk Indonesia adalah', 20),
(9, 2, 'Puncak, Bogor merupakan salah satu daerah tujuan wisata penduduk perkotaan, terutama Jakarta dan Depok. Hal ini menjadikan terjadinya peningkatan pembangunan villa-villa dan penginapan di Puncak. Namun, pembangunan ini menjadikan potensi banjir di Jakarta semakin meningkat. Faktor yang menyebabkan hal tersebut terjadi adalah', 20),
(10, 2, 'Perubahan pekerjaan dari yang tadinya berorientasi pada sumber daya alam seperti petani menjadi pekerjaan yang berorientasi pada kegiatan industri dan jasa, merupakan dampak dari interaksi antarruang dalam bidang', 20),
(11, 2, 'Kegiatan pada gambar tersebut menunjukkan adanya sebuah interaksi di bidang ', 15);

-- --------------------------------------------------------

--
-- Struktur dari tabel `soal_divisi`
--

CREATE TABLE `soal_divisi` (
  `soal_id` bigint(20) UNSIGNED NOT NULL,
  `divisi_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `soal_divisi`
--

INSERT INTO `soal_divisi` (`soal_id`, `divisi_id`) VALUES
(1, 5),
(2, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `soal_jabatan`
--

CREATE TABLE `soal_jabatan` (
  `soal_id` bigint(20) UNSIGNED NOT NULL,
  `jabatan_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `soal_jabatan`
--

INSERT INTO `soal_jabatan` (`soal_id`, `jabatan_id`) VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 2),
(2, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pendaftaran_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `jenis_kelamin` char(1) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('user','admin') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `pendaftaran_id`, `nama`, `password`, `jenis_kelamin`, `email`, `role`, `created_at`, `updated_at`) VALUES
(9, NULL, 'Wisnu Sunadi', '$2y$10$kNWn1npRmSFTTTuVVo3I7OEfGtRFm.SDY66gpowVVWI73if12Qh5m', 'l', 'wisnu@gmail.com', 'admin', '2022-02-22 05:44:01', '2022-02-22 05:44:01'),
(10, NULL, 'Rahayu Ajeng', '$2y$10$eB6Lo3hTut9SSibtIy4hY.QmjlACwYtfT/RPgQQM4g0Bx56Stl626', 'p', 'rahayu@gmail.com', 'admin', '2022-02-22 21:28:32', '2022-02-22 21:28:32'),
(11, 2, 'Joni', '$2y$10$GSUoGznB6zalL3ryiqcg3eeylVSAQVnsjnYvwBjYQCtiTeBVxB8bu', 'l', 'joni@gmail.com', 'user', '2022-03-05 22:16:31', '2022-03-05 22:16:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_jawaban`
--

CREATE TABLE `user_jawaban` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `soal_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `divisi`
--
ALTER TABLE `divisi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jawaban`
--
ALTER TABLE `jawaban`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jawabab_fk1` (`soal_detail_id`);

--
-- Indeks untuk tabel `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pendaftaran_fk1` (`jabatan_id`),
  ADD KEY `pendaftaran_fk2` (`jadwal_id`),
  ADD KEY `pendaftaran_fk3` (`divisi_id`);

--
-- Indeks untuk tabel `soal`
--
ALTER TABLE `soal`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `soal_detail`
--
ALTER TABLE `soal_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `soal_detail_fk1` (`soal_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_fk1` (`pendaftaran_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `divisi`
--
ALTER TABLE `divisi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `jawaban`
--
ALTER TABLE `jawaban`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT untuk tabel `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `soal`
--
ALTER TABLE `soal`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `soal_detail`
--
ALTER TABLE `soal_detail`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `jawaban`
--
ALTER TABLE `jawaban`
  ADD CONSTRAINT `jawabab_fk1` FOREIGN KEY (`soal_detail_id`) REFERENCES `soal_detail` (`id`);

--
-- Ketidakleluasaan untuk tabel `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD CONSTRAINT `pendaftaran_fk1` FOREIGN KEY (`jabatan_id`) REFERENCES `jabatan` (`id`),
  ADD CONSTRAINT `pendaftaran_fk2` FOREIGN KEY (`jadwal_id`) REFERENCES `jadwal` (`id`),
  ADD CONSTRAINT `pendaftaran_fk3` FOREIGN KEY (`divisi_id`) REFERENCES `divisi` (`id`);

--
-- Ketidakleluasaan untuk tabel `soal_detail`
--
ALTER TABLE `soal_detail`
  ADD CONSTRAINT `soal_detail_fk1` FOREIGN KEY (`soal_id`) REFERENCES `soal` (`id`);

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `user_fk1` FOREIGN KEY (`pendaftaran_id`) REFERENCES `pendaftaran` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
