# Rencana: Hero Section Full-Width Flayer (Sesuai UI Mockup)

## Latar Belakang

Dari analisis UI mockup (`UI/1.png`), **Hero Section** di halaman Beranda seharusnya tampil sebagai **satu flayer/banner penuh** (*full-width, full-bleed*) dengan background panorama alam Tampirkulon — bukan hanya setengah kolom kanan.

Kondisi saat ini: Hero memakai layout 2 kolom Bootstrap standar dengan background putih/gradient. Ini **belum sesuai** dengan mockup yang menunjukkan hero flayer penuh dengan background gambar.

---

## Analisis Mockup (UI/1.png) - Hero Section

Berdasarkan gambar mockup, hero adalah sebuah **flayer/banner penuh** yang memiliki tepat **4 elemen penempatan**:

```
┌─────────────────────────────────────────────────────────────┐
│  BACKGROUND: Foto panorama alam (landscape) + warga         │
│                                                             │
│  [1] TEKS KIRI         [2] FOTO KANDIDAT (Full/Besar)       │
│  • Label Calon Kades       Edy Susanto dengan jas           │
│  • "EDY SUSANTO"           pose formal, ukuran besar        │
│  • No. Urut 2              kiri-tengah hingga ke bawah      │
│  • Slogan handwriting                                       │
│  • Badge Asri/Maju/Rukun                                    │
│  • Tombol Kenali & Program  [3] QUOTE BOX (kanan atas)      │
│                              "Desa kuat karena warganya."   │
│                                                             │
│  [4] SAPA WARGA PILL ──────────────────────────────────►   │
│      (floating bar panjang di bawah, span full width)       │
└─────────────────────────────────────────────────────────────┘
```

### 4 Penempatan Elemen Flayer:

| # | Elemen | Posisi | Keterangan |
|---|--------|--------|------------|
| 1 | **Teks & Aksi** | Kiri-tengah, vertikal center | Nama, no urut, slogan, badge pilar, 2 tombol |
| 2 | **Foto Kandidat** | Tengah-kanan, bottom-aligned | Full-body atau 3/4 body, besar |
| 3 | **Quote Box** | Pojok kanan atas | Kutipan "Desa kuat karena warganya." dengan gaya tulisan tangan |
| 4 | **Sapa Warga Pill** | Bottom full-width | Bar merah memanjang di bawah hero |

---

## Perubahan yang Diperlukan

### 1. Background Hero — Full Bleed Image

Hero section harus menggunakan `background-image` dari foto panorama (gambar yang sudah ada `edy_susanto_hero_clean.jpg` atau generate background baru yang cocok). 

**Strategi**: Generate background panorama alam Tampirkulon menggunakan AI image generator, lalu terapkan sebagai `background-image` dengan `background-size: cover`.

### 2. Layout Hero — Absolute Positioning

Alih-alih Bootstrap 2-kolom, gunakan **positioned layout** agar setiap elemen bisa diletakkan tepat seperti di flayer:
- Hero container: `position: relative; min-height: 520px`  
- Teks: `position: absolute; left: ...`
- Foto: `position: absolute; right: ...` atau `bottom: 0`  
- Quote: `position: absolute; top: ...; right: ...`
- Sapa Warga pill: full-width di bagian bawah hero

### 3. CSS Hero — Baru / Refactor

Refactor `.hero-section` dan child elements agar sesuai desain flayer full-width.

---

## File yang Diubah

### [MODIFY] [beranda.php](file:///c:/xampp/htdocs/edy_susanto/pages/beranda.php)
Ubah struktur HTML hero section dari 2-kolom Bootstrap menjadi layout flayer dengan 4 elemen positioned.

### [MODIFY] [style.css](file:///c:/xampp/htdocs/edy_susanto/assets/css/style.css)
Refactor CSS `.hero-section` beserta semua child class untuk mendukung layout full-bleed flayer.

---

## Keputusan Desain

> [!IMPORTANT]
> **Background Hero**: Gambar hero saat ini (`edy_susanto_hero_clean.jpg`) sudah berisi komposit foto kandidat + landscape. Apakah kita ingin:
> - **(A) Gunakan gambar existing** sebagai full background image → simple, cepat
> - **(B) Pisahkan background landscape** (generate baru) + foto kandidat sebagai elemen terpisah → lebih fleksibel, foto bisa diganti via admin

> [!NOTE]
> Pilihan **B** adalah yang sesuai dengan fitur "ganti foto hero" yang sudah ada di admin panel — foto kandidat bisa diganti secara dinamis dari database.

---

## Rencana Eksekusi

1. **Generate background panorama** — Landscape alam Tampirkulon untuk background hero
2. **Refactor `beranda.php`** — Ubah HTML hero section ke layout flayer
3. **Refactor `style.css`** — CSS baru untuk hero full-bleed
4. **Test responsif** — Pastikan tampil baik di mobile dan desktop

---

## Pertanyaan untuk User

Silakan pilih pendekatan layout hero:

**Pilihan A** — Gunakan gambar `edy_susanto_hero_clean.jpg` yang sudah ada sebagai full background (foto kandidat sudah menyatu dengan background). Lebih cepat diimplementasikan.

**Pilihan B** — Background landscape dipisah dari foto kandidat. Foto kandidat diletakkan sebagai elemen overlay terpisah agar bisa diganti via admin panel. Sesuai fitur "ganti foto hero".

Apakah lanjut implementasi dengan Pilihan B (recommended, sesuai mockup)?
