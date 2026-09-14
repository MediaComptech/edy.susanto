# Walkthrough: Implementasi Website & Sapa Warga Calon Kades Tampirkulon (Edy Susanto - No. Urut 2)

Implementasi website resmi dan modul **Sapa Warga** terintegrasi telah selesai dibangun secara menyeluruh sesuai dengan rancangan UI mockups pada `UI/1.png`, arsitektur folder pada `UI/struktur.png`, panduan pada `plan1_create.md`, serta penambahan modul **PWA Notifikasi Terintegrasi** sesuai permintaan.

---

## 1. Ringkasan Hasil Pengerjaan

### A. Struktur Folder & Berkas (100% Sesuai Spesifikasi)
```text
edy_susanto/
├── assets/
│   ├── css/
│   │   └── style.css            # Desain kustom responsif, warna kampanye merah-putih, tema modern
│   ├── js/
│   │   └── main.js              # PWA service worker registrasi, filter aspirasi, pencarian & upload preview
│   └── images/
│       ├── logo/                # Logo No. Urut 2 beresolusi tinggi & avatar calon
│       ├── banner/              # Foto hero Pak Edy Susanto, silaturahmi warga & banner Sapa Warga
│       ├── program/             # Aset program kerja
│       ├── galeri/              # Foto Wisata Tubing Tampirkulon & kegiatan silaturahmi
│       └── icons/               # PWA App Icons (192x192 & 512x512 maskable)
├── includes/
│   ├── config.php               # Konfigurasi database PDO XAMPP & auto-migration skema
│   ├── functions.php            # Security sanitasi, CSRF token, htmlspecialchars, upload & format tanggal ID
│   ├── header.php               # Meta tags SEO, PWA manifest, font Plus Jakarta Sans & Bootstrap 5
│   ├── navbar.php               # Navigasi utama, logo No. 2, tombol Sampaikan Aspirasi & modal search
│   ├── footer.php               # Brand tagline, kontak Candimulyo Magelang, link WhatsApp & copyright
│   └── bottom-nav.php           # Mobile app-style bottom navigation bar (< 768px)
├── pages/
│   ├── beranda.php              # Hero, 3 pilar (Asri, Maju, Rukun), Tubing, 7 Program, & Banner Sapa Warga
│   ├── profil.php               # Biodata Edy Susanto, nilai kepemimpinan, dan visi-misi desa
│   ├── program.php              # Rincian 7 Program Unggulan strategis beserta target capaian
│   ├── potensi.php              # Potensi desa (Wisata Tubing, pertanian, UMKM & gotong royong)
│   ├── sapa-warga.php           # Hub interaktif aspirasi: formulir kirim, counter statistik & feed publik
│   ├── berita.php               # Kabar terkini kegiatan kampanye & galeri dokumentasi
│   └── kontak.php               # Informasi posko pemenangan, kontak WhatsApp & form pesan
├── admin/
│   ├── index.php                # Dashboard admin, ringkasan statistik & form siaran notifikasi PWA
│   ├── login.php                # Autentikasi admin aman (CSRF protected & password_verify)
│   ├── logout.php               # Terminasi sesi admin
│   ├── header_admin.php         # Layout sidebar bersama admin
│   ├── footer_admin.php         # Layout footer admin
│   ├── data_program.php         # CRUD 7 Program Unggulan
│   ├── data_berita.php          # CRUD Berita & Kegiatan beserta upload foto
│   ├── data_galeri.php          # CRUD Foto Galeri & Dokumentasi
│   └── data_aspirasi.php        # Moderasi & tindak lanjut aspirasi (Dalam Proses, Selesai, Rencana)
├── uploads/                     # Direktori upload foto warga & berita
├── manifest.json                # Web App Manifest PWA (dapat diinstall di smartphone/desktop)
├── service-worker.js            # Service worker caching offline & push notification
├── .htaccess                    # Proteksi file tersembunyi, nonaktifkan directory listing, security headers
├── index.php                    # Front Controller terpusat dengan routing whitelist aman
└── database.sql                 # Skema database MySQL lengkap beserta data awal kampanye
```

---

## 2. Fitur Utama yang Telah Diimplementasikan

### 1. Antarmuka Publik Sesuai Mockup UI (`UI/1.png`)
- **Header & Navbar**: Logo lingkaran merah No. Urut 2, nama "EDY SUSANTO", menu lengkap, pill Sapa Warga, tombol merah "Sampaikan Aspirasi", dan tombol modal pencarian cepat.
- **Hero Section**: Tagline "Calon Kepala Desa Tampirkulon", foto Pak Edy Susanto (kacamata/jas/dasi merah), kutipan balon *"Desa kuat karena warganya"*, 3 pilar mini (**Asri**, **Maju**, **Rukun**), tombol *"Kenali Saya"* & *"Lihat Program Kerja"*, serta pill terapung *"Sapa Warga - Mari berdialog, dengar, dan cari solusi bersama"*.
- **Quick Navigation 6 Bar**: Navigasi pintas dengan ikon modern (Profil Calon, Program Kerja, Potensi Desa, Sapa Warga [aktif merah], Berita & Kegiatan, Dokumentasi).
- **Tampirkulon yang Kita Kenal**: 3 kartu pilar (Asri, Maju, Rukun) dan kartu unggulan **Wisata Tubing Tampirkulon** dengan visual asli dari mockup.
- **7 Program Unggulan**: Pertanian, UMKM & Ekonomi, Wisata Desa, Pendidikan, Pemuda & Olahraga, Lingkungan, dan Pelayanan Desa dengan kode warna dan ikon unik.
- **Banner CTA Sapa Warga**: Banner komunikasi warga dengan foto silaturahmi asli dan tombol *"Mulai Sapa Warga"*.
- **Mobile Bottom Navigation Bar**: Tampilan mobile menyertakan bottom bar mengambang khusus smartphone (Beranda, Program, Sapa Warga [tombol tengah menonjol], Berita, Profil).

### 2. Modul Interaktif Sapa Warga
- **Formulir Aspirasi Warga**:
  - Input Nama Lengkap, Dropdown Pilihan Dusun (Krajan, Tampir Kulon, Pandean, Karanganyar, Gatak).
  - Radio Kategori (Infrastruktur, Ekonomi, Pendidikan, Lingkungan, Pemuda, Pelayanan, Lainnya).
  - Textarea Aspirasi dengan validasi karakter.
  - Upload Foto opsional (validasi ekstensi dan MIME type, maks 5MB, dengan pratinjau instan).
  - Opsi *"Tampilkan secara anonim"*.
  - Generator tiket otomatis berformat: `ASP-YYYYMMDD-XXXX`.
- **Counter Statistik Aspirasi Real-Time**:
  - Total Aspirasi: **124**
  - Dalam Proses: **32**
  - Selesai: **87**
  - Rencana Program: **5**
- **Feed Aspirasi Publik**:
  - Menampilkan aspirasi warga dengan filter status (*Dalam Proses*, *Selesai*, *Rencana Program*).
  - Label dusun, tanggal posting dalam format bahasa Indonesia, dan tanggapan resmi tim.
- **Sub-Tabs Lengkap**:
  - Sampaikan Aspirasi, Diskusi Warga, Polling & Usulan, Agenda Pertemuan, FAQ, dan Peta Sebaran Aspirasi.

### 3. Modul PWA & Notifikasi Terintegrasi
- **Manifest & Service Worker**: `manifest.json` dan `service-worker.js` memungkinkan website diinstal sebagai aplikasi mandiri (*standalone app*) di Android, iOS, maupun Desktop.
- **Banner Instalasi Otomatis**: Muncul toast *"Pasang Aplikasi Sapa Warga"* saat diakses lewat perangkat mobile/browser.
- **Web & Push Notification**:
  - Tombol *"Aktifkan Notifikasi Desa"* di halaman depan untuk meminta izin notifikasi browser.
  - Form di Dashboard Admin untuk menyiarkan pesan/kabar desa langsung ke ponsel warga (*PWA Broadcast*).
  - Otomatis membuat notifikasi saat ada aspirasi baru atau perubahan status aspirasi.

### 4. Panel Manajemen Konten & Admin (`admin/`)
- Akses login: `http://localhost:81/edy_susanto/admin/login.php`
  - **Username**: `admin`
  - **Password**: `admin123`
- **Dashboard**: Ringkasan jumlah data dan formulir broadcast notifikasi PWA ke warga.
- **Kelola Aspirasi**: Tinjau aspirasi masuk, ubah status (Dalam Proses, Selesai, Rencana), berikan tanggapan resmi yang langsung muncul di feed publik, atau hapus aspirasi.
- **Kelola 7 Program**: Tambah, ubah ikon/warna, perbarui target capaian, atau urutan program.
- **Kelola Berita & Kegiatan**: Terbitkan artikel kegiatan kampanye dengan unggah foto.
- **Kelola Galeri**: Tambah dan kelola arsip dokumentasi silaturahmi warga.

### 5. Standar Keamanan & Kualitas Kode
- **Anti SQL Injection**: 100% menggunakan PDO Prepared Statements dengan parameter binding.
- **Anti XSS**: Seluruh output dinamis dieksekusi melalui helper `e()` (`htmlspecialchars` dengan UTF-8).
- **Anti CSRF**: Setiap formulir POST dilindungi dengan token CSRF unik per sesi.
- **Keamanan Upload**: Validasi ukuran (maks 5MB), MIME type whitelist (JPG, PNG, WEBP), serta penamaan acak unik (*hash filename*).
- **Proteksi Server**: Konfigurasi `.htaccess` menonaktifkan directory browsing dan melarang akses langsung ke file sensitif (`.sql`, `.env`, `.git`).

---

## 3. Hasil Verifikasi & Pengujian Sistem

1. **Linting / Syntax Check**:
   - Seluruh 23 file PHP diuji dengan `php.exe -l`: **0 Syntax Error**.
2. **HTTP Endpoints (Apache Port 81)**:
   - `http://localhost:81/edy_susanto/index.php?page=beranda` -> **200 OK**
   - `http://localhost:81/edy_susanto/index.php?page=profil` -> **200 OK**
   - `http://localhost:81/edy_susanto/index.php?page=program` -> **200 OK**
   - `http://localhost:81/edy_susanto/index.php?page=potensi` -> **200 OK**
   - `http://localhost:81/edy_susanto/index.php?page=sapa-warga` -> **200 OK**
   - `http://localhost:81/edy_susanto/index.php?page=berita` -> **200 OK**
   - `http://localhost:81/edy_susanto/index.php?page=kontak` -> **200 OK**
   - `http://localhost:81/edy_susanto/admin/login.php` -> **200 OK**
3. **Database & Autentikasi**:
   - Skema database `edy_susanto_db` terinisialisasi dengan 7 tabel.
   - Autentikasi admin (`admin` / `admin123`) terverifikasi sukses dengan hashing `password_verify()`.
   - Modul insert aspirasi warga dan pengiriman notifikasi PWA terverifikasi sukses.

---

## 4. Cara Mengakses & Menjalankan

1. **Website Publik**:
   Buka peramban (browser) dan akses:
   [http://localhost:81/edy_susanto/](http://localhost:81/edy_susanto/) atau [http://localhost:81/edy_susanto/index.php?page=sapa-warga](http://localhost:81/edy_susanto/index.php?page=sapa-warga)
2. **Dashboard Administrator**:
   Akses: [http://localhost:81/edy_susanto/admin/login.php](http://localhost:81/edy_susanto/admin/login.php)
   - **Username**: `admin`
   - **Password**: `admin123`
