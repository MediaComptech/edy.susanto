# Walkthrough: Redesain Halaman Potensi Desa Tampirkulon

Implementasi total untuk halaman **Potensi Desa ([pages/potensi.php](file:///c:/xampp/htdocs/edy_susanto/pages/potensi.php))** telah selesai dilaksanakan secara presisi mengikuti desain visual pada mockup **[UI/Potensi/ngudal 2.png](file:///c:/xampp/htdocs/edy_susanto/UI/Potensi/ngudal%202.png)** (Desktop) dan **[UI/Potensi/ngudal mobile.png](file:///c:/xampp/htdocs/edy_susanto/UI/Potensi/ngudal%20mobile.png)** (Mobile), serta memuat data faktual dari **[update_potensi.md](file:///c:/xampp/htdocs/edy_susanto/update_potensi.md)**.

---

## 🎨 Ringkasan Implementasi 6 Section

### 1. Section 1: Hero Banner ("Kekayaan Desa, Kekuatan Bersama")
* **Background & Overlay**: Menggunakan foto lanskap jernih mata air dan pepohonan asri (*Kolam Ngudal Tuk Putri*) dengan gradien hijau-gelap transparan (`linear-gradient(135deg, rgba(13,50,13,0.88)...)`) sehingga teks putih sangat kontras dan mudah dibaca.
* **Badge Kategori**: Badge pill hijau bertuliskan `<i class="bi bi-compass-fill"></i> POTENSI DESA TAMPIRKULON`.
* **Judul & Subjudul**:
  - Judul: *"Kekayaan Desa, Kekuatan Bersama"* (tipografi bold clamp responsif).
  - Subjudul: *"Alam yang lestari, budaya yang hidup, masyarakat yang kreatif &mdash; inilah potensi Desa Tampirkulon yang terus tumbuh untuk masa depan yang lebih baik."*
* **Tombol CTA Ganda**:
  - Tombol Primer Merah: `Jelajahi Potensi` (warna merah kampanye `#b71c1c`, rounded-pill).
  - Tombol Sekunder Outline: `Lihat di Peta` (glassmorphism rounded-pill).
* **Floating Badge Lokasi (Pojok Kanan Bawah)**:
  - Kotak kaca gelap transparan: `📍 Kolam Ngudal Tuk Putri | Tampirkulon, Candimulyo`.

---

### 2. Section 2: Enam Potensi Utama Desa Tampirkulon
* **Tag Accent**: Horizontal accent bar hijau + `POTENSI UNGGULAN`.
* **6 Kartu Berwarna Khusus (Grid 6 Kolom di Desktop, 2 Kolom di Mobile)**:
  1. 💧 **Sumber Mata Air**: Ikon bulat biru `#0288d1` (`bi-droplet-fill`), narasi mata air alami Tuk Putri & Tuk Lanang.
  2. 🌲 **Wisata Desa**: Ikon bulat hijau `#2e7d32` (`bi-tree-fill`), narasi wisata tubing dan Pokdarwis.
  3. 🌾 **Pertanian**: Ikon bulat emas `#f57c00` (`bi-flower1`), narasi persawahan subur dan holtikultura.
  4. 🏪 **UMKM**: Ikon bulat merah `#d32f2f` (`bi-shop`), narasi keripik tempe Bu Tatik & Mbok Tiwul.
  5. 🎭 **Seni & Budaya**: Ikon bulat ungu `#7b1fa2` (`bi-mask`), narasi Jathilan Krido Budoyo.
  6. 🍜 **Kuliner Lokal**: Ikon bulat oranye `#e64a19` (`bi-cup-hot-fill`), narasi Kupat Tahu Mbah Kenuk.
* **Interaktivitas**: Setiap kartu dilengkapi tombol `Lihat Detail ->` yang memicu **Modal Detail Faktual** (Kondisi & Data Faktual, Peluang Kajian Bersama Warga, dan Komitmen Pembangunan).

---

### 3. Section 3: Spot Unggulan (Kolam Ngudal Tuk Putri)
* **Tata Letak 2 Kolom Seimbang**:
  - **Sisi Kiri**: Foto lanskap beresolusi tinggi `Kolam Ngudal Tuk Putri` dengan sudut rounded 16px dan floating badge interaktif `▶ Lihat Video / Info`.
  - **Sisi Kanan**:
    - Tag: `SPOT UNGGULAN`
    - Judul: `Kolam Ngudal Tuk Putri`
    - Deskripsi pelestarian mata air dan kenyamanan rekreasi warga.
    - Meta Info resmi: `📍 Tampirkulon, Candimulyo, Magelang` dan `🧭 ± 0,34 km dari Balai Desa Tampirkulon`.
    - Tombol Tindakan: `Lihat di Peta` (otomatis memusatkan peta ke Tuk Putri) dan `Lihat Galeri` (membuka modal foto).

---

### 4. Section 4: Peta Potensi Desa (Leaflet.js Interaktif)
* **Tata Letak 3 Kolom Responsif**:
  - **Kolom Kiri (Filter Potensi)**: Tombol radio filter interaktif (`Semua`, `Sumber Air`, `Wisata`, `Pertanian`, `UMKM`, `Kuliner`, `Seni & Budaya`, `Pendidikan`). Mengklik kategori otomatis memfilter pin marker di peta secara langsung tanpa reload!
  - **Kolom Tengah (Peta Interaktif Leaflet.js)**:
    - Peta OpenStreetMap terpusat di koordinat Desa Tampirkulon, Candimulyo (`-7.5020, 110.2740`).
    - Pin marker kustom dengan warna dan ikon yang selaras untuk setiap kategori.
    - Popup interaktif saat pin diklik: foto thumbnail, nama lokasi, kategori, jarak, dan tombol *"Buka Petunjuk Arah"* langsung ke Google Maps.
  - **Kolom Kanan (Daftar Lokasi Populer)**:
    - 5 Lokasi populer dengan foto mini dan jarak: Tuk Putri, Tuk Lanang, Tubing Tampirkulon, Jathilan Krido Budoyo, dan Kupat Tahu Mbah Kenuk.
    - Mengklik lokasi pada daftar otomatis menggeser (*smooth pan & zoom*) dan membuka popup lokasi tersebut di peta!

---

### 5. Section 5: Galeri Potensi Desa
* **Dokumentasi Visual 6 Album**:
  - Sumber Mata Air (8 foto)
  - Wisata Tubing (12 foto)
  - Pertanian (10 foto)
  - UMKM (14 foto)
  - Seni & Budaya (9 foto)
  - Kuliner Lokal (11 foto)
* **Interaktivitas**: Setiap album dapat diklik untuk membuka **Modal Lightbox Foto** berukuran besar dengan keterangan dokumentasi.

---

### 6. Section 6: Banner CTA Sapa Warga
* **Banner Partisipasi Warga**:
  - Judul: *"Punya Informasi Potensi Desa?"*
  - Narasi: *"Bantu kami melengkapi data potensi desa. Anda dapat mengirimkan informasi tempat, usaha, budaya, atau potensi lainnya melalui kanal komunikasi langsung Sapa Warga."*
  - Tombol Putih Rounded: `Sampaikan Melalui Sapa Warga` yang mengarah langsung ke formulir aspirasi warga.

---

## 🔒 Keamanan, Konsistensi & Responsivitas

1. **Keamanan (Security)**:
   - Seluruh data teks dan URL dibersihkan menggunakan fungsi escape `e()` untuk proteksi XSS.
   - Tautan eksternal (Google Maps) menggunakan atribut `rel="noopener noreferrer"`.
2. **Konsistensi Warna**:
   - Selaras dengan tema kampanye Edy Susanto: merah primer `#b71c1c`, hijau desa `#2e7d32`, oranye rukun `#ef6c00`, dan pastel card.
   - Menggunakan Bootstrap Icons (`bi-*`) standar.
3. **Responsivitas Multi-Device**:
   - **Desktop (1200px+)**: 6 kartu potensi sejajar, layout peta 3-kolom, spot unggulan 2-kolom.
   - **Tablet (768px - 991px)**: 3x2 kartu potensi, floating badge aman tanpa overlap.
   - **Mobile (< 768px)**: 2x3 kartu potensi presisi, spot card bertumpuk rapi, galeri 2-kolom, peta teroptimasi dengan scroll aman.
4. **PWA Terintegrasi**:
   - Berkas `pages/potensi.php` telah didaftarkan ke Service Worker `sapa-warga-v4` dengan strategi Online-First.

---

## 🧪 Hasil Verifikasi
- **Sintaks PHP**: `php -l pages/potensi.php` &rarr; ✅ **No syntax errors detected**.
- **Rendering Penuh**: Sukses menghasilkan 80.363 bytes HTML lengkap dengan integrasi Leaflet map.
