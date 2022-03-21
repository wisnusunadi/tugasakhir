-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Mar 21, 2022 at 09:56 AM
-- Server version: 5.7.33
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ta_me`
--

-- --------------------------------------------------------

--
-- Table structure for table `divisi`
--

CREATE TABLE `divisi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `divisi`
--

INSERT INTO `divisi` (`id`, `nama`) VALUES
(1, 'IT'),
(2, 'Accounting'),
(3, 'Logistik'),
(4, 'Produksi'),
(5, 'Gudang');

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `pass_grade` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`id`, `nama`, `pass_grade`) VALUES
(1, 'Staff', 75),
(2, 'Supervisor', 80),
(3, 'Manager', 90),
(4, 'General Manger', 90);

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `waktu_mulai` datetime NOT NULL,
  `waktu_selesai` datetime NOT NULL,
  `ket` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`id`, `waktu_mulai`, `waktu_selesai`, `ket`) VALUES
(1, '2022-02-24 11:40:48', '2022-02-26 11:40:48', 'Open Recrutimen IT'),
(2, '2022-03-03 11:40:48', '2022-03-09 11:40:48', 'Open Recruitment Administrasi'),
(3, '2022-03-09 11:52:24', '2022-03-17 11:52:24', 'Open Recruitment Logistik dan Produksi');

-- --------------------------------------------------------

--
-- Table structure for table `jawaban`
--

CREATE TABLE `jawaban` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `soal_detail_id` bigint(20) UNSIGNED NOT NULL,
  `jawaban` varchar(255) NOT NULL,
  `status` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jawaban`
--

INSERT INTO `jawaban` (`id`, `soal_detail_id`, `jawaban`, `status`) VALUES
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
(44, 11, 'pendidikan', NULL),
(94, 33, 'dfdfsff', 1),
(95, 33, 'dsfsdfdss', NULL),
(96, 34, 'dfsf', NULL),
(97, 34, 'sdfsfsd', 1),
(98, 35, 'wilayah', NULL),
(99, 35, 'tempat', NULL),
(100, 35, 'habitat', NULL),
(101, 35, 'ruang', 1),
(102, 36, 'Eurasia, Indo-Australia, dan Pasifik', 1),
(103, 36, 'Eurasia, Pasifik, dan Amerika', NULL),
(104, 36, 'India, Eurasia, dan Hindia', NULL),
(105, 36, 'Pasifik, Indo-Australia, dan Antartika', NULL),
(106, 37, '12.00 WIT', 1),
(107, 37, '11.00 WIT', NULL),
(108, 37, '9.00 WIT', NULL),
(109, 37, '8.00 WIT', NULL),
(110, 38, 'jalan raya', NULL),
(111, 38, 'danau', NULL),
(112, 38, 'permukiman', 1),
(113, 38, 'hutan', NULL),
(114, 39, 'Sungai Serayu', NULL),
(115, 39, 'Sungai Mamberamo', NULL),
(116, 39, 'Batang Hari', 1),
(117, 39, 'Sungai Barito', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jadwal_id` bigint(20) UNSIGNED NOT NULL,
  `jabatan_id` bigint(20) UNSIGNED NOT NULL,
  `divisi_id` bigint(20) UNSIGNED NOT NULL,
  `kuota` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pendaftaran`
--

INSERT INTO `pendaftaran` (`id`, `jadwal_id`, `jabatan_id`, `divisi_id`, `kuota`) VALUES
(1, 1, 1, 1, 2),
(2, 2, 2, 2, 1),
(3, 2, 3, 2, 1),
(4, 3, 1, 3, 4),
(5, 3, 1, 4, 3);

-- --------------------------------------------------------

--
-- Table structure for table `soal`
--

CREATE TABLE `soal` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_soal` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `waktu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `soal`
--

INSERT INTO `soal` (`id`, `kode_soal`, `nama`, `waktu`) VALUES
(1, 'S001', 'Tes Karyawan Gudang', 120),
(2, 'S002', 'Tes Loker IT dan Admin', 30),
(25, 'SRT001', 'Tes Loker IT dan Admin 4', 40);

-- --------------------------------------------------------

--
-- Table structure for table `soal_detail`
--

CREATE TABLE `soal_detail` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `soal_id` bigint(11) UNSIGNED NOT NULL,
  `deskripsi` text NOT NULL,
  `bobot` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `soal_detail`
--

INSERT INTO `soal_detail` (`id`, `soal_id`, `deskripsi`, `bobot`) VALUES
(6, 2, 'Daerah yang ditunjukkan oleh huruf X merupakan daerah penghasil….', 20),
(7, 2, 'Suku yang berasal dari Provinsi Sumatra Barat adalah', 20),
(8, 2, 'Indonesia merupakan negara dengan jumlah penduduk terbanyak keempat di dunia. Hal ini disebabkan oleh pertumbuhan penduduknya yang tinggi. Upaya yang bisa dilakukan untuk menekan angka pertumbuhan penduduk Indonesia adalah', 20),
(9, 2, 'Puncak, Bogor merupakan salah satu daerah tujuan wisata penduduk perkotaan, terutama Jakarta dan Depok. Hal ini menjadikan terjadinya peningkatan pembangunan villa-villa dan penginapan di Puncak. Namun, pembangunan ini menjadikan potensi banjir di Jakarta semakin meningkat. Faktor yang menyebabkan hal tersebut terjadi adalah', 20),
(10, 2, 'Perubahan pekerjaan dari yang tadinya berorientasi pada sumber daya alam seperti petani menjadi pekerjaan yang berorientasi pada kegiatan industri dan jasa, merupakan dampak dari interaksi antarruang dalam bidang', 20),
(11, 2, 'Kegiatan pada gambar tersebut menunjukkan adanya sebuah interaksi di bidang ', 15),
(33, 25, 'RERERER', 10),
(34, 25, 'fgngfnfg', 12),
(35, 1, 'Tempat di permukaan bumi, baik secara keseluruhan maupun hanya sebagian yang digunakan oleh makhluk hidup untuk   tinggal disebut….', 20),
(36, 1, 'Secara geologis, Indonesia terletak di zona pertemuan tiga lempeng besar dunia, yaitu….', 20),
(37, 1, 'Jika di Bogor menunjukkan waktu pukul 10.00 WIB, maka waktu di Jayapura menunjukkan waktu pukul', 20),
(38, 1, 'Contoh objek yang bisa digambarkan dengan warna hijau pada peta adalah', 20),
(39, 1, 'Berikut ini sungai yang terdapat di Pulau Sumatra adalah', 20);

-- --------------------------------------------------------

--
-- Table structure for table `soal_divisi`
--

CREATE TABLE `soal_divisi` (
  `soal_id` bigint(20) UNSIGNED NOT NULL,
  `divisi_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `soal_divisi`
--

INSERT INTO `soal_divisi` (`soal_id`, `divisi_id`) VALUES
(1, 5),
(2, 1),
(2, 2),
(25, 2),
(25, 5),
(1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `soal_jabatan`
--

CREATE TABLE `soal_jabatan` (
  `soal_id` bigint(20) UNSIGNED NOT NULL,
  `jabatan_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `soal_jabatan`
--

INSERT INTO `soal_jabatan` (`soal_id`, `jabatan_id`) VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 2),
(2, 3),
(25, 4),
(25, 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
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
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `pendaftaran_id`, `nama`, `password`, `jenis_kelamin`, `email`, `role`, `created_at`, `updated_at`) VALUES
(9, NULL, 'Wisnu Sunadi', '$2y$10$kNWn1npRmSFTTTuVVo3I7OEfGtRFm.SDY66gpowVVWI73if12Qh5m', 'l', 'wisnu@gmail.com', 'admin', '2022-02-22 05:44:01', '2022-02-22 05:44:01'),
(10, NULL, 'Rahayu Ajeng', '$2y$10$eB6Lo3hTut9SSibtIy4hY.QmjlACwYtfT/RPgQQM4g0Bx56Stl626', 'p', 'rahayu@gmail.com', 'admin', '2022-02-22 21:28:32', '2022-02-22 21:28:32'),
(11, 2, 'Joni', '$2y$10$GSUoGznB6zalL3ryiqcg3eeylVSAQVnsjnYvwBjYQCtiTeBVxB8bu', 'l', 'joni@gmail.com', 'user', '2022-03-05 22:16:31', '2022-03-05 22:16:31');

-- --------------------------------------------------------

--
-- Table structure for table `user_jawaban`
--

CREATE TABLE `user_jawaban` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `jawaban_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_jawaban`
--

INSERT INTO `user_jawaban` (`user_id`, `jawaban_id`) VALUES
(11, 24),
(11, 39),
(11, 41),
(11, 33),
(11, 26),
(11, 29);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `divisi`
--
ALTER TABLE `divisi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jawaban`
--
ALTER TABLE `jawaban`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jawabab_fk1` (`soal_detail_id`);

--
-- Indexes for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pendaftaran_fk1` (`jabatan_id`),
  ADD KEY `pendaftaran_fk2` (`jadwal_id`),
  ADD KEY `pendaftaran_fk3` (`divisi_id`);

--
-- Indexes for table `soal`
--
ALTER TABLE `soal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `soal_detail`
--
ALTER TABLE `soal_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `soal_detail_fk1` (`soal_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_fk1` (`pendaftaran_id`);

--
-- Indexes for table `user_jawaban`
--
ALTER TABLE `user_jawaban`
  ADD KEY `user_jawaban_fk1` (`user_id`),
  ADD KEY `user_jawaban_fk2` (`jawaban_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `divisi`
--
ALTER TABLE `divisi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jawaban`
--
ALTER TABLE `jawaban`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `soal`
--
ALTER TABLE `soal`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `soal_detail`
--
ALTER TABLE `soal_detail`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jawaban`
--
ALTER TABLE `jawaban`
  ADD CONSTRAINT `jawabab_fk1` FOREIGN KEY (`soal_detail_id`) REFERENCES `soal_detail` (`id`);

--
-- Constraints for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD CONSTRAINT `pendaftaran_fk1` FOREIGN KEY (`jabatan_id`) REFERENCES `jabatan` (`id`),
  ADD CONSTRAINT `pendaftaran_fk2` FOREIGN KEY (`jadwal_id`) REFERENCES `jadwal` (`id`),
  ADD CONSTRAINT `pendaftaran_fk3` FOREIGN KEY (`divisi_id`) REFERENCES `divisi` (`id`);

--
-- Constraints for table `soal_detail`
--
ALTER TABLE `soal_detail`
  ADD CONSTRAINT `soal_detail_fk1` FOREIGN KEY (`soal_id`) REFERENCES `soal` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `user_fk1` FOREIGN KEY (`pendaftaran_id`) REFERENCES `pendaftaran` (`id`);

--
-- Constraints for table `user_jawaban`
--
ALTER TABLE `user_jawaban`
  ADD CONSTRAINT `user_jawaban_fk1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_jawaban_fk2` FOREIGN KEY (`jawaban_id`) REFERENCES `jawaban` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
