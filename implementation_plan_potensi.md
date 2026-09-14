# Rencana Implementasi: Redesain Halaman Potensi Desa Sesuai Mockup UI & Data Fakta

Dokumen ini berisi rencana teknis dan desain komprehensif untuk merombak total halaman **Potensi Desa (`pages/potensi.php`)** berdasarkan data faktual pada [update_potensi.md](file:///c:/xampp/htdocs/edy_susanto/update_potensi.md) dan desain visual pada [UI/Potensi/ngudal 2.png](file:///c:/xampp/htdocs/edy_susanto/UI/Potensi/ngudal%202.png) (Desktop) serta [UI/Potensi/ngudal mobile.png](file:///c:/xampp/htdocs/edy_susanto/UI/Potensi/ngudal%20mobile.png) (Mobile).

---

## User Review Required

> [!IMPORTANT]
> **Peta Interaktif Potensi Desa (Section 4)**:
> Agar interaktif dan dapat diklik secara nyata oleh pengunjung tanpa memerlukan API Key berbayar, kita akan menggunakan **Leaflet.js (OpenStreetMap)** yang ringan, open-source, dan presisi dengan koordinat wilayah Tampirkulon, Candimulyo, Kab. Magelang (dilengkapi pin marker kustom berwarna sesuai kategori: Mata Air, Wisata, Pertanian, UMKM, Budaya, Kuliner).
> 
> Apakah Anda menyetujui penggunaan Leaflet.js ini atau memiliki preferensi Google Maps Embed? *(Rekomendasi: Leaflet.js agar filter kategori berfungsi dinamis).*

> [!NOTE]
> **Koleksi Aset Foto**:
> Kita akan melengkapi foto-foto potensi lokal berkualitas tinggi yang natural dan proporsional untuk:
> 1. Kolam Ngudal Tuk Putri (Spot Unggulan)
> 2. Mata Air Tuk Lanang
> 3. Wisata Tubing Tampirkulon
> 4. Pertanian & Lanskap Tampirkulon
> 5. UMKM Keripik Tempe / Olahan Warga
> 6. Kesenian Tradisional Jathilan Krido Budoyo
> 7. Kuliner Lokal Kupat Tahu Mbah Kenuk

---

## Analisis Desain & Penyelarasan Template Warna

Sesuai permintaan Anda untuk **menyesuaikan dengan template warna yang sekarang digunakan** di website Edy Susanto:
- **Warna Utama Identitas**:
  - Hijau Asri Desa: `#2e7d32` / `#1b5e20` (untuk badge alam, tombol peta, accent bar, ikon alam & pertanian)
  - Merah Kampanye: `#b71c1c` / `#d32f2f` (untuk tombol primer *"Jelajahi Potensi"*, identitas No. Urut 2)
  - Nuansa Oranye Rukun: `#ef6c00` / `#fff3e0` (untuk kuliner & potensi kebersamaan)
  - Soft Pastel Card Backgrounds:
    - Mata Air: `#e3f2fd` (biru air alami)
    - Wisata: `#e8f5e9` (hijau wisata)
    - Pertanian: `#fff8e1` (kuning keemasan tani)
    - UMKM: `#ffebee` (merah muda usaha)
    - Seni Budaya: `#f3e5f5` (ungu seni)
    - Kuliner: `#fff3e0` (oranye kuliner)
- **Tipografi & Spacing**:
  - Menggunakan font resmi `Plus Jakarta Sans`
  - Konsistensi `.container-custom` (max-width 1440px)
  - Spacing section proporsional (`py-4 py-md-5`), tanpa tumpukan margin/padding negatif yang dapat menyebabkan elemen saling bertumpuk di layar kecil.
- **Keamanan (Security)**:
  - Sanitasi output menggunakan fungsi helper `e()` (mencegah XSS).
  - Validasi koordinat dan data ID pada modal.
  - Atribut keamanan `rel="noopener noreferrer"` pada semua tautan luar (Maps, WhatsApp).

---

## Struktur 6 Section Halaman Potensi Desa

Sesuai mockup `ngudal 2.png` & `ngudal mobile.png`:

```
┌─────────────────────────────────────────────────────────────┐
│ 1. HERO SECTION: "Kekayaan Desa, Kekuatan Bersama"          │
│    - Foto Lanskap Air/Alam + Gradient Overlay Ramah Teks    │
│    - Badge Hijau, Judul, Subjudul, Tombol CTA Ganda         │
│    - Floating Badge Lokasi: "Kolam Ngudal Tuk Putri"        │
├─────────────────────────────────────────────────────────────┤
│ 2. ENAM POTENSI UTAMA DESA TAMPIRKULON                      │
│    - 6 Kartu Berwarna: Mata Air, Wisata, Tani, UMKM,        │
│      Seni Budaya, Kuliner                                   │
│    - Tombol "Lihat Detail" memicu Modal Informasi Faktual   │
├─────────────────────────────────────────────────────────────┤
│ 3. SPOT UNGGULAN: KOLAM NGUDAL TUK PUTRI                    │
│    - Kiri: Foto Besar Tuk Putri + Badge "Lihat Video"       │
│    - Kanan: Detail Faktual Jarak (±0,34 km dari Balai Desa),│
│      Deskripsi Pelestarian, Tombol "Lihat di Peta" & Galeri │
├─────────────────────────────────────────────────────────────┤
│ 4. PETA POTENSI DESA (INTERAKTIF)                           │
│    - Kiri: Filter Radio Kategori (Semua, Air, Wisata, dll)  │
│    - Tengah: Peta Interaktif Leaflet dengan Custom Pin      │
│    - Kanan: Daftar 5 Lokasi Populer & Jarak Tempuh          │
├─────────────────────────────────────────────────────────────┤
│ 5. GALERI POTENSI DESA                                      │
│    - 6 Kartu Album Berfoto dengan Label Jumlah Dokumentasi  │
│    - Interaksi Lightbox Modal untuk Melihat Foto Penuh      │
├─────────────────────────────────────────────────────────────┤
│ 6. BANNER CTA SAPA WARGA: "PUNYA INFORMASI POTENSI DESA?"   │
│    - Banner Compact Berlatar Lanskap                        │
│    - Ajakan Partisipasi Warga untuk Mendaftarkan Potensi    │
│    - Tombol "Sampaikan Melalui Sapa Warga"                  │
└─────────────────────────────────────────────────────────────┘
```

---

## Proposed Changes

### 1. Halaman Publik Potensi Desa
#### [MODIFY] [pages/potensi.php](file:///c:/xampp/htdocs/edy_susanto/pages/potensi.php)
- Menghapus tampilan lama yang belum lengkap.
- Mengimplementasikan struktur 6 section lengkap sesuai mockup `ngudal 2.png` & `ngudal mobile.png`.
- Menyiapkan array `$potensiData`, `$spotUnggulan`, `$petaLokasi`, dan `$galeriPotensi` berbasis fakta dari [update_potensi.md](file:///c:/xampp/htdocs/edy_susanto/update_potensi.md):
  - **Tuk Putri & Tuk Lanang**: Data jarak resmi 0,34 km dan 0,33 km dari Balai Desa.
  - **Wisata Tubing Candimulyo**: Aliran sungai Tampirkulon, dukungan Pokdarwis 2026.
  - **UMKM Olahan Tempe**: Tempe Kripik Bu Tatik & Keripik Tempe Pak Budi Mbok Tiwul.
  - **Kesenian**: Jathilan Krido Budoyo Tampirkulon.
  - **Kuliner**: Warung Makan Kupat Tahu Mbah Kenuk.
- Menambahkan Modal Detail untuk masing-masing potensi (Kondisi Faktual, Peluang Pengembangan, dan Lokasi).
- Menambahkan Modal Video/Galeri untuk Kolam Ngudal Tuk Putri.

### 2. Styling CSS Modular & Responsif
#### [MODIFY] [assets/css/style.css](file:///c:/xampp/htdocs/edy_susanto/assets/css/style.css)
- Menambahkan blok CSS khusus namespace `.potensi-*`:
  - `.potensi-hero-card`: Desain kartu bounded berlatar alam, border halus, teks kontras.
  - `.potensi-grid-6`: Grid 6 kolom fleksibel (6 desktop, 3 tablet, 2 mobile).
  - `.potensi-card`: Hover effect halus, border pastel selaras icon.
  - `.potensi-spot-card`: Layout 2 kolom foto + deskripsi terukur.
  - `.potensi-map-wrap`: Kontainer peta dengan radius 16px dan kontrol responsif.
  - `.potensi-gallery-card`: Rasio aspek 16:10 dengan overlay gradien dan label jumlah foto.
  - `.potensi-cta-card`: Banner CTA modern compact selaras warna tema.
- Breakpoints media queries khusus mobile (< 768px) dan tablet (< 992px) untuk memastikan nol tumpukan elemen.

### 3. Aset Gambar Potensi
#### [NEW] Aset Gambar di `assets/images/potensi/`
- Memastikan aset gambar untuk Tuk Putri, Tuk Lanang, Tubing, Pertanian, UMKM, Jathilan, dan Kuliner Kupat Tahu tersimpan dengan resolusi tajam, rasio proporsional, dan ukuran optimal (< 200KB per foto) agar loading cepat.

---

## Verification Plan

### Manual Verification
1. **Desktop View (1440px & 1200px)**:
   - Verifikasi keselarasan visual dengan `UI/Potensi/ngudal 2.png`.
   - Cek fungsi filter peta interaktif saat memilih kategori (Air, Wisata, UMKM, dll).
   - Cek klik popup marker peta dan kartu lokasi populer di sisi kanan.
   - Cek modal detail potensi saat tombol *"Lihat Detail"* diklik.
2. **Mobile View (375px & 412px)**:
   - Verifikasi keselarasan visual dengan `UI/Potensi/ngudal mobile.png`.
   - Pastikan grid 6 potensi tersusun rapi 2 kolom atau kartu geser tanpa terpotong.
   - Pastikan teks judul tidak bertumpuk dengan badge floating.
   - Pastikan tombol CTA dan banner Sapa Warga proporsional dengan bottom navigation.
3. **Validasi Sintaks & Keamanan**:
   - Menjalankan `php -l pages/potensi.php` untuk memastikan 0 syntax error.
   - Memastikan semua variabel di-escape dengan `e()`.
