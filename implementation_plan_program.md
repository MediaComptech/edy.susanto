# Implementation Plan: Redesain Halaman Program & Rencana Pengembangan Desa

Dokumen rencana kerja ini disusun berdasarkan analisis mendalam terhadap:
1. **Analisis & Data Faktual**: Dokumen [update_program.md](file:///c:/xampp/htdocs/edy_susanto/update_program.md) (data riil potensi Tampirkulon: Tuk Lanang & Putri, Wisata Tubing, Pokdarwis 2026, UMKM Tempe Bu Tatik & Pak Budi, Jathilan Krido Budoyo, dsb.).
2. **Desain Visual & Layout**: Mockup [UI/Program/program kerja.png](file:///c:/xampp/htdocs/edy_susanto/UI/Program/program%20kerja.png) (Desktop) dan [UI/Program/program kerja mobile.png](file:///c:/xampp/htdocs/edy_susanto/UI/Program/program%20kerja%20mobile.png) (Mobile).
3. **Kesesuaian Brand**: Warna dan estetika template website saat ini (Merah No. Urut 2 `#d32f2f`, Hijau Sapa Warga `#1b5e20`/`#2e7d32`, kartu pastel lembut, modern, bersih, dan aman).

---

## User Review Required

> [!IMPORTANT]
> **Poin Keselarasan Desain:**
> 1. **Struktur 8 Section Penuh**: Halaman Program akan ditingkatkan dari 1 grid sederhana menjadi **8 section komprehensif** yang saling melengkapi (Hero, Quick Stats, 7 Program + Quote Card, Highlight Potensi Desa, Roadmap 4 Tahap, Transparansi Status, Berita Terkait, dan CTA Sapa Warga).
> 2. **Modal Detail Interaktif**: Tombol *"Lihat Detail →"* pada setiap kartu program akan membuka modal popup yang menampilkan detail berbasis fakta riil dari [update_program.md](file:///c:/xampp/htdocs/edy_susanto/update_program.md):
>    - **Kondisi Faktual Saat Ini**
>    - **Potensi & Kebutuhan Nyata**
>    - **Rencana Aksi Konkret**
>    - **Indikator & Target Usulan**
>    - **Status Program** (🟢 Berjalan / 🟡 Persiapan / 🔵 Direncanakan)
>    - **Sumber Data Valid**
> 3. **Palet Warna Harmonis**: Tombol CTA dan aksen utama tetap mengusung identitas nomor urut 2 (Merah `#d32f2f` dan Hijau Kemakmuran `#1b5e20`), sedangkan kartu program menggunakan variasi pastel elegan yang sejuk dipandang mata persis sesuai mockup.

---

## Proposed Changes

### 1. Struktur Halaman Publik (`pages/program.php`)

Mengganti total file [pages/program.php](file:///c:/xampp/htdocs/edy_susanto/pages/program.php) dengan struktur 8 section berstandar tinggi:

#### Section 1: Hero Banner Program Kerja
* **Background**: Foto lanskap alam Tampirkulon beresolusi tinggi dengan overlay gelap lembut agar teks terbaca kontras.
* **Badge**: `PROGRAM KERJA`
* **Headline**: `Bersama Wujudkan Tampirkulon yang Maju, Sejahtera dan Lestari`
* **Deskripsi**: Penjelasan bahwa program disusun berdasarkan data dan potensi nyata desa.
* **Aksi (CTA)**: Tombol `Lihat Program →` (scroll halus ke daftar program) & tombol `Sapa Warga` (link ke `index.php?page=sapa-warga`).
* **Signature Watermark**: Tulisan kaligrafi/handwriting di sisi kanan *"Desa Kuat Warganya Hebat"*.

#### Section 2: Bar Statistik Cepat (4 Pill Cards)
* 4 kartu metrik horizontal (desktop) / 4-kolom kompak (mobile):
  1. `7` Bidang Prioritas
  2. `20+` Rencana Program
  3. `Berdasarkan` Data & Aspirasi
  4. `Untuk Semua` Warga Tampirkulon

#### Section 3: 7 Bidang Program Prioritas + Kartu Quote (8 Cards Grid)
* **Header & Filter Tabs**: Tombol filter kategori (*Semua*, *Ekonomi*, *Pariwisata*, *Sosial*, *Lingkungan*, *Pemerintahan*).
* **Grid 8 Kartu**:
  1. **Pertanian & Ketahanan Pangan** (Mint green pastel, icon leaf)
  2. **UMKM & Ekonomi Lokal** (Warm peach pastel, icon shop)
  3. **Wisata Desa** (Sky blue pastel, icon water/tubing)
  4. **Pendidikan & Literasi** (Lavender pastel, icon graduation/book)
  5. **Pemuda & Olahraga** (Rose pastel, icon people/sports)
  6. **Lingkungan & Sumber Air** (Sage green pastel, icon tree/water)
  7. **Pelayanan Desa** (Amber pastel, icon gear/government)
  8. **Kartu Kutipan Calon**:
     - Ikon quote besar merah
     - Teks: *"Program ini adalah ikhtiar bersama, bukan janji satu orang."*
     - Tanda tangan / signature grafis: `Calon Kepala Desa No. Urut 2`
* **Modal Detail Lengkap**: Setiap kartu dilengkapi tombol *"Lihat Detail →"* yang memunculkan modal popup rapi berisi breakdown kondisi riil, rencana, indikator, target usulan, dan status program.

#### Section 4: Program Berbasis Potensi Tampirkulon
* Layout 2 Kolom (desktop) / Stack vertikal (mobile):
  - **Sisi Kiri (Featured Card)**: Foto lanskap alam Tampirkulon, judul *"Program Berbasis Potensi Tampirkulon"*, deskripsi keterhubungan program dengan aset nyata desa, serta tombol `Lihat Potensi Desa →`.
  - **Sisi Kanan (6 Mini Cards)**:
    1. **Mata Air** (Tuk Lanang & Tuk Putri)
    2. **Wisata Tubing** (Tubing Tampirkulon)
    3. **UMKM Lokal** (Keripik Tempe Bu Tatik & Pak Budi)
    4. **Jathilan** (Krido Budoyo)
    5. **Pertanian** (Hamparan sawah & irigasi)
    6. **Pendidikan** (Fasilitas SD & TK desa)

#### Section 5: Roadmap Pengembangan Desa (Stepper 4 Tahap)
* Tampilan horizontal stepper di desktop dan alur vertikal bergaris di mobile:
  - **Tahap 1: Pendataan (0–6 bulan)**: Database potensi, database UMKM, pemetaan lokasi, baseline indikator.
  - **Tahap 2: Penguatan (6–18 bulan)**: Pendampingan, peningkatan kapasitas, digitalisasi, kolaborasi.
  - **Tahap 3: Pengembangan (18–36 bulan)**: Integrasi wisata, penguatan ekonomi, pemasaran, evaluasi indikator.
  - **Tahap 4: Keberlanjutan (36–60 bulan)**: Evaluasi program, replikasi yang berhasil, penguatan kelembagaan, keberlanjutan pembiayaan.

#### Section 6: Transparansi & Progres
* 4 Kartu metrik status keterbukaan:
  - `5` Program Persiapan (Checkmark hijau)
  - `3` Program Berjalan (Gear biru)
  - `2` Program Direncanakan (Clock oranye)
  - `12` Total Rencana Kegiatan (Bar chart ungu)

#### Section 7: Berita & Kegiatan Terkait Program
* Menampilkan 4 artikel kegiatan terkini yang relevan (misal: Pembentukan Pokdarwis 2026, Normalisasi Sungai & Sumber Air, Pelatihan UMKM, Turnamen Pemuda) diambil langsung dari tabel database `berita`.

#### Section 8: CTA Sapa Warga & Watermark Penutup
* Banner hijau elegan dengan icon Sapa Warga: *"Punya Ide, Saran atau Aspirasi? Sampaikan langsung melalui Sapa Warga..."* + Tombol `Sapa Warga Sekarang →`.
* Watermark footer *"Desa Kuat, Warganya Hebat"* dengan ilustrasi siluet khas.

---

### 2. Styling CSS Modular & Responsif (`assets/css/style.css`)

Menambahkan blok styling khusus dengan namespace `.program-page-*` di [assets/css/style.css](file:///c:/xampp/htdocs/edy_susanto/assets/css/style.css):
* **Bebas Code Bertumpuk**: Menggunakan CSS flexbox dan CSS Grid modern (`gap`, `fr`, `align-items: stretch`) tanpa absolute positioning liar yang berpotensi menabrak elemen lain di mobile.
* **Breakpoint Mobile Eksak**:
  - `@media (max-width: 991.98px)`: Penyesuaian layout 2-kolom ke 1-kolom.
  - `@media (max-width: 767.98px)`: Stepper roadmap beralih ke alur vertikal yang indah dengan garis penghubung.
  - `@media (max-width: 575.98px)`: Penyesuaian hero, kartu 2-kolom rapi, font size proporsional, dan margin/padding aman pada layar smartphone 360px–420px.

---

### 3. Keamanan & Sanitasi Data (Security Best Practices)
* Menggunakan `e()` (`htmlspecialchars()`) pada seluruh data dinamis untuk mencegah XSS.
* Menggunakan query database dengan Prepared Statements `PDO` untuk mencegah SQL Injection.
* Modal detail program menggunakan ID dinamis yang di-sanitize sehingga tidak ada benturan DOM.

---

## Verification Plan

### 1. Uji Tampilan Visual & Fungsionalitas
* Membuka `http://localhost:81/edy_susanto/index.php?page=program`.
* Memeriksa kesesuaian visual dengan gambar referensi [program kerja.png](file:///c:/xampp/htdocs/edy_susanto/UI/Program/program%20kerja.png).
* Menguji klik tombol *"Lihat Detail →"* pada setiap kartu program untuk memastikan modal popup muncul dengan data faktual yang tepat.
* Menguji filter kategori program (*Semua*, *Ekonomi*, *Sosial*, dll.).

### 2. Uji Responsif Mobile
* Memeriksa tampilan di berbagai ukuran layar:
  - Layar Desktop (1200px+)
  - Layar Tablet (768px - 991px)
  - Layar Smartphone (360px - 575px) sesuai acuan [program kerja mobile.png](file:///c:/xampp/htdocs/edy_susanto/UI/Program/program%20kerja%20mobile.png).
* Memastikan tidak ada teks yang bertumpuk, tidak ada horizontal scrollbar yang bocor (*overflow-x*), dan tombol-tombol mudah disentuh (*touch-friendly*).

### 3. Uji Sintaks & Integrasi Hosting
* Menjalankan lint PHP: `php -l pages/program.php`.
* Memastikan kode siap di-push ke GitHub untuk sinkronisasi ke `edy.mediacomptech.com`.
