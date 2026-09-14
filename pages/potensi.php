<?php
/**
 * Halaman Potensi Desa Tampirkulon
 * Calon Kepala Desa Tampirkulon - Edy Susanto (No. Urut 2)
 *
 * Implementasi Presisi Berdasarkan:
 * - Mockup Desain: UI/Potensi/ngudal 2.png (Desktop) & ngudal mobile.png (Mobile)
 * - Data Faktual & Narasi: update_potensi.md
 */

if (!defined('APP_NAME')) {
    require_once __DIR__ . '/../includes/config.php';
}

// Ambil pengaturan dinamis untuk Halaman Potensi dari Database
$fotoHeroPotensi  = get_pengaturan($pdo, 'foto_hero_potensi', 'assets/images/potensi/kolam_ngudal_tuk_putri.jpg');
$heroPotensiJudul = get_pengaturan($pdo, 'hero_potensi_judul', "Kekayaan Desa,<br>Kekuatan Bersama");
$heroPotensiSub   = get_pengaturan($pdo, 'hero_potensi_sub', "Alam yang lestari, budaya yang hidup, masyarakat yang kreatif — inilah potensi Desa Tampirkulon yang terus tumbuh untuk masa depan yang lebih baik.");

$fotoSpotPotensi  = get_pengaturan($pdo, 'foto_spot_potensi', 'assets/images/potensi/kolam_ngudal_tuk_putri.jpg');
$spotPotensiJudul = get_pengaturan($pdo, 'spot_potensi_judul', 'Kolam Ngudal Tuk Putri');
$spotPotensiDesc  = get_pengaturan($pdo, 'spot_potensi_desc', 'Sumber mata air yang menjadi bagian dari potensi alam Desa Tampirkulon. Lokasi ini menjadi salah satu tempat yang dikunjungi masyarakat dan wisatawan untuk menikmati kesegaran air alami di tengah asrinya alam pedesaan.');
$spotPotensiJarak = get_pengaturan($pdo, 'spot_potensi_jarak', '± 0,34 km dari Balai Desa Tampirkulon');
$spotPotensiLokasi= get_pengaturan($pdo, 'spot_potensi_lokasi', 'Tampirkulon, Candimulyo, Magelang');

// Ambil postingan/berita terkait Potensi dari database
$beritaPotensi = [];
try {
    $stmtBerita = $pdo->prepare("SELECT * FROM berita WHERE kategori IN ('Potensi', 'Wisata') ORDER BY created_at DESC LIMIT 3");
    $stmtBerita->execute();
    $beritaPotensi = $stmtBerita->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $beritaPotensi = [];
}

// 1. Data 6 Potensi Utama Desa Tampirkulon
$potensiUtama = [
    [
        'id' => 1,
        'kategori' => 'sumber-air',
        'nama' => 'Sumber Mata Air',
        'deskripsi' => 'Mata air alami yang menjaga kehidupan dan lingkungan desa.',
        'icon' => 'bi-droplet-fill',
        'color' => '#0288d1',
        'bg_color' => '#e1f5fe',
        'ringkasan' => 'Tampirkulon dianugerahi dua mata air legendaris yang jernih dan melimpah: Tuk Putri dan Tuk Lanang.',
        'fakta' => 'Data resmi desa mencatat Mata Air Tuk Putri (± 0,34 km dari Balai Desa) dan Tuk Lanang (± 0,33 km dari Balai Desa). Keduanya menjadi urat nadi irigasi persawahan dan kebutuhan air bersih warga.',
        'peluang' => [
            'Dokumentasi sejarah dan inventarisasi debit air desa.',
            'Penataan sempadan mata air berbasis konservasi alam dan edukasi lingkungan.',
            'Pembersihan rutin dan pengawasan keasrian kawasan bersama pemuda dan warga.'
        ],
        'tujuan' => 'Menjaga kemurnian sumber air alami bagi generasi mendatang sekaligus penopang ketahanan air desa.'
    ],
    [
        'id' => 2,
        'kategori' => 'wisata',
        'nama' => 'Wisata Desa',
        'deskripsi' => 'Wisata tubing, alam dan pengalaman desa yang menarik.',
        'icon' => 'bi-tree-fill',
        'color' => '#2e7d32',
        'bg_color' => '#e8f5e9',
        'ringkasan' => 'Destinasi wisata susur sungai tubing alami yang menghubungkan pesona pedesaan, hamparan sawah, dan keasrian aliran sungai.',
        'fakta' => 'Wisata Tubing Tampirkulon Candimulyo telah tercatat resmi dalam potensi wisata desa. Pada Juli 2026, telah dibentuk penguatan Pokdarwis (Kelompok Sadar Wisata) melibatkan Karang Taruna dan tokoh masyarakat.',
        'peluang' => [
            'Peningkatan standar keselamatan, sertifikasi instruktur, dan kelengkapan pelampung.',
            'Paket wisata edukasi lingkungan terpadu (tubing, petik sayur, kuliner lokal).',
            'Sinergi promosi digital agar menjangkau wisatawan keluarga dari Magelang dan sekitarnya.'
        ],
        'tujuan' => 'Membangun pariwisata berbasis masyarakat yang menggerakkan perekonomian pemuda tanpa merusak alam.'
    ],
    [
        'id' => 3,
        'kategori' => 'pertanian',
        'nama' => 'Pertanian',
        'deskripsi' => 'Lahan produktif dan hasil bumi masyarakat yang melimpah.',
        'icon' => 'fa-solid fa-wheat-awn',
        'color' => '#f57c00',
        'bg_color' => '#fff8e1',
        'ringkasan' => 'Lahan agraris subur yang memproduksi beras kualitas unggul, aneka sayuran holtikultura, dan cabai dengan irigasi mandiri.',
        'fakta' => 'Sebagian besar warga Tampirkulon berprofesi sebagai petani pangan dan holtikultura. Kelompok Tani (Gapoktan) di 6 dusun aktif mengelola sawah subur dengan topografi lereng perbukitan Candimulyo.',
        'peluang' => [
            'Penguatan koordinasi distribusi pupuk bersubsidi dan bantuan bibit unggul.',
            'Pelatihan pembuatan pupuk organik cair buatan lokal untuk efisiensi biaya tani.',
            'Fasilitasi pemasaran hasil tani langsung ke konsumen untuk menstabilkan harga.'
        ],
        'tujuan' => 'Mewujudkan kedaulatan pangan desa, meningkatkan pendapatan keluarga petani, dan menjaga keberlanjutan tanah.'
    ],
    [
        'id' => 4,
        'kategori' => 'umkm',
        'nama' => 'UMKM',
        'deskripsi' => 'Produk lokal yang kreatif dan berdaya saing.',
        'icon' => 'bi-shop',
        'color' => '#d32f2f',
        'bg_color' => '#ffebee',
        'ringkasan' => 'Industri rumahan makanan ringan dan olahan kedelai yang renyah, gurih, dan telah dikenal hingga luar kecamatan.',
        'fakta' => 'Portal resmi desa mencatat UMKM binaan warga seperti Tempe Kripik Bu Tatik dan Keripik Tempe Pak Budi Mbok Tiwul sebagai ikon produk olahan desa.',
        'peluang' => [
            'Bantuan perizinan PIRT, sertifikasi halal, dan desain kemasan modern yang higienis.',
            'Katalogisasi digital di website dan etalase oleh-oleh desa terpadu.',
            'Pelatihan pemasaran online di marketplace dan media sosial.'
        ],
        'tujuan' => 'Mendorong UMKM warga naik kelas, memperluas pasar, dan menyerap tenaga kerja lokal di dusun.'
    ],
    [
        'id' => 5,
        'kategori' => 'budaya',
        'nama' => 'Seni & Budaya',
        'deskripsi' => 'Kesenian tradisional sebagai identitas desa.',
        'icon' => 'bi-mask',
        'color' => '#7b1fa2',
        'bg_color' => '#f3e5f5',
        'ringkasan' => 'Warisan budaya leluhur kesenian tari Jathilan dan karawitan yang terus dijaga kelestariannya secara turun temurun.',
        'fakta' => 'Desa Tampirkulon memiliki kelompok Kesenian Tradisional Jathilan Krido Budoyo yang aktif menggelar latihan dan pementasan saat tradisi merti dusun serta perayaan desa.',
        'peluang' => [
            'Penyediaan ruang tampil berkala dan integrasi dengan kalender atraksi wisata desa.',
            'Program regenerasi seni jathilan bagi anak-anak dan remaja dusun.',
            'Bantuan pengadaan dan perawatan gamelan, busana tari, serta sarana panggung.'
        ],
        'tujuan' => 'Menjaga marwah budaya desa, mempererat kerukunan antarwarga, dan melestarikan kearifan lokal.'
    ],
    [
        'id' => 6,
        'kategori' => 'kuliner',
        'nama' => 'Kuliner Lokal',
        'deskripsi' => 'Ragam kuliner khas dari dapur masyarakat Tampirkulon.',
        'icon' => 'bi-cup-hot-fill',
        'color' => '#e64a19',
        'bg_color' => '#fff3e0',
        'ringkasan' => 'Kelezatan cita rasa autentik Magelang yang lahir dari resep tradisional turun-temurun warga desa.',
        'fakta' => 'Warung kuliner legendaris seperti Warung Makan Kupat Tahu Mbah Kenuk dan sentra jajanan pasar dusun menjadi jujugan warga lokal maupun pelancong.',
        'peluang' => [
            'Pemetaan rute wisata kuliner desa Tampirkulon bagi pengunjung luar daerah.',
            'Standardisasi kebersihan tempat makan dan kenyamanan pengunjung.',
            'Kolaborasi dengan ojek desa dan pesanan daring untuk memudahkan konsumen.'
        ],
        'tujuan' => 'Menjadikan kuliner Tampirkulon sebagai daya tarik rasa yang menggerakkan perputaran uang di dalam desa.'
    ]
];

// 2. Data Lokasi Populer untuk Peta Interaktif
$petaLokasi = [
    [
        'id' => 1,
        'nama' => $spotPotensiJudul,
        'kategori' => 'sumber-air',
        'kategori_label' => 'Sumber Mata Air',
        'jarak' => $spotPotensiJarak,
        'lokasi' => $spotPotensiLokasi,
        'lat' => -7.5015,
        'lng' => 110.2735,
        'foto' => $fotoSpotPotensi,
        'desc' => $spotPotensiDesc,
        'icon' => 'bi-droplet-fill',
        'color' => '#0288d1'
    ],
    [
        'id' => 2,
        'nama' => 'Mata Air Tuk Lanang',
        'kategori' => 'sumber-air',
        'kategori_label' => 'Sumber Mata Air',
        'jarak' => '± 0,33 km dari Balai Desa',
        'lokasi' => 'Tampirkulon, Candimulyo',
        'lat' => -7.5008,
        'lng' => 110.2728,
        'foto' => 'assets/images/potensi/mata_air_tuk_lanang.jpg',
        'desc' => 'Sumber mata air alami di bawah naungan pohon beringin purba yang menjaga pasokan air warga.',
        'icon' => 'bi-droplet-fill',
        'color' => '#0288d1'
    ],
    [
        'id' => 3,
        'nama' => 'Wisata Tubing Tampirkulon',
        'kategori' => 'wisata',
        'kategori_label' => 'Wisata Desa',
        'jarak' => '± 1,2 km dari Balai Desa',
        'lokasi' => 'Aliran Sungai Tampirkulon',
        'lat' => -7.5045,
        'lng' => 110.2780,
        'foto' => 'assets/images/potensi/wisata_tubing.jpg',
        'desc' => 'Wahana wisata petualangan menyusuri sungai dengan ban karet didampingi tim Pokdarwis.',
        'icon' => 'bi-tree-fill',
        'color' => '#2e7d32'
    ],
    [
        'id' => 4,
        'nama' => 'Jathilan Krido Budoyo',
        'kategori' => 'budaya',
        'kategori_label' => 'Seni & Budaya',
        'jarak' => '± 0,8 km dari Balai Desa',
        'lokasi' => 'Dusun Krajan, Tampirkulon',
        'lat' => -7.5025,
        'lng' => 110.2768,
        'foto' => 'assets/images/potensi/jathilan_krido_budoyo.jpg',
        'desc' => 'Sanggar kesenian tradisional jathilan kuda lumping warisan budaya leluhur desa.',
        'icon' => 'bi-mask',
        'color' => '#7b1fa2'
    ],
    [
        'id' => 5,
        'nama' => 'Warung Kupat Tahu Mbah Kenuk',
        'kategori' => 'kuliner',
        'kategori_label' => 'Kuliner Lokal',
        'jarak' => '± 1,1 km dari Balai Desa',
        'lokasi' => 'Jl. Sudiro Km 4, Tampirkulon',
        'lat' => -7.5060,
        'lng' => 110.2748,
        'foto' => 'assets/images/potensi/kuliner_kupat_tahu.jpg',
        'desc' => 'Kuliner legendaris kupat tahu bumbu kacang gurih manis khas Magelang yang nikmat.',
        'icon' => 'bi-cup-hot-fill',
        'color' => '#e64a19'
    ],
    [
        'id' => 6,
        'nama' => 'Lahan Pertanian & Holtikultura',
        'kategori' => 'pertanian',
        'kategori_label' => 'Pertanian',
        'jarak' => '± 0,6 km dari Balai Desa',
        'lokasi' => 'Kawasan Persawahan Dusun',
        'lat' => -7.4985,
        'lng' => 110.2710,
        'foto' => 'assets/images/potensi/pertanian_tampirkulon.jpg',
        'desc' => 'Hamparan persawahan terasering hijau penghasil beras dan sayur segar.',
        'icon' => 'fa-solid fa-wheat-awn',
        'color' => '#f57c00'
    ],
    [
        'id' => 7,
        'nama' => 'Sentra Keripik Tempe Bu Tatik',
        'kategori' => 'umkm',
        'kategori_label' => 'UMKM',
        'jarak' => '± 0,5 km dari Balai Desa',
        'lokasi' => 'Dusun Tampir II, Tampirkulon',
        'lat' => -7.5030,
        'lng' => 110.2755,
        'foto' => 'assets/images/potensi/umkm_tempe_kripik.jpg',
        'desc' => 'Produksi keripik tempe renyah gurih berkualitas tinggi tanpa bahan pengawet.',
        'icon' => 'bi-shop',
        'color' => '#d32f2f'
    ],
    [
        'id' => 8,
        'nama' => 'Pojok Baca & PAUD Dusun',
        'kategori' => 'pendidikan',
        'kategori_label' => 'Pendidikan',
        'jarak' => '± 0,2 km dari Balai Desa',
        'lokasi' => 'Kompleks Balai Desa Tampirkulon',
        'lat' => -7.5018,
        'lng' => 110.2730,
        'foto' => 'assets/images/program/potensi_pendidikan.jpg',
        'desc' => 'Fasilitas pendidikan usia dini dan literasi ramah anak bagi warga.',
        'icon' => 'bi-book-fill',
        'color' => '#3949ab'
    ]
];

// 3. Data Galeri Potensi Desa
$galeriPotensi = [
    [
        'id' => 1,
        'nama' => 'Sumber Mata Air',
        'jumlah_foto' => '8 foto',
        'foto' => 'assets/images/potensi/kolam_ngudal_tuk_putri.jpg',
        'keterangan' => 'Keindahan dan kejernihan Kolam Ngudal Tuk Putri & Tuk Lanang.'
    ],
    [
        'id' => 2,
        'nama' => 'Wisata Tubing',
        'jumlah_foto' => '12 foto',
        'foto' => 'assets/images/potensi/wisata_tubing.jpg',
        'keterangan' => 'Aktivitas seru wisatawan menyusuri jeram sungai Tampirkulon.'
    ],
    [
        'id' => 3,
        'nama' => 'Pertanian',
        'jumlah_foto' => '10 foto',
        'foto' => 'assets/images/potensi/pertanian_tampirkulon.jpg',
        'keterangan' => 'Hamparan sawah terasering hijau dan panen hasil bumi petani.'
    ],
    [
        'id' => 4,
        'nama' => 'UMKM',
        'jumlah_foto' => '14 foto',
        'foto' => 'assets/images/potensi/umkm_tempe_kripik.jpg',
        'keterangan' => 'Proses penggorengan dan pengemasan keripik tempe Bu Tatik.'
    ],
    [
        'id' => 5,
        'nama' => 'Seni & Budaya',
        'jumlah_foto' => '9 foto',
        'foto' => 'assets/images/potensi/jathilan_krido_budoyo.jpg',
        'keterangan' => 'Pementasan atraktif Kesenian Jathilan Krido Budoyo Tampirkulon.'
    ],
    [
        'id' => 6,
        'nama' => 'Kuliner Lokal',
        'jumlah_foto' => '11 foto',
        'foto' => 'assets/images/potensi/kuliner_kupat_tahu.jpg',
        'keterangan' => 'Sajian hangat Kupat Tahu Mbah Kenuk dengan bumbu kacang khas.'
    ]
];
?>

<!-- Include Leaflet CSS & JS untuk Peta Interaktif -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<!-- ==========================================================================
     SECTION 1: HERO BANNER ("Kekayaan Desa, Kekuatan Bersama")
     ========================================================================== -->
<div class="container-custom pt-3 pb-2">
  <section class="potensi-hero-card" style="background-image: url('<?= e($fotoHeroPotensi) ?>');">
    <div class="potensi-hero-overlay"></div>
    <div class="potensi-hero-content">
      <div class="row align-items-center">
        <div class="col-lg-8 col-xl-7">
          <span class="potensi-hero-badge">
            <i class="bi bi-compass-fill me-1"></i> POTENSI DESA TAMPIRKULON
          </span>
          <h1 class="potensi-hero-title">
            <?= $heroPotensiJudul ?>
          </h1>
          <p class="potensi-hero-subtitle">
            <?= e($heroPotensiSub) ?>
          </p>
          <div class="potensi-hero-cta">
            <a href="#enamPotensi" class="potensi-btn-primary">
              <i class="bi bi-compass me-1"></i> Jelajahi Potensi
            </a>
            <a href="#petaPotensi" class="potensi-btn-outline">
              <i class="bi bi-geo-alt me-1"></i> Lihat di Peta
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Floating Badge Lokasi (Sesuai Mockup ngudal 2.png) -->
    <div class="potensi-hero-floating-badge d-none d-md-flex">
      <i class="bi bi-geo-alt-fill text-danger fs-5"></i>
      <div>
        <div class="fw-bold" style="font-size:0.86rem;line-height:1.2;"><?= e($spotPotensiJudul) ?></div>
        <small class="text-white-50" style="font-size:0.72rem;"><?= e($spotPotensiLokasi) ?></small>
      </div>
    </div>
  </section>
</div>

<!-- ==========================================================================
     SECTION 2: ENAM POTENSI UTAMA DESA TAMPIRKULON
     ========================================================================== -->
<section id="enamPotensi" class="py-5 bg-white">
  <div class="container-custom">
    <div class="mb-4">
      <div class="potensi-section-tag">
        <span class="potensi-accent-bar"></span> POTENSI UNGGULAN
      </div>
      <h2 class="fw-bold fs-2 text-dark mb-1">Enam Potensi Utama Desa Tampirkulon</h2>
      <p class="text-muted mb-0 small">
        Beragam potensi yang menjadi kekuatan desa dan membuka peluang untuk kesejahteraan masyarakat.
      </p>
    </div>

    <div class="row g-3 g-lg-4">
      <?php foreach ($potensiUtama as $item): ?>
      <div class="col-6 col-md-4 col-lg-2">
        <div class="potensi-card">
          <div class="potensi-card-icon" style="background-color: <?= e($item['color']) ?>;">
            <?php if (strpos($item['icon'], 'fa-') !== false): ?>
            <i class="<?= e($item['icon']) ?>"></i>
            <?php else: ?>
            <i class="bi <?= e($item['icon']) ?>"></i>
            <?php endif; ?>
          </div>
          <h3 class="potensi-card-title"><?= e($item['nama']) ?></h3>
          <p class="potensi-card-desc"><?= e($item['deskripsi']) ?></p>
          <button type="button" class="potensi-card-btn" data-bs-toggle="modal" data-bs-target="#modalPotensi<?= $item['id'] ?>">
            Lihat Detail <i class="bi bi-arrow-right ms-1"></i>
          </button>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ==========================================================================
     SECTION 3: SPOT UNGGULAN (KOLAM NGUDAL TUK PUTRI)
     ========================================================================== -->
<section class="py-4 py-md-5 bg-light-subtle">
  <div class="container-custom">
    <div class="potensi-spot-card">
      <div class="row g-4 align-items-center">
        <!-- Kolom Kiri: Foto Besar Kolam Ngudal Tuk Putri -->
        <div class="col-lg-6">
          <div class="potensi-spot-img-wrap">
            <img src="<?= e($fotoSpotPotensi) ?>" alt="<?= e($spotPotensiJudul) ?>" class="potensi-spot-img">
            <div class="potensi-video-badge" data-bs-toggle="modal" data-bs-target="#modalVideoTukPutri">
              <i class="bi bi-play-circle-fill text-danger fs-5"></i>
              <span>Lihat Video / Info</span>
            </div>
          </div>
        </div>

        <!-- Kolom Kanan: Narasi Faktual & Aksi -->
        <div class="col-lg-6 px-lg-4 py-2">
          <div class="potensi-section-tag">
            <span class="potensi-accent-bar"></span> SPOT UNGGULAN
          </div>
          <h2 class="potensi-spot-title"><?= e($spotPotensiJudul) ?></h2>
          <p class="potensi-spot-desc">
            <?= e($spotPotensiDesc) ?>
          </p>

          <div class="potensi-meta-list">
            <div class="potensi-meta-item">
              <i class="bi bi-geo-alt-fill"></i>
              <span><?= e($spotPotensiLokasi) ?></span>
            </div>
            <div class="potensi-meta-item">
              <i class="bi bi-compass"></i>
              <span><?= e($spotPotensiJarak) ?></span>
            </div>
          </div>

          <div class="d-flex flex-wrap gap-2 pt-2">
            <a href="#petaPotensi" onclick="focusPeta(1)" class="btn btn-success rounded-pill fw-bold px-4 py-2 shadow-sm d-inline-flex align-items-center gap-2">
              <i class="bi bi-geo-alt-fill"></i> Lihat di Peta
            </a>
            <button type="button" class="btn btn-outline-secondary rounded-pill fw-bold px-4 py-2 d-inline-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalGaleriTukPutri">
              <i class="bi bi-camera-fill"></i> Lihat Galeri
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ==========================================================================
     SECTION 4: PETA POTENSI DESA (INTERAKTIF DENGAN FILTER & LIST POPULER)
     ========================================================================== -->
<section id="petaPotensi" class="py-5 bg-white">
  <div class="container-custom">
    <div class="mb-4">
      <div class="potensi-section-tag">
        <span class="potensi-accent-bar"></span> JELAJAHI LOKASI
      </div>
      <h2 class="fw-bold fs-2 text-dark mb-1">Peta Potensi Desa</h2>
      <p class="text-muted mb-0 small">
        Temukan berbagai potensi desa Tampirkulon melalui peta interaktif berikut.
      </p>
    </div>

    <div class="row g-3 g-lg-4 align-items-stretch">
      <!-- 1. Kolom Kiri: Filter Kategori -->
      <div class="col-lg-3 col-xl-2">
        <div class="potensi-filter-box h-100">
          <div class="potensi-filter-title">Filter Potensi</div>
          <div class="d-flex flex-column gap-1">
            <div class="potensi-filter-item active" data-filter="all">
              <i class="bi bi-check2-circle text-success"></i> Semua
            </div>
            <div class="potensi-filter-item" data-filter="sumber-air">
              <i class="bi bi-droplet-fill text-info"></i> Sumber Air
            </div>
            <div class="potensi-filter-item" data-filter="wisata">
              <i class="bi bi-tree-fill text-success"></i> Wisata
            </div>
            <div class="potensi-filter-item" data-filter="pertanian">
              <i class="fa-solid fa-wheat-awn" style="color:#f57c00;"></i> Pertanian
            </div>
            <div class="potensi-filter-item" data-filter="umkm">
              <i class="bi bi-shop text-danger"></i> UMKM
            </div>
            <div class="potensi-filter-item" data-filter="kuliner">
              <i class="bi bi-cup-hot-fill text-danger"></i> Kuliner
            </div>
            <div class="potensi-filter-item" data-filter="budaya">
              <i class="bi bi-mask text-purple" style="color:#7b1fa2;"></i> Seni &amp; Budaya
            </div>
            <div class="potensi-filter-item" data-filter="pendidikan">
              <i class="bi bi-book-fill text-primary"></i> Pendidikan
            </div>
          </div>
        </div>
      </div>

      <!-- 2. Kolom Tengah: Peta Interaktif Leaflet -->
      <div class="col-lg-5 col-xl-6">
        <div class="potensi-map-wrap">
          <div id="potensiMap"></div>
        </div>
      </div>

      <!-- 3. Kolom Kanan: Daftar Lokasi Populer -->
      <div class="col-lg-4 col-xl-4">
        <div class="potensi-popular-box h-100">
          <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
            <h6 class="fw-bold mb-0 text-dark">Daftar Lokasi Populer</h6>
            <a href="javascript:void(0)" onclick="resetPeta()" class="text-success fw-bold text-decoration-none small">
              Semua Lokasi &rarr;
            </a>
          </div>

          <div class="d-flex flex-column gap-2 overflow-auto" style="max-height: 400px;">
            <?php foreach (array_slice($petaLokasi, 0, 5) as $lok): ?>
            <div class="potensi-popular-item border rounded-3 p-2" onclick="focusPeta(<?= $lok['id'] ?>)">
              <img src="<?= e($lok['foto']) ?>" alt="<?= e($lok['nama']) ?>" class="potensi-popular-thumb">
              <div class="flex-grow-1 overflow-hidden">
                <div class="potensi-popular-name text-truncate"><?= e($lok['nama']) ?></div>
                <div class="potensi-popular-sub">
                  <span class="badge bg-light text-secondary border px-2 py-0" style="font-size:0.68rem;"><?= e($lok['kategori_label']) ?></span>
                  <span><i class="bi bi-geo-alt text-danger me-1"></i><?= e($lok['jarak']) ?></span>
                </div>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ==========================================================================
     SECTION 5: GALERI POTENSI DESA (6 KARTU ALBUM DOKUMENTASI)
     ========================================================================== -->
<section class="py-5 bg-light-subtle">
  <div class="container-custom">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
      <div>
        <div class="potensi-section-tag">
          <span class="potensi-accent-bar"></span> DOKUMENTASI
        </div>
        <h2 class="fw-bold fs-2 text-dark mb-1">Galeri Potensi Desa</h2>
        <p class="text-muted mb-0 small">
          Lihat berbagai potensi dan kegiatan masyarakat Tampirkulon.
        </p>
      </div>
      <div class="mt-3 mt-md-0 d-flex align-items-center gap-2">
        <button type="button" class="btn btn-outline-secondary btn-sm rounded-circle p-2" style="width:36px;height:36px;" data-bs-target="#galeriCarousel" data-bs-slide="prev" aria-label="Sebelumnya">
          <i class="bi bi-chevron-left"></i>
        </button>
        <button type="button" class="btn btn-outline-secondary btn-sm rounded-circle p-2" style="width:36px;height:36px;" data-bs-target="#galeriCarousel" data-bs-slide="next" aria-label="Selanjutnya">
          <i class="bi bi-chevron-right"></i>
        </button>
      </div>
    </div>

    <!-- Grid Galeri 6 Album -->
    <div class="row g-3 g-lg-4">
      <?php foreach ($galeriPotensi as $g): ?>
      <div class="col-6 col-md-4 col-lg-2">
        <div class="potensi-gallery-card" data-bs-toggle="modal" data-bs-target="#modalLightbox<?= $g['id'] ?>">
          <img src="<?= e($g['foto']) ?>" alt="<?= e($g['nama']) ?>" class="potensi-gallery-img">
          <div class="potensi-gallery-overlay">
            <div class="potensi-gallery-name"><?= e($g['nama']) ?></div>
            <div class="potensi-gallery-count"><i class="bi bi-images me-1"></i><?= e($g['jumlah_foto']) ?></div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ==========================================================================
     SECTION 6: BANNER CTA SAPA WARGA ("Punya Informasi Potensi Desa?")
     ========================================================================== -->
<div class="container-custom py-4 mb-2">
  <section class="potensi-cta-card" style="background-image: url('assets/images/banner/hero_bg_pure_landscape.jpg');">
    <div class="potensi-cta-overlay">
      <div class="row align-items-center g-3">
        <div class="col-lg-8">
          <h3 class="potensi-cta-title">Punya Informasi Potensi Desa?</h3>
          <p class="potensi-cta-subtitle">
            Bantu kami melengkapi data potensi desa. Anda dapat mengirimkan informasi tempat, usaha, budaya, atau potensi lainnya melalui kanal komunikasi langsung Sapa Warga.
          </p>
        </div>
        <div class="col-lg-4 text-lg-end">
          <a href="index.php?page=sapa-warga#formAspirasi" class="potensi-cta-btn">
            <i class="bi bi-send-fill"></i> Sampaikan Melalui Sapa Warga
          </a>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- ==========================================================================
     MODALS: DETAIL 6 POTENSI UTAMA DESA TAMPIRKULON
     ========================================================================== -->
<?php foreach ($potensiUtama as $item): ?>
<div class="modal fade" id="modalPotensi<?= $item['id'] ?>" tabindex="-1" aria-labelledby="modalLabelPotensi<?= $item['id'] ?>" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
      <!-- Header -->
      <div class="modal-header text-white border-0 py-3 px-4" style="background-color: <?= e($item['color']) ?>;">
        <div class="d-flex align-items-center gap-3">
          <div class="bg-white rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; color: <?= e($item['color']) ?>;">
            <?php if (strpos($item['icon'], 'fa-') !== false): ?>
            <i class="<?= e($item['icon']) ?> fs-5"></i>
            <?php else: ?>
            <i class="bi <?= e($item['icon']) ?> fs-5"></i>
            <?php endif; ?>
          </div>
          <div>
            <span class="badge bg-white-subtle text-white rounded-pill px-2 py-0 small mb-1">
              Potensi Desa Tampirkulon
            </span>
            <h5 class="modal-title fw-bold text-white mb-0" id="modalLabelPotensi<?= $item['id'] ?>">
              <?= e($item['nama']) ?>
            </h5>
          </div>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Body -->
      <div class="modal-body p-4">
        <!-- Ringkasan Singkat -->
        <div class="p-3 rounded-3 mb-4" style="background-color: <?= e($item['bg_color']) ?>; border-left: 4px solid <?= e($item['color']) ?>;">
          <div class="fw-semibold text-dark" style="font-size:0.95rem;"><?= e($item['ringkasan']) ?></div>
        </div>

        <!-- Fakta & Potensi Desa -->
        <div class="mb-4">
          <h6 class="fw-bold text-dark d-flex align-items-center gap-2 mb-2">
            <i class="bi bi-info-circle-fill" style="color: <?= e($item['color']) ?>;"></i>
            Kondisi &amp; Data Faktual Desa
          </h6>
          <p class="text-secondary small leading-relaxed mb-0">
            <?= e($item['fakta']) ?>
          </p>
        </div>

        <!-- Peluang yang Dapat Dikaji -->
        <div class="mb-4">
          <h6 class="fw-bold text-dark d-flex align-items-center gap-2 mb-2">
            <i class="bi bi-lightbulb-fill text-warning"></i>
            Peluang &amp; Rencana Kajian Bersama Warga
          </h6>
          <div class="bg-light p-3 rounded-3 border">
            <ul class="list-unstyled mb-0 small text-secondary d-flex flex-column gap-2">
              <?php foreach ($item['peluang'] as $p): ?>
              <li class="d-flex align-items-start gap-2">
                <i class="bi bi-check2-circle text-success mt-1 flex-shrink-0"></i>
                <span><?= e($p) ?></span>
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>

        <!-- Tujuan Pengembangan -->
        <div class="p-3 bg-white border rounded-3">
          <h6 class="fw-bold text-dark mb-1" style="font-size:0.85rem;">
            <i class="bi bi-bullseye text-danger me-1"></i> Komitmen &amp; Tujuan
          </h6>
          <p class="text-muted small mb-0">
            <?= e($item['tujuan']) ?>
          </p>
        </div>
      </div>

      <!-- Footer Modal -->
      <div class="modal-footer bg-light border-0 py-3 px-4 d-flex justify-content-between">
        <small class="text-muted" style="font-size:0.75rem;">
          <i class="bi bi-shield-check text-success me-1"></i> Data diverifikasi dari potensi riil Desa Tampirkulon
        </small>
        <button type="button" class="btn btn-secondary btn-sm rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
<?php endforeach; ?>

<!-- ==========================================================================
     MODAL: VIDEO / INFO TUK PUTRI
     ========================================================================== -->
<div class="modal fade" id="modalVideoTukPutri" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
      <div class="modal-header bg-dark text-white border-0 py-3 px-4">
        <h6 class="modal-title fw-bold"><i class="bi bi-camera-reels me-2 text-danger"></i>Mengenal Kolam Ngudal Tuk Putri</h6>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0 bg-black">
        <div class="ratio ratio-16x9">
          <img src="<?= e($fotoSpotPotensi) ?>" alt="<?= e($spotPotensiJudul) ?>" class="w-100 h-100 object-fit-cover">
        </div>
      </div>
      <div class="modal-footer bg-light border-0 p-3">
        <div class="w-100 d-flex justify-content-between align-items-center">
          <span class="small text-muted"><i class="bi bi-geo-alt-fill text-danger me-1"></i><?= e($spotPotensiJarak) ?></span>
          <button type="button" class="btn btn-secondary btn-sm rounded-pill px-3" data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ==========================================================================
     MODAL: GALERI TUK PUTRI
     ========================================================================== -->
<div class="modal fade" id="modalGaleriTukPutri" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
      <div class="modal-header bg-success text-white border-0 py-3 px-4">
        <h6 class="modal-title fw-bold"><i class="bi bi-images me-2"></i>Galeri <?= e($spotPotensiJudul) ?></h6>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4 text-center">
        <img src="<?= e($fotoSpotPotensi) ?>" alt="<?= e($spotPotensiJudul) ?>" class="img-fluid rounded-3 shadow-sm mb-3" style="max-height: 420px; object-fit: cover;">
        <p class="text-muted small mb-0">
          <?= e($spotPotensiDesc) ?>
        </p>
      </div>
      <div class="modal-footer bg-light border-0 p-3">
        <button type="button" class="btn btn-secondary btn-sm rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- ==========================================================================
     MODALS: LIGHTBOX ALBUM FOTO GALERI
     ========================================================================== -->
<?php foreach ($galeriPotensi as $g): ?>
<div class="modal fade" id="modalLightbox<?= $g['id'] ?>" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
      <div class="modal-header bg-dark text-white border-0 py-3 px-4">
        <h6 class="modal-title fw-bold"><i class="bi bi-image me-2 text-warning"></i>Galeri <?= e($g['nama']) ?></h6>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-3 text-center bg-light">
        <img src="<?= e($g['foto']) ?>" alt="<?= e($g['nama']) ?>" class="img-fluid rounded-3 shadow-sm mb-3" style="max-height: 440px; object-fit: cover; width: 100%;">
        <div class="p-2 bg-white rounded-3 border">
          <p class="text-dark small mb-0 fw-semibold"><?= e($g['keterangan']) ?></p>
        </div>
      </div>
      <div class="modal-footer bg-white border-0 py-2 px-3 d-flex justify-content-between">
        <span class="badge bg-success-subtle text-success border px-2 py-1 small"><?= e($g['jumlah_foto']) ?></span>
        <button type="button" class="btn btn-secondary btn-sm rounded-pill px-3" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
<?php endforeach; ?>

<!-- ==========================================================================
     JAVASCRIPT: INITIALIZATION LEAFLET MAP & FILTER
     ========================================================================== -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  // 1. Data Lokasi dari PHP
  const lokasiData = <?= json_encode($petaLokasi, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;

  // 2. Inisialisasi Peta Leaflet (Pusat Tampirkulon, Candimulyo: -7.5020, 110.2740)
  const map = L.map('potensiMap', {
    scrollWheelZoom: false
  }).setView([-7.5020, 110.2740], 15);

  // Tile Layer OpenStreetMap
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
  }).addTo(map);

  // Simpan marker dalam array untuk filter dan interaksi
  const markers = [];

  // Helper untuk membuat ikon pin warna
  function createCustomPin(color, iconClass) {
    return L.divIcon({
      className: 'potensi-leaflet-pin',
      html: `
        <div style="
          width: 34px;
          height: 34px;
          background: ${color};
          border: 2.5px solid #ffffff;
          border-radius: 50%;
          box-shadow: 0 4px 10px rgba(0,0,0,0.3);
          display: flex;
          align-items: center;
          justify-content: center;
          color: #ffffff;
          font-size: 15px;
          cursor: pointer;
          transform: translate(-50%, -50%);
        ">
          <i class="${iconClass.startsWith('fa-') ? iconClass : 'bi ' + iconClass}"></i>
        </div>
      `,
      iconSize: [34, 34],
      iconAnchor: [17, 17]
    });
  }

  // 3. Tambahkan Marker ke Peta
  lokasiData.forEach(function(item) {
    const pin = createCustomPin(item.color, item.icon);
    const marker = L.marker([item.lat, item.lng], { icon: pin }).addTo(map);

    // Popup Konten
    const popupHtml = `
      <div class="potensi-map-popup">
        <img src="${item.foto}" alt="${item.nama}">
        <span class="badge bg-success-subtle text-success border px-2 py-0 mb-1" style="font-size:0.65rem;">${item.kategori_label}</span>
        <h6>${item.nama}</h6>
        <p><i class="bi bi-geo-alt text-danger me-1"></i>${item.jarak}</p>
        <a href="https://www.google.com/maps/search/?api=1&query=${item.lat},${item.lng}" target="_blank" rel="noopener noreferrer" class="btn btn-success btn-sm w-100 rounded-pill py-1" style="font-size:0.75rem;">
          <i class="bi bi-map me-1"></i> Buka Petunjuk Arah
        </a>
      </div>
    `;

    marker.bindPopup(popupHtml);
    markers.push({ id: item.id, kategori: item.kategori, marker: marker, lat: item.lat, lng: item.lng });
  });

  // 4. Global Functions untuk Interaksi Peta
  window.focusPeta = function(id) {
    const target = markers.find(m => m.id === id);
    if (target) {
      map.setView([target.lat, target.lng], 16, { animate: true });
      target.marker.openPopup();
      // Scroll ke peta jika di mobile
      if (window.innerWidth < 992) {
        document.getElementById('potensiMap').scrollIntoView({ behavior: 'smooth' });
      }
    }
  };

  window.resetPeta = function() {
    map.setView([-7.5020, 110.2740], 15, { animate: true });
    // Reset active class pada filter
    document.querySelectorAll('.potensi-filter-item').forEach(el => el.classList.remove('active'));
    document.querySelector('.potensi-filter-item[data-filter="all"]').classList.add('active');
    // Munculkan semua marker
    markers.forEach(m => map.addLayer(m.marker));
  };

  // 5. Filter Interaktif Berdasarkan Kategori
  document.querySelectorAll('.potensi-filter-item').forEach(function(item) {
    item.addEventListener('click', function() {
      document.querySelectorAll('.potensi-filter-item').forEach(el => el.classList.remove('active'));
      this.classList.add('active');

      const selectedCategory = this.getAttribute('data-filter');

      markers.forEach(function(m) {
        if (selectedCategory === 'all' || m.kategori === selectedCategory) {
          map.addLayer(m.marker);
        } else {
          map.removeLayer(m.marker);
        }
      });

      // Fit bounds jika ada marker yang tampil
      const activeMarkers = markers.filter(m => selectedCategory === 'all' || m.kategori === selectedCategory);
      if (activeMarkers.length > 0) {
        const group = new L.featureGroup(activeMarkers.map(m => m.marker));
        map.fitBounds(group.getBounds().pad(0.2));
      }
    });
  });
});
</script>
