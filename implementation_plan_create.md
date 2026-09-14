# Rencana Implementasi Website Calon Kepala Desa Tampirkulon (Edy Susanto - No. Urut 2)

Rencana ini disusun berdasarkan analisis mendalam terhadap spesifikasi pada `plan1_create.md` serta kedua referensi visual pada `UI/1.png` (desain antarmuka desktop, mobile, dan halaman Sapa Warga) dan `UI/struktur.png` (arsitektur folder, rekomendasi teknologi, standar keamanan, dan modul admin).

---

## 1. Analisis Kebutuhan & Spesifikasi

Berdasarkan `plan1_create.md` dan data `UI/`:
1. **Model UI & Visual**:
   - Branding kampanye: Merah (#C62828 / #B71C1C) dan Putih dengan aksen Hijau & Emas.
   - Identitas Calon: "EDY SUSANTO", "Calon Kepala Desa Tampirkulon", "No. Urut 2", tagline *"Bersama Membangun Desa yang Asri, Maju & Rukun"*.
   - 3 Pilar Utama: **Asri** (lingkungan hijau/sehat), **Maju** (ekonomi & pelayanan), **Rukun** (gotong royong & persatuan warga).
   - Fitur unggulan **Sapa Warga**: Formulir aspirasi warga, statistik aspirasi real-time, status aspirasi (Dalam Proses, Selesai, Rencana), diskusi, agenda, dan peta aspirasi.
   - Halaman Responsif: Tampilan desktop elegan, tablet yang proporsional, serta mobile view lengkap dengan *Bottom Mobile Navigation Bar* (Beranda, Program, Sapa Warga, Berita, Profil).
2. **Struktur Folder (Sesuai `UI/struktur.png`)**:
   ```text
   edy_susanto/
   ├── assets/
   │   ├── css/
   │   │   └── style.css
   │   ├── js/
   │   │   └── main.js
   │   └── images/
   │       ├── logo/
   │       ├── banner/
   │       ├── program/
   │       └── galeri/
   ├── includes/
   │   ├── config.php
   │   ├── functions.php
   │   ├── header.php
   │   ├── navbar.php
   │   ├── footer.php
   │   └── bottom-nav.php
   ├── pages/
   │   ├── beranda.php
   │   ├── profil.php
   │   ├── program.php
   │   ├── potensi.php
   │   ├── sapa-warga.php
   │   ├── berita.php
   │   └── kontak.php
   ├── admin/
   │   ├── index.php
   │   ├── login.php
   │   ├── logout.php
   │   ├── data_program.php
   │   ├── data_berita.php
   │   ├── data_galeri.php
   │   └── data_aspirasi.php
   ├── .htaccess
   ├── index.php
   └── database.sql
   ```
3. **Standar Keamanan & Kode**:
   - Arsitektur modular DRY (Don't Repeat Yourself) menggunakan `includes/`.
   - Koneksi database PDO MySQL dengan prepared statement (Anti SQL Injection).
   - Sanitasi input form dan escaping output `htmlspecialchars()` (Anti XSS).
   - Validasi upload file (MIME type whitelist, ekstensi, max 5MB, unique hash filename).
   - Autentikasi sesi admin dengan hashing password `password_hash()` (bcrypt) & CSRF token protection.
   - Konfigurasi `.htaccess` untuk keamanan file tersembunyi, pencegahan directory browsing, dan clean URL routing.
   - Auto-setup database jika database/tabel belum terinisialisasi.

---

## 2. Rincian Komponen & Halaman

### A. Komponen Bersama (`includes/`)
- [NEW] [config.php](file:///c:/xampp/htdocs/edy_susanto/includes/config.php): Konfigurasi database MySQL XAMPP (port 3306, user `root`, pass ``, db `edy_susanto_db`), auto-migration/auto-installer schema jika database belum ada, konstanta aplikasi, dan session start aman.
- [NEW] [functions.php](file:///c:/xampp/htdocs/edy_susanto/includes/functions.php): Helper functions (sanitasi, CSRF helper, alert flash message, upload handler, formatting tanggal Indonesia, pagination helper).
- [NEW] [header.php](file:///c:/xampp/htdocs/edy_susanto/includes/header.php): Meta tags SEO, Bootstrap 5 CSS, Bootstrap Icons, Google Fonts (Plus Jakarta Sans & Inter), custom `style.css`.
- [NEW] [navbar.php](file:///c:/xampp/htdocs/edy_susanto/includes/navbar.php): Logo No. 2 Edy Susanto, navigasi desktop, tombol merah "Sampaikan Aspirasi", tombol pencarian modal, responsive offcanvas.
- [NEW] [footer.php](file:///c:/xampp/htdocs/edy_susanto/includes/footer.php): Brand info, navigasi footer, kontak lengkap (Magelang), tombol integrasi WhatsApp interaktif, copyright 2026, modal aspirasi cepat, dan Bootstrap JS bundle.
- [NEW] [bottom-nav.php](file:///c:/xampp/htdocs/edy_susanto/includes/bottom-nav.php): Mobile app-style bottom navigation bar khusus tampilan mobile (< 768px).

### B. Halaman Publik (`pages/`)
- [NEW] [beranda.php](file:///c:/xampp/htdocs/edy_susanto/pages/beranda.php):
  - Hero section lengkap: Foto Pak Edy Susanto, badge No. Urut 2, slogan, quote bubble *"Desa kuat karena warganya"*, 3 pilar (Asri, Maju, Rukun), tombol Kenali Saya & Program Kerja, banner pill Sapa Warga.
  - Quick action bar (6 modul cepat).
  - Sekilas "Tampirkulon yang Kita Kenal" (3 card pilar + featured card Wisata Tubing Tampirkulon).
  - 7 Program Unggulan (Pertanian, UMKM & Ekonomi, Wisata Desa, Pendidikan, Pemuda & Olahraga, Lingkungan, Pelayanan Desa).
  - CTA Banner "Sapa Warga, Karena Setiap Suara Itu Berarti".
- [NEW] [profil.php](file:///c:/xampp/htdocs/edy_susanto/pages/profil.php): Biodata lengkap Edy Susanto, rekam jejak, visi misi desa Tampirkulon, dan nilai kepemimpinan.
- [NEW] [program.php](file:///c:/xampp/htdocs/edy_susanto/pages/program.php): Rincian 7 program kerja strategis dengan target capaian dan indikator keberhasilan.
- [NEW] [potensi.php](file:///c:/xampp/htdocs/edy_susanto/pages/potensi.php): Potensi desa (Wisata Tubing Tampirkulon, pertanian, UMKM unggulan).
- [NEW] [sapa-warga.php](file:///c:/xampp/htdocs/edy_susanto/pages/sapa-warga.php):
  - Banner header dengan quote Pak Edy Susanto.
  - Sub-tabs: Sampaikan Aspirasi, Diskusi Warga, Polling & Usulan, Agenda Pertemuan, FAQ, Peta Aspirasi.
  - Formulir aspirasi warga (Nama, Dusun, Kategori, Aspirasi, Upload Foto, Anonim checkbox, Validasi CSRF).
  - Counter statistik aspirasi (124 Total, 32 Dalam Proses, 87 Selesai, 5 Rencana).
  - Feed aspirasi publik terkini dengan filter dusun dan status.
- [NEW] [berita.php](file:///c:/xampp/htdocs/edy_susanto/pages/berita.php): Berita, update kegiatan kampanye dan sosialisasi warga Tampirkulon.
- [NEW] [kontak.php](file:///c:/xampp/htdocs/edy_susanto/pages/kontak.php): Peta lokasi, kontak tim pemenangan, form kirim pesan langsung via WhatsApp / email.

### C. Router Utama & Konfigurasi Server
- [NEW] [index.php](file:///c:/xampp/htdocs/edy_susanto/index.php): Front controller yang memuat layout seragam dan merouting ke halaman yang dituju dengan sanitasi whitelist query `?page=...`.
- [NEW] [.htaccess](file:///c:/xampp/htdocs/edy_susanto/.htaccess): Rewrite engine untuk clean URLs, pencegahan akses direktori terlarang, proteksi file database/log, dan security headers.
- [NEW] [database.sql](file:///c:/xampp/htdocs/edy_susanto/database.sql): Skema database lengkap (tabel aspirasi, program, berita, galeri, admin) lengkap dengan data awal realistis.

### D. Panel Admin (`admin/`)
- [NEW] [admin/login.php](file:///c:/xampp/htdocs/edy_susanto/admin/login.php): Form login admin dengan proteksi CSRF & brute-force rate limit sederhana.
- [NEW] [admin/index.php](file:///c:/xampp/htdocs/edy_susanto/admin/index.php): Dashboard admin menampilkan ringkasan data aspirasi, program, berita, dan aktivitas.
- [NEW] [admin/data_aspirasi.php](file:///c:/xampp/htdocs/edy_susanto/admin/data_aspirasi.php): Pengelolaan aspirasi warga (ubah status: Baru, Dalam Proses, Selesai, Tolak; tanggapan admin; hapus/arsip).
- [NEW] [admin/data_program.php](file:///c:/xampp/htdocs/edy_susanto/admin/data_program.php): Manajemen 7 program kerja unggulan (Tambah, Edit, Hapus).
- [NEW] [admin/data_berita.php](file:///c:/xampp/htdocs/edy_susanto/admin/data_berita.php): Manajemen berita dan kegiatan (Tambah dengan upload foto, Edit, Hapus).
- [NEW] [admin/data_galeri.php](file:///c:/xampp/htdocs/edy_susanto/admin/data_galeri.php): Manajemen dokumentasi foto dan video kegiatan warga.
- [NEW] [admin/logout.php](file:///c:/xampp/htdocs/edy_susanto/admin/logout.php): Terminasi sesi aman.

### E. Aset Visual (`assets/`)
- [NEW] [assets/css/style.css](file:///c:/xampp/htdocs/edy_susanto/assets/css/style.css): Custom styling modern, CSS variables (warna kampanye, radius, bayangan), micro-animations, glassmorphism, responsive adjustments, styling mobile bottom nav.
- [NEW] [assets/js/main.js](file:///c:/xampp/htdocs/edy_susanto/assets/js/main.js): Interaktivitas form aspirasi AJAX / instant feedback, filter kategori, toast notification, preview upload foto, copy link, dan smooth scrolling.
- [NEW] Crop dan ekstraksi aset asli dari `UI/1.png` menggunakan PowerShell System.Drawing (foto kandidat Edy Susanto, foto tubing Tampirkulon, foto silaturahmi warga) ke folder `assets/images/`.

---

## 3. Rencana Verifikasi & Pengujian

### A. Pengujian Otomatis & Skrip
1. Syntax check semua file PHP menggunakan CLI:
   `& "C:\xampp\php\php.exe" -l <file.php>` untuk memastikan 0 syntax error.
2. Inisialisasi dan verifikasi database MySQL:
   Eksekusi auto-installer dan periksa tabel `aspirasi`, `program`, `berita`, `admin`, `galeri`.
3. Verifikasi HTTP Endpoint:
   Uji request HTTP ke `http://localhost:81/edy_susanto/` untuk semua halaman (`beranda`, `profil`, `program`, `potensi`, `sapa-warga`, `berita`, `kontak`, dan `admin`).

### B. Pengujian Manual & Visual
1. Buka browser internal subagent / browser test untuk memastikan visual tampilan desktop dan mobile 100% presisi sesuai `UI/1.png`.
2. Uji alur input aspirasi warga dari form publik hingga muncul di dashboard admin `data_aspirasi.php`.
3. Uji responsivitas navigasi mobile dan bottom bar pada viewport ponsel.
