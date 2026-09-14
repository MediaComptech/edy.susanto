-- Skema Database Sistem Website & Sapa Warga Edy Susanto (No. Urut 2)
-- Calon Kepala Desa Tampirkulon

CREATE DATABASE IF NOT EXISTS `edy_susanto_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `edy_susanto_db`;

-- 1. Tabel Admin
CREATE TABLE IF NOT EXISTS `admin` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `nama` VARCHAR(100) NOT NULL,
  `role` VARCHAR(30) DEFAULT 'admin',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Tabel Program Unggulan
CREATE TABLE IF NOT EXISTS `program` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `judul` VARCHAR(150) NOT NULL,
  `slug` VARCHAR(150) NOT NULL UNIQUE,
  `kategori` VARCHAR(50) NOT NULL,
  `deskripsi_singkat` TEXT NOT NULL,
  `deskripsi_lengkap` LONGTEXT NOT NULL,
  `icon` VARCHAR(50) NOT NULL,
  `badge_color` VARCHAR(50) NOT NULL,
  `target_capaian` TEXT DEFAULT NULL,
  `urutan` INT DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Tabel Aspirasi Warga (Fitur Utama Sapa Warga)
CREATE TABLE IF NOT EXISTS `aspirasi` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `kode_tiket` VARCHAR(30) NOT NULL UNIQUE,
  `nama_warga` VARCHAR(120) NOT NULL,
  `dusun` VARCHAR(80) NOT NULL,
  `kategori` VARCHAR(60) NOT NULL,
  `isi_aspirasi` TEXT NOT NULL,
  `foto` VARCHAR(255) DEFAULT NULL,
  `is_anonim` TINYINT(1) DEFAULT 0,
  `status` ENUM('Dalam Proses', 'Selesai', 'Rencana Program', 'Menunggu Review') DEFAULT 'Dalam Proses',
  `tanggapan` TEXT DEFAULT NULL,
  `tanggal_tanggapan` DATETIME DEFAULT NULL,
  `ip_address` VARCHAR(45) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. Tabel Berita & Kegiatan
CREATE TABLE IF NOT EXISTS `berita` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `judul` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `ringkasan` TEXT NOT NULL,
  `konten` LONGTEXT NOT NULL,
  `foto` VARCHAR(255) DEFAULT NULL,
  `kategori` VARCHAR(60) DEFAULT 'Kegiatan',
  `penulis` VARCHAR(100) DEFAULT 'Tim Edy Susanto',
  `dibaca` INT DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. Tabel Galeri & Dokumentasi
CREATE TABLE IF NOT EXISTS `galeri` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `judul` VARCHAR(200) NOT NULL,
  `deskripsi` TEXT DEFAULT NULL,
  `foto` VARCHAR(255) NOT NULL,
  `kategori` VARCHAR(60) DEFAULT 'Dokumentasi',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 6. Tabel Notifikasi PWA & Broadcast
CREATE TABLE IF NOT EXISTS `notifikasi` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `judul` VARCHAR(200) NOT NULL,
  `pesan` TEXT NOT NULL,
  `url` VARCHAR(255) DEFAULT NULL,
  `tipe` VARCHAR(50) DEFAULT 'broadcast',
  `is_sent` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 7. Tabel Pelanggan Push Notification PWA
CREATE TABLE IF NOT EXISTS `pwa_subscribers` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `endpoint` TEXT NOT NULL,
  `auth_token` VARCHAR(255) DEFAULT NULL,
  `p256dh_token` VARCHAR(255) DEFAULT NULL,
  `user_agent` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- DATA SEED AWAL
-- =============================================

-- Akun Admin Default: admin / admin123
INSERT INTO `admin` (`username`, `password`, `nama`, `role`) VALUES
('admin', '$2y$10$eEskGf7F.j64yQyTfV4QxuvGf3a4G7m4X/5XoG0HkU6w.fJ41X4.e', 'Administrator Tampirkulon', 'admin')
ON DUPLICATE KEY UPDATE `id`=`id`;

-- 7 Program Unggulan
INSERT INTO `program` (`judul`, `slug`, `kategori`, `deskripsi_singkat`, `deskripsi_lengkap`, `icon`, `badge_color`, `target_capaian`, `urutan`) VALUES
('Pertanian', 'pertanian', 'Ekonomi', 'Petani sejahtera, desa berdaya.', 'Subsidi pupuk tepat sasaran, revitalisasi saluran irigasi teknis di setiap dusun, dan fasilitasi alsintan modern untuk meningkatkan hasil panen dan pendapatan petani Tampirkulon.', 'bi-flower2', '#198754', 'Peningkatan produktivitas hasil tani hingga 25% dan kepastian suplai pupuk merata.', 1),
('UMKM & Ekonomi', 'umkm-ekonomi', 'Ekonomi', 'Produk lokal naik kelas, peluang lebih luas.', 'Bantuan permodalan mikro tanpa agunan berat, pendampingan legalitas NIB & sertifikasi halal, digital marketing, serta etalase produk unggulan desa Tampirkulon.', 'bi-shop', '#fd7e14', 'Minimal 50 pelaku usaha kecil memiliki izin usaha legal dan akses pemasaran digital.', 2),
('Wisata Desa', 'wisata-desa', 'Pariwisata', 'Potensi wisata, kebanggaan bersama.', 'Pengembangan Wisata Tubing Tampirkulon, penataan fasilitas penunjang, homestay warga berbasis komunitas, dan integrasi paket wisata edukasi alam.', 'bi-water', '#0d6efd', 'Wisata Tubing menjadi destinasi favorit Magelang dengan perputaran ekonomi langsung ke warga.', 3),
('Pendidikan', 'pendidikan', 'Sosial', 'Generasi cerdas, masa depan kuat.', 'Beasiswa siswa berprestasi dan kurang mampu dari keluarga pra-sejahtera, revitalisasi perpustakaan desa, serta pelatihan keterampilan kerja generasi muda.', 'bi-mortarboard-fill', '#6f42c1', 'Nol anak putus sekolah di Tampirkulon dan ketersediaan pojok literasi tiap dusun.', 4),
('Pemuda & Olahraga', 'pemuda-olahraga', 'Kepemudaan', 'Pemuda aktif, desa lebih kreatif.', 'Revitalisasi lapangan dan sarana olahraga serbaguna, pembinaan karang taruna, turnamen antar-dusun tahunan, serta wadah inkubasi kreativitas konten digital.', 'bi-activity', '#dc3545', 'Aktifnya karang taruna di seluruh dusun dengan turnamen rutin dan ruang kreasi mandiri.', 5),
('Lingkungan', 'lingkungan', 'Lingkungan', 'Desa bersih, hijau dan lestari.', 'Sistem pengelolaan sampah terpadu (TPS 3R), bank sampah dusun, program penanaman pohon buah pelindung mata air, dan sanitasi sehat warga.', 'bi-tree-fill', '#20c997', 'Pengentasan titik sampah liar dan terwujudnya 1 dusun 1 bank sampah produktif.', 6),
('Pelayanan Desa', 'pelayanan-desa', 'Pemerintahan', 'Mudah, cepat, dan transparan.', 'Digitalisasi administrasi surat-menyurat, layanan jemput bola untuk lansia dan disabilitas, transparansi APBDes, serta respon cepat kanal Sapa Warga.', 'bi-file-earmark-text-fill', '#e63946', 'Pengurusan surat desa selesai dalam 1 hari kerja dan keterbukaan anggaran dana desa.', 7)
ON DUPLICATE KEY UPDATE `id`=`id`;

-- Aspirasi Warga Awal (Sesuai statistik mockup: 124 Total, 32 Proses, 87 Selesai, 5 Rencana)
INSERT INTO `aspirasi` (`kode_tiket`, `nama_warga`, `dusun`, `kategori`, `isi_aspirasi`, `foto`, `is_anonim`, `status`, `tanggapan`, `tanggal_tanggapan`, `created_at`) VALUES
('ASP-20260612-001', 'Warga Krajan', 'Dusun Krajan', 'Infrastruktur', 'Perbaikan Jalan Dusun Krajan yang berlubang di RT 03 / RW 01 menuju area persawahan, mohon segera diratakan agar aman saat musim hujan.', NULL, 1, 'Dalam Proses', 'Terima kasih atas masukannya. Tim survei fisik sudah turun ke lokasi Dusun Krajan dan perbaikan masuk dalam prioritas kerja secepatnya.', '2026-06-12 14:20:00', '2026-06-12 09:30:00'),
('ASP-20260610-002', 'Budi Santoso', 'Dusun Tampir Kulon', 'Lingkungan', 'Pengelolaan Sampah: Usulan pengadaan bak sampah terpadu di setiap sudut gang dusun agar warga tidak membuang sampah ke aliran sungai.', NULL, 0, 'Selesai', 'Alhamdulillah pengadaan tempat sampah organik dan anorganik telah didistribusikan ke koordinator RT setempat.', '2026-06-11 10:15:00', '2026-06-10 16:45:00'),
('ASP-20260609-003', 'Siti Rahmawati', 'Dusun Pandean', 'Ekonomi', 'Pelatihan UMKM: Mohon ada pelatihan pemasaran online untuk ibu-ibu perajin makanan ringan dan kerajinan tangan di Pandean.', NULL, 0, 'Dalam Proses', 'Usulan telah diagendakan. Pelatihan batch 1 bersama instruktur e-commerce akan dijadwalkan bulan depan di balai serbaguna.', '2026-06-10 08:30:00', '2026-06-09 11:20:00'),
('ASP-20260608-004', 'Ahmad Fauzi', 'Dusun Krajan', 'Pelayanan', 'Kemudahan pengurusan surat pengantar secara online lewat WhatsApp agar warga yang bekerja di luar desa tidak perlu izin libur kerja.', NULL, 0, 'Rencana Program', 'Sangat disetujui! Ini menjadi salah satu program unggulan Digitalisasi Pelayanan Desa Pak Edy Susanto.', '2026-06-09 15:00:00', '2026-06-08 13:10:00')
ON DUPLICATE KEY UPDATE `id`=`id`;

-- Berita & Kegiatan
INSERT INTO `berita` (`judul`, `slug`, `ringkasan`, `konten`, `foto`, `kategori`, `penulis`, `dibaca`, `created_at`) VALUES
('Silaturahmi & Dialog Terbuka Bersama Warga Dusun Krajan', 'silaturahmi-dialog-terbuka-warga-krajan', 'Calon Kepala Desa Edy Susanto menggelar temu wicara mendengarkan langsung aspirasi petani dan tokoh masyarakat Dusun Krajan.', '<p>Bertempat di pendopo warga Dusun Krajan, Calon Kepala Desa Tampirkulon No. Urut 2, <strong>Edy Susanto</strong>, bersilaturahmi dengan puluhan warga, tokoh agama, serta perwakilan pemuda.</p><p>Dalam dialog yang berlangsung guyub dan hangat ini, Pak Edy menegaskan komitmennya untuk mengedepankan prinsip gotong royong dan pelayanan transparan. "Desa kuat karena warganya. Pemimpin adalah pelayan yang harus siap mendengar dan mencari solusi nyata bersama," tegasnya.</p>', 'assets/images/banner/dialog_warga.jpg', 'Kegiatan', 'Tim Media Edy Susanto', 142, '2026-06-11 19:30:00'),
('Eksplorasi Potensi Wisata Tubing Tampirkulon Menuju Destinasi Unggulan', 'eksplorasi-potensi-wisata-tubing-tampirkulon', 'Wisata Tubing Tampirkulon menyimpan potensi besar untuk menggerakkan perekonomian warga dan membuka lapangan kerja pemuda.', '<p>Aliran sungai yang jernih dan asri di Desa Tampirkulon memiliki daya tarik wisata air yang luar biasa. Program kerja No. 2 menargetkan penguatan fasilitas keselamatan, sertifikasi pemandu wisata lokal, dan promosi digital terpadu agar Wisata Tubing Tampirkulon mampu menarik wisatawan lintas daerah.</p>', 'assets/images/galeri/wisata_tubing.jpg', 'Potensi', 'Tim Media Edy Susanto', 215, '2026-06-10 10:00:00')
ON DUPLICATE KEY UPDATE `id`=`id`;

-- Galeri
INSERT INTO `galeri` (`judul`, `deskripsi`, `foto`, `kategori`) VALUES
('Wisata Tubing Tampirkulon', 'Salah satu potensi unggulan desa yang siap dikembangkan', 'assets/images/galeri/wisata_tubing.jpg', 'Wisata'),
('Dialog Gayub Warga', 'Silaturahmi santai mendengar aspirasi warga Tampirkulon', 'assets/images/banner/dialog_warga.jpg', 'Kegiatan')
ON DUPLICATE KEY UPDATE `id`=`id`;

-- Notifikasi Awal
INSERT INTO `notifikasi` (`judul`, `pesan`, `url`, `tipe`) VALUES
('Selamat Datang di Sapa Warga Tampirkulon', 'Kanal resmi aspirasi dan dialog bersama Edy Susanto (No. Urut 2). Sampaikan usulan Anda demi kemajuan desa!', 'index.php?page=sapa-warga', 'broadcast')
ON DUPLICATE KEY UPDATE `id`=`id`;


-- 8. Tabel Pengaturan Website & Foto Hero
CREATE TABLE IF NOT EXISTS `pengaturan` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `kunci` VARCHAR(100) NOT NULL UNIQUE,
  `nilai` LONGTEXT DEFAULT NULL,
  `keterangan` VARCHAR(255) DEFAULT NULL,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `pengaturan` (`kunci`, `nilai`, `keterangan`) VALUES
('foto_hero', 'assets/images/banner/edy_susanto_hero_clean.jpg', 'Foto utama kandidat di Hero Section Beranda'),
('nama_calon', 'EDY SUSANTO', 'Nama lengkap kandidat'),
('no_urut', '2', 'Nomor urut calon kepala desa'),
('tagline', 'Bersama Membangun Desa yang Asri, Maju & Rukun', 'Tagline kampanye'),
('slogan_quote', 'Desa kuat karena warganya.', 'Kutipan singkat calon')
ON DUPLICATE KEY UPDATE `nilai`=VALUES(`nilai`);
