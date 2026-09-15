<?php
/**
 * Halaman 7 Bidang Program Prioritas & Rencana Pengembangan Desa
 * Calon Kepala Desa Tampirkulon - Edy Susanto (No. Urut 2)
 *
 * Sesuai dengan UI Mockup: UI/Program/program kerja.png & program kerja mobile.png
 */
if (!defined('APP_NAME')) {
    require_once __DIR__ . '/../includes/config.php';
}

// Data 7 Bidang Program Kerja Prioritas
$programData = [
    1 => [
        'id' => 1,
        'bidang' => 'Pertanian & Ketahanan Pangan',
        'sub_desc' => 'Pertanian maju, petani sejahtera.',
        'kategori' => 'pertanian-wisata',
        'kategori_label' => 'Pertanian & Ketahanan Pangan',
        'icon' => 'fa-solid fa-wheat-awn',
        'card_bg' => '#eef9ee',
        'border_color' => '#c8e6c9',
        'icon_color' => '#2e7d32',
        'ringkasan' => 'Optimalisasi saluran irigasi tersier di 6 dusun, fasilitasi ketersediaan pupuk dan bibit unggul, serta pendampingan PPL berkelanjutan bagi para petani Tampirkulon.',
        'kondisi_faktual' => 'Sebagian besar warga Tampirkulon menggantungkan hidup pada sektor pertanian pangan dan hortikultura. Namun, tantangan klasik berupa kelangkaan pupuk subsidi, sedimentasi saluran irigasi di beberapa titik dusun, dan fluktuasi harga panen kerap membebani petani.',
        'potensi_kebutuhan' => 'Ketersediaan sumber mata air alam (Tuk Lanang & Tuk Putri) yang melimpah dan jaringan parit yang menjangkau antardusun merupakan potensi strategis yang perlu ditata agar aliran air irigasi merata sepanjang musim.',
        'rencana_aksi' => [
            'Normalisasi dan perbaikan saluran irigasi tersier pada titik rawan sedimentasi di 6 dusun.',
            'Penguatan koordinasi dengan Gapoktan dan distributor resmi untuk mempermudah alokasi serta distribusi pupuk bersubsidi.',
            'Fasilitasi pelatihan pertanian ramah lingkungan dan penggunaan pupuk organik cair buatan lokal.',
            'Kemitraan intensif bersama Penyuluh Pertanian Lapangan (PPL) dan pemanfaatan teknologi tepat guna.'
        ],
        'indikator_target' => [
            'Penataan saluran irigasi pertanian di 6 dusun tertangani secara bertahap.',
            'Distribusi pupuk lebih transparan dan tepat waktu menjelang masa tanam.',
            'Pembentukan posko konsultasi tani bekerjasama dengan Gapoktan desa.'
        ],
        'status' => 'Program Prioritas Utama',
        'sumber' => 'Aspirasi Gapoktan & Warga Petani Tampirkulon'
    ],
    2 => [
        'id' => 2,
        'bidang' => 'UMKM & Ekonomi Lokal',
        'sub_desc' => 'Produk lokal berdaya saing, ekonomi tumbuh.',
        'kategori' => 'ekonomi-umkm',
        'kategori_label' => 'UMKM & Ekonomi Lokal',
        'icon' => 'bi-shop',
        'card_bg' => '#fff5ea',
        'border_color' => '#ffe0b2',
        'icon_color' => '#e65100',
        'ringkasan' => 'Pendampingan legalitas izin usaha (P-IRT, NIB, Halal), pengemasan modern, serta penyediaan display center produk lokal Tampirkulon di titik strategis desa.',
        'kondisi_faktual' => 'Desa Tampirkulon memiliki banyak perajin makanan tradisional, khususnya sentra olahan keripik tempe (seperti UMKM Bu Tatik, Pak Budi, dan warga lainnya). Sebagian besar usaha masih dikelola secara mandiri rumah tangga dengan keterbatasan akses legalitas resmi dan pemasaran digital.',
        'potensi_kebutuhan' => 'Kualitas rasa keripik tempe Tampirkulon sangat diakui. Jika didukung izin edar lengkap, branding kemasan modern, serta etalase di jalur wisata desa, nilai tambah ekonomi bagi keluarga pelaku usaha akan berlipat ganda.',
        'rencana_aksi' => [
            'Fasilitasi kolektif pembuatan NIB (Nomor Induk Berusaha), sertifikasi Halal, dan izin P-IRT gratis bagi UMKM desa.',
            'Pelatihan pengemasan (packaging) higienis dan foto produk untuk penjualan di platform online.',
            'Pembangunan etalase bersama (Pojok Oleh-Oleh Tampirkulon) terintegrasi dengan rest area wisata desa.',
            'Pelibatan perajin lokal dalam pameran produk dan pasar rakyat berkala desa.'
        ],
        'indikator_target' => [
            'Target usulan fasilitasi legalitas P-IRT & Halal bagi puluhan UMKM makanan olahan.',
            'Terwujudnya 1 titik galeri display produk unggulan desa di jalur utama/wisata.',
            'Peningkatan jangkauan pemasaran produk lokal ke luar wilayah Magelang.'
        ],
        'status' => 'Program Prioritas Ekonomi',
        'sumber' => 'Wawancara Pelaku UMKM & Pengrajin Tempe'
    ],
    3 => [
        'id' => 3,
        'bidang' => 'Wisata Desa',
        'sub_desc' => 'Wisata berkembang, masyarakat sejahtera.',
        'kategori' => 'pertanian-wisata',
        'kategori_label' => 'Wisata Desa',
        'icon' => 'bi-person-walking',
        'card_bg' => '#eef7fe',
        'border_color' => '#b3e5fc',
        'icon_color' => '#0288d1',
        'ringkasan' => 'Integrasi destinasi Tuk Lanang & Tuk Putri (0,33 km) serta Tubing Tampirkulon (1,89 km) melalui penguatan Pokdarwis 2026 dan promosi digital terarah.',
        'kondisi_faktual' => 'Desa Tampirkulon dianugerahi potensi alam luar biasa berupa mata air alami Tuk Lanang dan Tuk Putri (0,33 km dari pusat dusun) serta jalur aliran sungai Tubing Tampirkulon (1,89 km). Saat ini Pokdarwis 2026 telah terbentuk dengan 19 pengurus yang siap bersinergi.',
        'potensi_kebutuhan' => 'Potensi ini membutuhkan sentuhan penataan infrastruktur penunjang (akses jalan setapak, safety equipment tubing, fasilitas sanitasi memadai) serta promosi digital berkelanjutan agar menjadi sumber pendapatan desa dan lapangan kerja generasi muda.',
        'rencana_aksi' => [
            'Peningkatan sarana pendukung kenyamanan wisatawan (kebersihan, kamar bilas, gazebo istirahat, petunjuk arah).',
            'Sinergi aktif bersama Pokdarwis 2026 dalam standardisasi SOP keamanan susur sungai (tubing).',
            'Pemberdayaan warga sekitar rute wisata sebagai pemandu lokal, penyedia kuliner, dan pengelola parkir.',
            'Penyelenggaraan event wisata budaya dan olahraga air tahunan untuk mendongkrak kunjungan.'
        ],
        'indikator_target' => [
            'Optimalisasi 2 titik wisata alam utama (Tuk Lanang/Putri dan Tubing Tampirkulon).',
            'Peningkatan kunjungan wisatawan lokal dan regional secara aman dan tertib.',
            'Kontribusi nyata terhadap kas desa melalui BUMDes dan pendapatan warga setempat.'
        ],
        'status' => 'Program Unggulan Desa',
        'sumber' => 'Data Pokdarwis 2026 & Potensi Alam Tampirkulon'
    ],
    4 => [
        'id' => 4,
        'bidang' => 'Pendidikan & Literasi',
        'sub_desc' => 'Generasi cerdas, masa depan cerah.',
        'kategori' => 'sdm-pemuda',
        'kategori_label' => 'Pendidikan & Literasi',
        'icon' => 'bi-journal-bookmark',
        'card_bg' => '#f6effc',
        'border_color' => '#e1bee7',
        'icon_color' => '#7b1fa2',
        'ringkasan' => 'Dukungan perlengkapan sekolah bagi siswa pra-sejahtera, revitalisasi sarana PAUD/TK Pertiwi & SDN, serta rintisan pojok baca literasi di setiap dusun.',
        'kondisi_faktual' => 'Tampirkulon memiliki lembaga pendidikan dasar aktif: SDN 1 Tampirkulon, SDN 2 Tampirkulon, TK Pertiwi 1, dan TK Pertiwi 2. Fasilitas penunjang belajar, perpustakaan anak, dan bantuan perlengkapan bagi anak dari keluarga kurang mampu masih sangat dibutuhkan.',
        'potensi_kebutuhan' => 'Anak-anak Tampirkulon memiliki semangat belajar tinggi. Dukungan beasiswa santunan desa dan fasilitas membaca di lingkungan dusun akan menjamin tidak ada anak usia sekolah yang putus belajar karena kendala biaya.',
        'rencana_aksi' => [
            'Program santunan biaya buku dan seragam bagi anak yatim / keluarga pra-sejahtera setiap tahun ajaran baru.',
            'Sinergi dengan pihak sekolah dalam pemeliharaan lingkungan belajar yang sehat, aman, dan nyaman.',
            'Penyediaan pojok baca dusun bekerjasama dengan mahasiswa KKN dan komunitas pegiat literasi.',
            'Penyelenggaraan kursus komputer dan bimbingan belajar gratis berbasis balai dusun.'
        ],
        'indikator_target' => [
            'Zero drop-out (nol anak putus sekolah) di jenjang pendidikan dasar 9 tahun.',
            'Revitalisasi fasilitas dasar di lingkungan TK Pertiwi & SD binaan desa.',
            'Tersedianya titik pojok baca aktif di balai pertemuan dusun.'
        ],
        'status' => 'Program Sosial & SDM',
        'sumber' => 'Data Lembaga Pendidikan Desa & Aspirasi Orang Tua'
    ],
    5 => [
        'id' => 5,
        'bidang' => 'Pemuda & Olahraga',
        'sub_desc' => 'Ruang tumbuh generasi muda.',
        'kategori' => 'sdm-pemuda',
        'kategori_label' => 'Pemuda & Olahraga',
        'icon' => 'bi-people-fill',
        'card_bg' => '#feeeee',
        'border_color' => '#ffcdd2',
        'icon_color' => '#c2185b',
        'ringkasan' => 'Revitalisasi lapangan olahraga dusun, penguatan peran Karang Taruna, dan pelestarian seni tradisional seperti paguyuban Jathilan Krido Budoyo.',
        'kondisi_faktual' => 'Pemuda Tampirkulon aktif dalam berbagai kegiatan sosial, keagamaan, dan seni budaya. Paguyuban kesenian tradisional Jathilan Krido Budoyo menjadi kebanggaan warga, namun membutuhkan wadah apresiasi rutin serta dukungan sarana latihan.',
        'potensi_kebutuhan' => 'Energi kreatif pemuda perlu diarahkan pada kegiatan produktif, kebugaran fisik melalui olahraga, wirausaha muda, dan pelestarian budaya adiluhung agar terhindar dari pengaruh negatif kenakalan remaja.',
        'rencana_aksi' => [
            'Alokasi anggaran pembinaan Karang Taruna untuk kegiatan kepemudaan, sosial, dan pelatihan kerja.',
            'Perbaikan dan perawatan sarana lapangan voli, bulu tangkis, dan fasilitas olahraga warga.',
            'Dukungan perlengkapan dan fasilitasi panggung pertunjukan rutin bagi grup kesenian Jathilan Krido Budoyo.',
            'Penyelenggaraan turnamen olahraga antardusun memperebutkan Piala Kades secara berkala.'
        ],
        'indikator_target' => [
            'Karang Taruna 6 dusun aktif menjalankan program kerja sosial dan kepemudaan.',
            'Fasilitas olahraga dusun terawat dan dimanfaatkan secara rutin.',
            'Terselenggaranya festival seni budaya tahunan tingkat desa.'
        ],
        'status' => 'Program Kreativitas Pemuda',
        'sumber' => 'Aspirasi Karang Taruna & Paguyuban Kesenian'
    ],
    6 => [
        'id' => 6,
        'bidang' => 'Lingkungan & Sumber Air',
        'sub_desc' => 'Lingkungan lestari untuk masa depan.',
        'kategori' => 'pelayanan-lingkungan',
        'kategori_label' => 'Lingkungan & Sumber Air',
        'icon' => 'bi-droplet-half',
        'card_bg' => '#eaf8f1',
        'border_color' => '#b2dfdb',
        'icon_color' => '#00897b',
        'ringkasan' => 'Pengelolaan sampah terpadu (pemilahan organik/anorganik), pemeliharaan drainase permukiman bebas genangan, serta konservasi mata air desa.',
        'kondisi_faktual' => 'Pertumbuhan permukiman di dusun-dusun membutuhkan sistem pengelolaan sampah yang tertata agar tidak terjadi penumpukan liar atau pencemaran saluran air. Selain itu, drainase lingkungan pada musim hujan lebat memerlukan pembersihan berkala.',
        'potensi_kebutuhan' => 'Warga memiliki budaya gotong royong yang kuat. Dengan penyediaan armada gerobak sampah, bak pilah, dan edukasi bank sampah dusun, Tampirkulon dapat menjadi desa bersih dan sehat percontohan.',
        'rencana_aksi' => [
            'Penyusunan regulasi desa tentang kebersihan dan penyediaan sarana pemilahan sampah di titik strategis.',
            'Inisiasi program Bank Sampah Berkah untuk mengubah sampah anorganik menjadi tabungan ekonomi warga.',
            'Normalisasi berkala saluran got dan drainase lingkungan bersama warga melalui program Jumat Bersih.',
            'Penanaman pohon penyerap air di sekitar sempadan Tuk Lanang dan Tuk Putri guna menjaga kelestarian mata air.'
        ],
        'indikator_target' => [
            'Penurunan titik pembuangan sampah liar secara signifikan.',
            'Terbentuknya unit bank sampah percontohan di tingkat dusun.',
            'Kawasan sempadan mata air terlindungi dan asri.'
        ],
        'status' => 'Program Berkelanjutan',
        'sumber' => 'Kajian Lingkungan & Aspirasi Warga 6 Dusun'
    ],
    7 => [
        'id' => 7,
        'bidang' => 'Pelayanan Desa',
        'sub_desc' => 'Pelayanan cepat, transparan, dan mudah.',
        'kategori' => 'pelayanan-lingkungan',
        'kategori_label' => 'Pelayanan & Tata Kelola Desa',
        'icon' => 'bi-gear-fill',
        'card_bg' => '#fff9e6',
        'border_color' => '#ffecb3',
        'icon_color' => '#f57f17',
        'ringkasan' => 'Digitalisasi pengurusan surat menyurat lewat integrasi Sapa Warga, transparansi publikasi APBDes terbuka di website, dan pelayanan ramah tanpa pungli.',
        'kondisi_faktual' => 'Warga menginginkan kepastian waktu dan kemudahan dalam pengurusan surat keterangan maupun dokumen kependudukan di kantor balai desa tanpa harus bolak-balik karena syarat yang kurang jelas.',
        'potensi_kebutuhan' => 'Pemanfaatan sistem digital Sapa Warga yang sudah dibangun memungkinkan permohonan surat dan penyampaian aspirasi dipantau secara langsung oleh warga, menghadirkan transparansi sejati.',
        'rencana_aksi' => [
            'Standardisasi SOP layanan administrasi desa (jelas syaratnya, jelas waktunya, gratis/tanpa pungli).',
            'Pengembangan menu pengajuan surat keterangan daring melalui website desa Tampirkulon.',
            'Publikasi realisasi APBDes (Anggaran Pendapatan dan Belanja Desa) di website resmi dan baliho balai desa.',
            'Penyediaan meja aduan warga (Helpdesk Sapa Warga) yang responsif menindaklanjuti keluhan dalam 1x24 jam.'
        ],
        'indikator_target' => [
            'Waktu pengurusan administrasi warga lebih cepat, teratur, dan transparan.',
            'Laporan keuangan desa dapat diakses secara terbuka oleh seluruh warga.',
            'Indeks kepuasan warga terhadap pelayanan kantor desa meningkat signifikan.'
        ],
        'status' => 'Program Reformasi Pelayanan',
        'sumber' => 'Komitmen Edy Susanto & Aspirasi Masyarakat'
    ]
];

// Hitung Data Realtime untuk Quick Stats Bar
$totalBidang = count($programData);
$totalRencanaAksi = 0;
foreach ($programData as $p) {
    $totalRencanaAksi += count($p['rencana_aksi'] ?? []);
}
try {
    $stmtAsp = $pdo->query("SELECT COUNT(*) FROM aspirasi");
    $totalAspirasiRealtime = (int) $stmtAsp->fetchColumn();
} catch (Exception $e) {
    $totalAspirasiRealtime = 4;
}
if ($totalAspirasiRealtime < 4) {
    $totalAspirasiRealtime = 4; // Baseline data terdata
}

// Ambil Berita Terkait untuk Section 7
try {
    $stmtNews = $pdo->query("SELECT id, judul, ringkasan, foto, kategori, created_at FROM berita ORDER BY created_at DESC LIMIT 4");
    $relatedNews = $stmtNews->fetchAll();
} catch (Exception $e) {
    $relatedNews = [];
}

// Ambil Pengaturan Gambar Hero & Banner CTA (Dapat diganti via Admin Pengaturan)
$bgHero  = get_pengaturan($pdo, 'bg_hero', 'assets/images/banner/hero_bg_pure_landscape.jpg');
$fotoCta = get_pengaturan($pdo, 'foto_sapa_warga', 'assets/images/banner/dialog_warga.jpg');
?>

<!-- SECTION 1: HERO BANNER STANDAR (BOUNDED IN CONTAINER-CUSTOM SEPERTI BERANDA) -->
<div class="container-custom pt-3 pb-1">
  <section class="prog-hero-card" style="background-image: url('<?= e($bgHero) ?>');">
    <div class="prog-hero-inner position-relative">
      <div class="row align-items-center">
        <div class="col-lg-8 col-xl-7">
          <span class="prog-hero-badge">
            PROGRAM KERJA
          </span>
          <h1 class="prog-hero-title">
            Bersama Wujudkan Tampirkulon yang<br class="d-none d-md-inline"> Maju, Sejahtera dan Lestari
          </h1>
          <p class="prog-hero-subtitle">
            Program kerja ini disusun berdasarkan potensi desa, kebutuhan masyarakat, dan data yang ada. Dengan kolaborasi, kita wujudkan perubahan nyata untuk Tampirkulon.
          </p>
          <div class="prog-hero-cta">
            <a href="#programPrioritas" class="btn btn-success btn-sm rounded-pill fw-semibold shadow-sm px-3">
              Lihat Program &rarr;
            </a>
            <a href="index.php?page=sapa-warga" class="btn btn-light btn-sm rounded-pill fw-semibold px-3 text-dark shadow-sm">
              <i class="bi bi-chat-dots me-1 text-success"></i> Sapa Warga
            </a>
          </div>
        </div>
        <div class="col-lg-4 col-xl-5 text-center text-lg-end mt-4 mt-lg-0">
          <div class="prog-hero-slogan-box">
            <span class="prog-hero-watermark">
              &ldquo;Desa Kuat, Warganya Hebat&rdquo;
            </span>
            <div class="prog-hero-slogan-meta">
              <i class="bi bi-check2-circle text-success me-1"></i> Komitmen Bersama Edy Susanto (No. Urut 2)
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- SECTION 2: STATISTIK SINGKAT (STATS BAR ULTRA COMPACT & DATA REALTIME) -->
<section class="prog-stats-section">
  <div class="container-custom">
    <div class="prog-stats-bar-compact">
      <div class="row g-2 g-md-0 align-items-center">
        <!-- Item 1: 7 Bidang Prioritas Realtime -->
        <div class="col-6 col-md-3">
          <div class="prog-stat-compact-item d-flex align-items-center justify-content-center gap-2">
            <div class="prog-stat-mini-icon">
              <i class="bi bi-briefcase-fill"></i>
            </div>
            <div class="text-start">
              <div class="prog-stat-mini-val text-dark"><?= $totalBidang ?></div>
              <div class="prog-stat-mini-txt">Bidang Prioritas</div>
            </div>
          </div>
        </div>
        <!-- Item 2: Rencana Program Realtime -->
        <div class="col-6 col-md-3 border-start-md">
          <div class="prog-stat-compact-item d-flex align-items-center justify-content-center gap-2">
            <div class="prog-stat-mini-icon">
              <i class="bi bi-journal-text"></i>
            </div>
            <div class="text-start">
              <div class="prog-stat-mini-val text-dark"><?= $totalRencanaAksi ?>+</div>
              <div class="prog-stat-mini-txt">Rencana Program</div>
            </div>
          </div>
        </div>
        <!-- Item 3: Data & Aspirasi Realtime -->
        <div class="col-6 col-md-3 border-start-md">
          <div class="prog-stat-compact-item d-flex align-items-center justify-content-center gap-2">
            <div class="prog-stat-mini-icon">
              <i class="bi bi-chat-heart-fill"></i>
            </div>
            <div class="text-start">
              <div class="prog-stat-mini-val text-dark"><?= $totalAspirasiRealtime ?>+</div>
              <div class="prog-stat-mini-txt">Aspirasi Masuk</div>
            </div>
          </div>
        </div>
        <!-- Item 4: Untuk Semua 6 Dusun Warga Tampirkulon -->
        <div class="col-6 col-md-3 border-start-md">
          <div class="prog-stat-compact-item d-flex align-items-center justify-content-center gap-2">
            <div class="prog-stat-mini-icon">
              <i class="bi bi-geo-alt-fill"></i>
            </div>
            <div class="text-start">
              <div class="prog-stat-mini-val text-dark">6 Dusun</div>
              <div class="prog-stat-mini-txt">Semua Warga</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SECTION 3: 7 BIDANG PROGRAM PRIORITAS + KARTU QUOTE (8 CARDS) -->
<section id="programPrioritas" class="prog-section-spacing-top pb-5 bg-light-subtle">
  <div class="container-custom">
    <!-- Header Section -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-2">
      <div class="d-flex align-items-start gap-3">
        <div class="prog-section-accent-bar flex-shrink-0"></div>
        <div>
          <h2 class="fw-bold fs-3 text-dark mb-1">7 Bidang Program Prioritas</h2>
          <p class="text-muted mb-0 small">
            Program disusun dari potensi, kebutuhan dan harapan masyarakat Tampirkulon.
          </p>
        </div>
      </div>
      <div class="mt-3 mt-md-0">
        <a href="#modalProgramAll" class="btn btn-outline-secondary btn-sm rounded-pill fw-semibold px-3" data-bs-toggle="dropdown" aria-expanded="false">
          Lihat Semua Program <i class="bi bi-chevron-down ms-1"></i>
        </a>
        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3">
          <?php foreach ($programData as $p): ?>
            <li>
              <a class="dropdown-item py-2 small" href="#modalProgram<?= $p['id'] ?>" data-bs-toggle="modal">
                <i class="<?= (strpos($p['icon'], 'fa-') !== false) ? e($p['icon']) : 'bi ' . e($p['icon']) ?> me-2" style="color: <?= e($p['icon_color']) ?>;"></i>
                <?= e($p['bidang']) ?>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>

    <!-- 8 Cards Grid (7 Program + 1 Quote) -->
    <div class="row g-4" id="programGrid">
      <?php foreach ($programData as $p): ?>
      <div class="col-md-6 col-lg-3">
        <div class="card prog-card h-100" style="background-color: <?= e($p['card_bg']) ?>; border-color: <?= e($p['border_color']) ?>;">
          <div class="prog-card-icon-box mb-3" style="background-color: rgba(255,255,255,0.85); color: <?= e($p['icon_color']) ?>;">
            <i class="<?= (strpos($p['icon'], 'fa-') !== false) ? e($p['icon']) : 'bi ' . e($p['icon']) ?>"></i>
          </div>
          
          <h3 class="prog-card-title"><?= e($p['bidang']) ?></h3>
          <p class="prog-card-desc"><?= e($p['sub_desc']) ?></p>
          
          <div class="prog-card-action pt-2">
            <button type="button" class="btn btn-sm btn-white prog-card-detail-btn shadow-sm rounded-pill px-3 py-1" data-bs-toggle="modal" data-bs-target="#modalProgram<?= $p['id'] ?>">
              Lihat Detail <i class="bi bi-arrow-right ms-1"></i>
            </button>
          </div>
        </div>
      </div>
      <?php endforeach; ?>

      <!-- KARTU KE-8: QUOTE KANDIDAT SESUAI MOCKUP -->
      <div class="col-md-6 col-lg-3">
        <div class="card prog-card prog-quote-card h-100">
          <div class="prog-quote-icon mb-2">
            &ldquo;
          </div>
          <p class="prog-quote-text">
            Program ini adalah ikhtiar bersama, bukan janji satu orang.
          </p>
          <div class="prog-quote-signature mt-auto">
            <div class="prog-sig-name">Edy Susanto</div>
            <div class="prog-sig-role">Calon Kepala Desa</div>
            <div class="prog-sig-num">No. Urut 2</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SECTION 4: HIGHLIGHT POTENSI DESA (PROGRAM BERBASIS POTENSI TAMPIRKULON) -->
<section class="py-4 bg-white">
  <div class="container-custom">
    <!-- Header Section -->
    <div class="d-flex align-items-start gap-3 mb-3">
      <div class="prog-section-accent-bar flex-shrink-0"></div>
      <div>
        <h2 class="fw-bold fs-5 text-dark mb-0">Program Berbasis Potensi Tampirkulon</h2>
        <p class="text-muted mb-0 small">6 potensi unggulan desa yang menjadi fondasi program kerja.</p>
      </div>
    </div>

    <div class="prog-potensi-unified-card p-3 p-lg-4 rounded-4 shadow-sm border">
      <div class="row g-3 align-items-stretch">

        <!-- Sisi Kiri: Banner + Info + CTA -->
        <div class="col-lg-4">
          <div class="d-flex flex-column h-100 gap-3">
            <!-- Banner Foto Utama - aspect-ratio 16:9 tidak terpotong -->
            <div class="prog-potensi-banner-wrap rounded-3 overflow-hidden shadow-sm position-relative">
              <img src="assets/images/banner/hero_bg_clean.jpg"
                   alt="Bentang Alam Tampirkulon"
                   class="prog-potensi-banner-img">
              <div class="prog-potensi-hero-overlay">
                <span class="badge bg-success text-white px-2 py-1 rounded-pill" style="font-size:0.68rem;">
                  <i class="bi bi-geo-alt-fill me-1"></i>Tampirkulon
                </span>
              </div>
            </div>
            <!-- Deskripsi + CTA -->
            <div class="flex-grow-1 d-flex flex-column justify-content-between">
              <p class="text-muted small lh-base mb-2">
                Setiap program dikembangkan dari <strong class="text-dark">potensi nyata</strong> yang ada di desa — mata air, wisata, UMKM, kesenian, pertanian, dan semangat warganya.
              </p>
              <a href="index.php?page=potensi"
                 class="btn btn-success btn-sm rounded-pill fw-semibold px-3 align-self-start">
                <i class="bi bi-arrow-right-circle me-1"></i>Lihat Potensi Desa
              </a>
            </div>
          </div>
        </div>

        <!-- Sisi Kanan: Grid 6 Foto — TIDAK TERPOTONG (aspect-ratio 4:3) -->
        <div class="col-lg-8">
          <div class="row g-2">
            <?php
            $potensiItems = [
              ['img' => 'potensi_mata_air.jpg',   'label' => 'Mata Air',      'icon' => 'bi-droplet-fill',      'color' => '#0288d1'],
              ['img' => 'potensi_tubing.jpg',     'label' => 'Wisata Tubing', 'icon' => 'bi-water',             'color' => '#00838f'],
              ['img' => 'potensi_umkm.jpg',       'label' => 'UMKM Lokal',   'icon' => 'bi-shop-window',       'color' => '#e65100'],
              ['img' => 'potensi_jathilan.jpg',   'label' => 'Jathilan',      'icon' => 'bi-music-note-beamed', 'color' => '#6a1b9a'],
              ['img' => 'potensi_pertanian.jpg',  'label' => 'Pertanian',     'icon' => 'bi-tree-fill',         'color' => '#2e7d32'],
              ['img' => 'potensi_pendidikan.jpg', 'label' => 'Pendidikan',    'icon' => 'bi-mortarboard-fill',  'color' => '#1565c0'],
            ];
            foreach ($potensiItems as $item):
            ?>
            <div class="col-4">
              <div class="prog-potensi-photo-card rounded-3 overflow-hidden shadow-sm position-relative">
                <!-- aspect-ratio 4:3 — foto tampil penuh, tidak terpotong -->
                <div class="prog-potensi-photo-ratio">
                  <img src="assets/images/program/<?= e($item['img']) ?>"
                       alt="<?= e($item['label']) ?>"
                       class="prog-potensi-photo-img">
                </div>
                <!-- Label dengan ikon warna -->
                <div class="prog-potensi-photo-label">
                  <i class="bi <?= $item['icon'] ?>" style="color:<?= $item['color'] ?>;"></i>
                  <span><?= e($item['label']) ?></span>
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

<!-- SECTION 5: ROADMAP PENGEMBANGAN DESA (STEPPER 4 TAHAPAN SESUAI MOCKUP) -->
<section class="py-5 bg-light-subtle">
  <div class="container-custom">
    <!-- Header Section -->
    <div class="d-flex align-items-start gap-3 mb-4 pb-2">
      <div class="prog-section-accent-bar flex-shrink-0"></div>
      <div>
        <h2 class="fw-bold fs-3 text-dark mb-1">Roadmap Pengembangan Desa</h2>
        <p class="text-muted mb-0 small">
          Tahapan pelaksanaan program secara bertahap dan terukur.
        </p>
      </div>
    </div>

    <!-- Stepper 4 Tahapan -->
    <div class="prog-roadmap-grid">
      <div class="row g-4">
        <!-- Tahap 1: Pendataan (0–6 bulan) - Hijau -->
        <div class="col-md-6 col-lg-3">
          <div class="prog-stepper-card h-100">
            <div class="d-flex align-items-center gap-2 mb-3">
              <div class="prog-step-circle bg-success text-white fw-bold">1</div>
              <div>
                <h4 class="prog-step-title mb-0">Pendataan</h4>
                <small class="prog-step-duration text-success fw-semibold">0&ndash;6 bulan</small>
              </div>
            </div>
            <ul class="prog-step-list list-unstyled mb-0">
              <li><i class="bi bi-diamond-fill text-success"></i> Pendataan potensi</li>
              <li><i class="bi bi-diamond-fill text-success"></i> Database UMKM</li>
              <li><i class="bi bi-diamond-fill text-success"></i> Pemetaan lokasi</li>
              <li><i class="bi bi-diamond-fill text-success"></i> Baseline indikator</li>
            </ul>
          </div>
        </div>

        <!-- Tahap 2: Penguatan (6–18 bulan) - Biru -->
        <div class="col-md-6 col-lg-3">
          <div class="prog-stepper-card h-100">
            <div class="d-flex align-items-center gap-2 mb-3">
              <div class="prog-step-circle bg-primary text-white fw-bold">2</div>
              <div>
                <h4 class="prog-step-title mb-0">Penguatan</h4>
                <small class="prog-step-duration text-primary fw-semibold">6&ndash;18 bulan</small>
              </div>
            </div>
            <ul class="prog-step-list list-unstyled mb-0">
              <li><i class="bi bi-diamond-fill text-primary"></i> Pendampingan</li>
              <li><i class="bi bi-diamond-fill text-primary"></i> Peningkatan kapasitas</li>
              <li><i class="bi bi-diamond-fill text-primary"></i> Digitalisasi</li>
              <li><i class="bi bi-diamond-fill text-primary"></i> Kolaborasi</li>
            </ul>
          </div>
        </div>

        <!-- Tahap 3: Pengembangan (18–36 bulan) - Teal / Biru Tua -->
        <div class="col-md-6 col-lg-3">
          <div class="prog-stepper-card h-100">
            <div class="d-flex align-items-center gap-2 mb-3">
              <div class="prog-step-circle bg-info-subtle text-info-emphasis fw-bold" style="background-color: #00838f !important; color: #fff !important;">3</div>
              <div>
                <h4 class="prog-step-title mb-0">Pengembangan</h4>
                <small class="prog-step-duration fw-semibold" style="color: #00838f;">18&ndash;36 bulan</small>
              </div>
            </div>
            <ul class="prog-step-list list-unstyled mb-0">
              <li><i class="bi bi-diamond-fill" style="color: #00838f;"></i> Integrasi wisata</li>
              <li><i class="bi bi-diamond-fill" style="color: #00838f;"></i> Penguatan ekonomi</li>
              <li><i class="bi bi-diamond-fill" style="color: #00838f;"></i> Pemasaran</li>
              <li><i class="bi bi-diamond-fill" style="color: #00838f;"></i> Evaluasi indikator</li>
            </ul>
          </div>
        </div>

        <!-- Tahap 4: Keberlanjutan (36–60 bulan) - Ungu -->
        <div class="col-md-6 col-lg-3">
          <div class="prog-stepper-card h-100">
            <div class="d-flex align-items-center gap-2 mb-3">
              <div class="prog-step-circle bg-purple text-white fw-bold" style="background-color: #7b1fa2 !important;">4</div>
              <div>
                <h4 class="prog-step-title mb-0">Keberlanjutan</h4>
                <small class="prog-step-duration fw-semibold" style="color: #7b1fa2;">36&ndash;60 bulan</small>
              </div>
            </div>
            <ul class="prog-step-list list-unstyled mb-0">
              <li><i class="bi bi-diamond-fill" style="color: #7b1fa2;"></i> Evaluasi program</li>
              <li><i class="bi bi-diamond-fill" style="color: #7b1fa2;"></i> Replikasi yang berhasil</li>
              <li><i class="bi bi-diamond-fill" style="color: #7b1fa2;"></i> Penguatan kelembagaan</li>
              <li><i class="bi bi-diamond-fill" style="color: #7b1fa2;"></i> Keberlanjutan pembiayaan</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SECTION 6: TRANSPARANSI & PROGRES (SESUAI MOCKUP) -->
<section class="py-5 bg-white">
  <div class="container-custom">
    <!-- Header Section -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-2">
      <div class="d-flex align-items-start gap-3">
        <div class="prog-section-accent-bar flex-shrink-0"></div>
        <div>
          <h2 class="fw-bold fs-3 text-dark mb-1">Transparansi &amp; Progres</h2>
          <p class="text-muted mb-0 small">
            Kami berkomitmen menjalankan program secara terbuka dan terukur.
          </p>
        </div>
      </div>
      <div class="mt-3 mt-md-0">
        <a href="index.php?page=sapa-warga#transparansi" class="btn btn-outline-secondary btn-sm rounded-pill fw-semibold px-3">
          Lihat Semua Progres &rarr;
        </a>
      </div>
    </div>

    <!-- 4 Cards Horisontal Sesuai Mockup -->
    <div class="row g-3 g-md-4">
      <!-- 1. 5 Program Persiapan (Hijau) -->
      <div class="col-6 col-md-3">
        <div class="prog-stat-box p-3 rounded-4 d-flex align-items-center gap-3" style="background-color: #e8f5e9;">
          <div class="prog-stat-box-icon bg-success text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0">
            <i class="bi bi-check-lg"></i>
          </div>
          <div>
            <div class="prog-stat-box-num text-dark fw-bold">5</div>
            <div class="prog-stat-box-label text-muted small">Program Persiapan</div>
          </div>
        </div>
      </div>

      <!-- 2. 3 Program Berjalan (Biru) -->
      <div class="col-6 col-md-3">
        <div class="prog-stat-box p-3 rounded-4 d-flex align-items-center gap-3" style="background-color: #e3f2fd;">
          <div class="prog-stat-box-icon bg-primary text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0">
            <i class="bi bi-gear-fill"></i>
          </div>
          <div>
            <div class="prog-stat-box-num text-dark fw-bold">3</div>
            <div class="prog-stat-box-label text-muted small">Program Berjalan</div>
          </div>
        </div>
      </div>

      <!-- 3. 2 Program Direncanakan (Oranye) -->
      <div class="col-6 col-md-3">
        <div class="prog-stat-box p-3 rounded-4 d-flex align-items-center gap-3" style="background-color: #fff3e0;">
          <div class="prog-stat-box-icon text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="background-color: #f57c00;">
            <i class="bi bi-clock-fill"></i>
          </div>
          <div>
            <div class="prog-stat-box-num text-dark fw-bold">2</div>
            <div class="prog-stat-box-label text-muted small">Program Direncanakan</div>
          </div>
        </div>
      </div>

      <!-- 4. 12 Total Rencana Kegiatan (Ungu) -->
      <div class="col-6 col-md-3">
        <div class="prog-stat-box p-3 rounded-4 d-flex align-items-center gap-3" style="background-color: #f3e5f5;">
          <div class="prog-stat-box-icon text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="background-color: #7b1fa2;">
            <i class="bi bi-bar-chart-fill"></i>
          </div>
          <div>
            <div class="prog-stat-box-num text-dark fw-bold">12</div>
            <div class="prog-stat-box-label text-muted small">Total Rencana Kegiatan</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SECTION 7: BERITA & KEGIATAN TERKAIT PROGRAM (SESUAI MOCKUP) -->
<section class="py-5 bg-light-subtle">
  <div class="container-custom">
    <!-- Header Section -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-2">
      <div class="d-flex align-items-start gap-3">
        <div class="prog-section-accent-bar flex-shrink-0"></div>
        <div>
          <h2 class="fw-bold fs-3 text-dark mb-1">Berita &amp; Kegiatan Terkait Program</h2>
          <p class="text-muted mb-0 small">Update terbaru seputar pelaksanaan program dan kegiatan masyarakat.</p>
        </div>
      </div>
      <div class="mt-3 mt-md-0">
        <a href="index.php?page=berita" class="btn btn-outline-secondary btn-sm rounded-pill fw-semibold px-3">
          Lihat Semua Berita &rarr;
        </a>
      </div>
    </div>

    <div class="row g-4">
      <?php if (!empty($relatedNews)): ?>
        <?php foreach ($relatedNews as $n): ?>
        <div class="col-md-6 col-lg-3">
          <div class="card prog-news-card h-100">
            <div class="prog-news-img-wrap">
              <?php if (!empty($n['foto'])): ?>
                <img src="<?= e($n['foto']) ?>" alt="<?= e($n['judul']) ?>" class="w-100 h-100 object-fit-cover">
              <?php else: ?>
                <div class="prog-news-placeholder d-flex align-items-center justify-content-center h-100 bg-secondary-subtle text-muted">
                  <i class="bi bi-newspaper fs-1"></i>
                </div>
              <?php endif; ?>
            </div>
            <div class="prog-news-body d-flex flex-column">
              <small class="text-muted mb-1">
                <?= format_tanggal_id($n['created_at']) ?>
              </small>
              <h5 class="prog-news-title"><?= e($n['judul']) ?></h5>
              <p class="prog-news-desc flex-grow-1"><?= e($n['ringkasan']) ?></p>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      <?php else: ?>
        <!-- Fallback 4 kartu berita sesuai mockup -->
        <div class="col-md-6 col-lg-3">
          <div class="card prog-news-card h-100">
            <div class="prog-news-img-wrap">
              <img src="assets/images/program/potensi_pertanian.jpg" alt="Pembentukan Pokdarwis" class="w-100 h-100 object-fit-cover">
            </div>
            <div class="prog-news-body d-flex flex-column">
              <small class="text-muted mb-1">12 Jul 2026</small>
              <h5 class="prog-news-title">Pembentukan Pokdarwis Desa Tampirkulon</h5>
              <p class="prog-news-desc flex-grow-1">Melibatkan 26 peserta dan 19 pengurus dalam pengembangan potensi desa.</p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="card prog-news-card h-100">
            <div class="prog-news-img-wrap">
              <img src="assets/images/program/potensi_mata_air.jpg" alt="Kegiatan Bersih Sumber Air" class="w-100 h-100 object-fit-cover">
            </div>
            <div class="prog-news-body d-flex flex-column">
              <small class="text-muted mb-1">5 Jul 2026</small>
              <h5 class="prog-news-title">Kegiatan Bersih Sumber Air</h5>
              <p class="prog-news-desc flex-grow-1">Warga bersama menjaga kelestarian lingkungan dan debit air alami.</p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="card prog-news-card h-100">
            <div class="prog-news-img-wrap">
              <img src="assets/images/program/potensi_umkm.jpg" alt="Pelatihan UMKM Lokal" class="w-100 h-100 object-fit-cover">
            </div>
            <div class="prog-news-body d-flex flex-column">
              <small class="text-muted mb-1">28 Jun 2026</small>
              <h5 class="prog-news-title">Pelatihan UMKM Lokal</h5>
              <p class="prog-news-desc flex-grow-1">Peningkatan kapasitas pelaku usaha olahan tempe dan jajanan desa.</p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="card prog-news-card h-100">
            <div class="prog-news-img-wrap">
              <img src="assets/images/program/potensi_tubing.jpg" alt="Turnamen Sepak Bola Desa" class="w-100 h-100 object-fit-cover">
            </div>
            <div class="prog-news-body d-flex flex-column">
              <small class="text-muted mb-1">20 Jun 2026</small>
              <h5 class="prog-news-title">Turnamen Olahraga Pemuda Desa</h5>
              <p class="prog-news-desc flex-grow-1">Semangat olahraga antardusun untuk generasi muda yang sehat dan rukun.</p>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- SECTION 8: BANNER CTA SAPA WARGA (MODEL & UKURAN SAMA DENGAN POTENSI) -->
<div class="container-custom py-4 mb-2">
  <section class="potensi-cta-card" style="background-image: url('<?= e($bgHero) ?>');">
    <div class="potensi-cta-overlay">
      <div class="row align-items-center g-3">
        <div class="col-lg-8">
          <h3 class="potensi-cta-title">Punya Ide, Saran atau Aspirasi?</h3>
          <p class="potensi-cta-subtitle">
            Sampaikan langsung melalui Sapa Warga. Suara Anda sangat berarti untuk kemajuan Desa Tampirkulon.
          </p>
        </div>
        <div class="col-lg-4 text-lg-end">
          <a href="index.php?page=sapa-warga#formAspirasi" class="potensi-cta-btn">
            <i class="bi bi-send-fill"></i> Sapa Warga Sekarang
          </a>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- MODAL DETAIL LENGKAP UNTUK 7 PROGRAM PRIORITAS -->
<?php foreach ($programData as $p): ?>
<div class="modal fade" id="modalProgram<?= $p['id'] ?>" tabindex="-1" aria-labelledby="modalLabelProgram<?= $p['id'] ?>" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
      <!-- Modal Header -->
      <div class="modal-header text-white border-0 py-3 px-4" style="background-color: <?= e($p['icon_color']) ?>;">
        <div class="d-flex align-items-center gap-3">
          <div class="prog-modal-icon-wrap bg-white text-dark d-flex align-items-center justify-content-center rounded-circle" style="width: 44px; height: 44px; color: <?= e($p['icon_color']) ?> !important;">
            <i class="<?= (strpos($p['icon'], 'fa-') !== false) ? e($p['icon']) : 'bi ' . e($p['icon']) ?> fs-5"></i>
          </div>
          <div>
            <span class="badge bg-white-subtle text-white rounded-pill px-2 py-0 small mb-1">
              Program #0<?= $p['id'] ?> &bull; <?= e($p['kategori_label']) ?>
            </span>
            <h5 class="modal-title fw-bold text-white mb-0" id="modalLabelProgram<?= $p['id'] ?>">
              <?= e($p['bidang']) ?>
            </h5>
          </div>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body p-4 p-md-4">
        <!-- Status & Sumber Badge -->
        <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center p-3 rounded-3 mb-4" style="background-color: <?= e($p['card_bg']) ?>; border: 1px solid <?= e($p['border_color']) ?>;">
          <div>
            <small class="text-muted d-block">Status Pelaksanaan:</small>
            <strong style="color: <?= e($p['icon_color']) ?>;"><i class="bi bi-check-circle me-1"></i> <?= e($p['status']) ?></strong>
          </div>
          <div class="text-md-end">
            <small class="text-muted d-block">Basis Penyusunan:</small>
            <span class="badge bg-white text-dark border"><i class="bi bi-bookmark-check me-1"></i> <?= e($p['sumber']) ?></span>
          </div>
        </div>

        <!-- 1. Kondisi Faktual Lapangan -->
        <div class="mb-4">
          <h6 class="fw-bold text-dark d-flex align-items-center gap-2 mb-2">
            <i class="bi bi-geo-alt-fill text-danger"></i> 1. Kondisi Saat Ini &amp; Fakta Lapangan
          </h6>
          <p class="text-muted small leading-relaxed ps-4 mb-0">
            <?= e($p['kondisi_faktual']) ?>
          </p>
        </div>

        <!-- 2. Potensi & Kebutuhan Warga -->
        <div class="mb-4">
          <h6 class="fw-bold text-dark d-flex align-items-center gap-2 mb-2">
            <i class="bi bi-lightbulb-fill text-warning"></i> 2. Potensi &amp; Kebutuhan yang Diangkat
          </h6>
          <p class="text-muted small leading-relaxed ps-4 mb-0">
            <?= e($p['potensi_kebutuhan']) ?>
          </p>
        </div>

        <!-- 3. Rencana Aksi Prioritas -->
        <div class="mb-4">
          <h6 class="fw-bold text-dark d-flex align-items-center gap-2 mb-2">
            <i class="bi bi-list-check" style="color: <?= e($p['icon_color']) ?>;"></i> 3. Rencana Aksi Strategis
          </h6>
          <ul class="list-unstyled ps-4 mb-0">
            <?php foreach ($p['rencana_aksi'] as $aksi): ?>
            <li class="d-flex align-items-start gap-2 mb-2 small text-muted">
              <i class="bi bi-check2-circle text-success mt-1"></i>
              <span><?= e($aksi) ?></span>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>

        <!-- 4. Indikator & Target Usulan Terukur -->
        <div class="mb-3">
          <h6 class="fw-bold text-dark d-flex align-items-center gap-2 mb-2">
            <i class="bi bi-bullseye text-primary"></i> 4. Indikator &amp; Target Usulan Terukur
          </h6>
          <div class="p-3 bg-light rounded-3 border-start border-3" style="border-color: <?= e($p['icon_color']) ?> !important;">
            <ul class="list-unstyled mb-0 ps-1">
              <?php foreach ($p['indikator_target'] as $target): ?>
              <li class="d-flex align-items-start gap-2 mb-1 small text-dark">
                <i class="bi bi-arrow-right-short text-primary fs-6"></i>
                <span><?= e($target) ?></span>
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
      </div>

      <!-- Modal Footer -->
      <div class="modal-footer bg-light border-0 py-3 px-4 d-flex justify-content-between align-items-center">
        <a href="index.php?page=sapa-warga#formAspirasi" class="btn btn-sm btn-outline-danger rounded-pill fw-bold">
          <i class="bi bi-chat-dots me-1"></i> Beri Masukan untuk Bidang Ini
        </a>
        <button type="button" class="btn btn-sm btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
<?php endforeach; ?>
