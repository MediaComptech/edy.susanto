<?php
/**
 * Halaman 7 Bidang Program Prioritas & Rencana Pengembangan Desa
 * Calon Kepala Desa Tampirkulon - Edy Susanto (No. Urut 2)
 *
 * Implementasi berdasarkan update_program.md dan standar UI/Program
 */
if (!defined('APP_NAME')) {
    require_once __DIR__ . '/../includes/config.php';
}

// Data Lengkap 7 Bidang Program Kerja Prioritas & Faktual
$programData = [
    1 => [
        'id' => 1,
        'bidang' => 'Pertanian Modern & Ketahanan Pangan',
        'kategori' => 'pertanian-wisata',
        'kategori_label' => 'Pertanian & Wisata',
        'icon' => 'bi-flower1',
        'card_bg' => '#e8f5e9',
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
        'bidang' => 'Pemberdayaan UMKM & Ekonomi Kreatif',
        'kategori' => 'ekonomi-umkm',
        'kategori_label' => 'Ekonomi & UMKM',
        'icon' => 'bi-shop',
        'card_bg' => '#fff3e0',
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
        'bidang' => 'Pengembangan Desa Wisata Terpadu',
        'kategori' => 'pertanian-wisata',
        'kategori_label' => 'Pertanian & Wisata',
        'icon' => 'bi-compass',
        'card_bg' => '#e1f5fe',
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
        'bidang' => 'Pendidikan Berkualitas & Karakter Generasi',
        'kategori' => 'sdm-pemuda',
        'kategori_label' => 'SDM & Pemuda',
        'icon' => 'bi-mortarboard',
        'card_bg' => '#f3e5f5',
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
        'bidang' => 'Pemberdayaan Pemuda, Olahraga & Budaya',
        'kategori' => 'sdm-pemuda',
        'kategori_label' => 'SDM & Pemuda',
        'icon' => 'bi-people',
        'card_bg' => '#ffebee',
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
        'bidang' => 'Infrastruktur Ramah Lingkungan & Sanitasi',
        'kategori' => 'pelayanan-lingkungan',
        'kategori_label' => 'Pelayanan & Lingkungan',
        'icon' => 'bi-tree',
        'card_bg' => '#e8f8f0',
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
        'bidang' => 'Pelayanan Publik Cepat, Transparan & Akuntabel',
        'kategori' => 'pelayanan-lingkungan',
        'kategori_label' => 'Pelayanan & Lingkungan',
        'icon' => 'bi-shield-check',
        'card_bg' => '#fff8e1',
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

// Ambil Berita Terkait untuk Section 7
try {
    $stmtNews = $pdo->query("SELECT id, judul, ringkasan, foto, kategori, created_at FROM berita ORDER BY created_at DESC LIMIT 4");
    $relatedNews = $stmtNews->fetchAll();
} catch (Exception $e) {
    $relatedNews = [];
}
?>

<!-- SECTION 1: HERO BANNER DENGAN BACKGROUND ALAM & WATERMARK -->
<section class="prog-hero-section">
  <div class="container-custom position-relative">
    <div class="row align-items-center">
      <div class="col-lg-8 col-xl-7">
        <span class="prog-hero-badge">
          <i class="bi bi-stars me-1 text-warning"></i> PROGRAM KERJA &amp; RENCANA PENGEMBANGAN DESA
        </span>
        <h1 class="prog-hero-title">
          Membangun Tampirkulon yang Maju, Sejahtera, dan Berkelanjutan
        </h1>
        <p class="prog-hero-subtitle">
          Rencana strategis berbasis potensi lokal, kebutuhan riil warga, dan prinsip tata kelola pemerintahan desa yang transparan, amanah, dan akuntabel.
        </p>
        <div class="prog-hero-cta">
          <a href="#programPrioritas" class="btn btn-danger btn-lg rounded-pill fw-bold shadow-sm">
            <i class="bi bi-grid-fill me-2"></i> Jelajahi 7 Program
          </a>
          <a href="index.php?page=sapa-warga#formAspirasi" class="btn btn-outline-light btn-lg rounded-pill fw-bold">
            <i class="bi bi-chat-quote me-2"></i> Sampaikan Masukan
          </a>
        </div>
      </div>
      <div class="col-lg-4 col-xl-5 text-center text-lg-end mt-4 mt-lg-0">
        <div class="prog-hero-slogan-box">
          <div class="prog-hero-watermark">
            &ldquo;Desa Kuat, Warganya Hebat&rdquo;
          </div>
          <p class="text-white-50 small mb-0 mt-2">
            <i class="bi bi-check2-circle text-success me-1"></i> Komitmen Bersama Edy Susanto (No. Urut 2)
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SECTION 2: BAR 4 STATISTIK SINGKAT -->
<section class="prog-stats-section">
  <div class="container-custom">
    <div class="prog-stats-bar">
      <div class="row g-3 g-md-4 text-center">
        <div class="col-6 col-md-3">
          <div class="prog-stat-item">
            <div class="prog-stat-number text-danger">7</div>
            <div class="prog-stat-label">Bidang Program Prioritas</div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="prog-stat-item">
            <div class="prog-stat-number text-success">6</div>
            <div class="prog-stat-label">Dusun Terjangkau Merata</div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="prog-stat-item">
            <div class="prog-stat-number text-primary">100%</div>
            <div class="prog-stat-label">Berbasis Aspirasi Warga</div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="prog-stat-item">
            <div class="prog-stat-number text-warning">4</div>
            <div class="prog-stat-label">Tahapan Roadmap Terukur</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SECTION 3: 7 BIDANG PROGRAM PRIORITAS + KARTU QUOTE (8 CARDS) -->
<section id="programPrioritas" class="py-5 bg-light-subtle">
  <div class="container-custom">
    <div class="text-center max-w-700 mx-auto mb-4">
      <span class="badge bg-danger-subtle text-danger fw-bold px-3 py-2 rounded-pill mb-2">
        <i class="bi bi-bullseye me-1"></i> FOKUS STRATEGIS DESA
      </span>
      <h2 class="fw-bold display-6 text-dark mb-2">7 Bidang Program Prioritas</h2>
      <p class="text-muted">
        Gagasan aksi konkret yang dirumuskan secara partisipatif untuk menjawab persoalan dan mengangkat martabat warga Tampirkulon.
      </p>
    </div>

    <!-- Filter Kategori Tabs -->
    <div class="prog-filter-tabs text-center mb-4">
      <button type="button" class="btn prog-filter-btn active" data-filter="all">Semua Program (7)</button>
      <button type="button" class="btn prog-filter-btn" data-filter="ekonomi-umkm">Ekonomi &amp; UMKM</button>
      <button type="button" class="btn prog-filter-btn" data-filter="pertanian-wisata">Pertanian &amp; Wisata</button>
      <button type="button" class="btn prog-filter-btn" data-filter="sdm-pemuda">SDM &amp; Pemuda</button>
      <button type="button" class="btn prog-filter-btn" data-filter="pelayanan-lingkungan">Pelayanan &amp; Lingkungan</button>
    </div>

    <!-- 8 Cards Grid -->
    <div class="row g-4" id="programGrid">
      <?php foreach ($programData as $p): ?>
      <div class="col-md-6 col-lg-4 prog-grid-item" data-category="<?= e($p['kategori']) ?>">
        <div class="card prog-card h-100" style="background-color: <?= e($p['card_bg']) ?>; border-color: <?= e($p['border_color']) ?>;">
          <div class="prog-card-top">
            <div class="prog-card-icon-box" style="background-color: <?= e($p['icon_color']) ?>;">
              <i class="bi <?= e($p['icon']) ?>"></i>
            </div>
            <div class="prog-card-header-info">
              <span class="prog-card-num-badge" style="color: <?= e($p['icon_color']) ?>; border-color: <?= e($p['border_color']) ?>;">
                #0<?= $p['id'] ?>
              </span>
              <span class="prog-card-cat-tag"><?= e($p['kategori_label']) ?></span>
            </div>
          </div>
          
          <h3 class="prog-card-title"><?= e($p['bidang']) ?></h3>
          <p class="prog-card-desc"><?= e($p['ringkasan']) ?></p>
          
          <div class="prog-card-action">
            <button type="button" class="btn btn-sm prog-card-detail-btn" data-bs-toggle="modal" data-bs-target="#modalProgram<?= $p['id'] ?>" style="color: <?= e($p['icon_color']) ?>;">
              Lihat Rencana Aksi &amp; Detail <i class="bi bi-arrow-right ms-1"></i>
            </button>
          </div>
        </div>
      </div>
      <?php endforeach; ?>

      <!-- KARTU KE-8: QUOTE KANDIDAT -->
      <div class="col-md-6 col-lg-4 prog-grid-item" data-category="all quote">
        <div class="card prog-card prog-quote-card h-100">
          <div class="prog-quote-icon">
            <i class="bi bi-quote"></i>
          </div>
          <p class="prog-quote-text">
            &ldquo;Membangun desa bukan tentang menebar janji muluk, tetapi tentang mendengarkan dengan hati, merencanakan bersama warga, dan mengeksekusi dengan amanah.&rdquo;
          </p>
          <div class="prog-quote-author">
            <strong>Edy Susanto</strong>
            <span>Calon Kepala Desa Tampirkulon • No. Urut 2</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SECTION 4: PROGRAM BERBASIS POTENSI TAMPIRKULON -->
<section class="py-5 bg-white">
  <div class="container-custom">
    <div class="text-center max-w-700 mx-auto mb-5">
      <span class="badge bg-success-subtle text-success fw-bold px-3 py-2 rounded-pill mb-2">
        <i class="bi bi-geo-alt-fill me-1"></i> KEARIFAN &amp; POTENSI ASLI
      </span>
      <h2 class="fw-bold display-6 text-dark mb-2">Program Berbasis Potensi Tampirkulon</h2>
      <p class="text-muted">
        Bukan konsep dari luar, program kerja ini berakar langsung pada kekayaan alam, tradisi budaya, dan mata pencaharian warga di 6 dusun Tampirkulon.
      </p>
    </div>

    <!-- Featured Potensi Card (Tuk Lanang / Tuk Putri & Tubing) -->
    <div class="card prog-potensi-featured border-0 mb-5">
      <div class="row g-0 align-items-center">
        <div class="col-lg-6">
          <div class="prog-potensi-featured-img-wrap">
            <img src="assets/images/program/potensi_mata_air.jpg" alt="Mata Air Tuk Lanang dan Tuk Putri" class="img-fluid w-100 h-100 object-fit-cover">
          </div>
        </div>
        <div class="col-lg-6 p-4 p-md-5">
          <div class="d-flex flex-wrap gap-2 mb-3">
            <span class="badge bg-success text-white px-3 py-1 rounded-pill">Wisata &amp; Konservasi</span>
            <span class="badge bg-primary-subtle text-primary px-3 py-1 rounded-pill">Pokdarwis 2026 (19 Pengurus)</span>
          </div>
          <h3 class="fw-bold text-dark mb-3">Pengembangan Koridor Wisata Sumber Air &amp; Tubing Tampirkulon</h3>
          <p class="text-muted mb-4 leading-relaxed">
            Integrasi mata air alami <strong>Tuk Lanang &amp; Tuk Putri (0,33 km)</strong> dengan rute susur sungai <strong>Tubing Tampirkulon (1,89 km)</strong>. Ditopang kesiapan pengurus Pokdarwis desa, kawasan ini akan dikembangkan menjadi pusat rekreasi keluarga yang asri, aman, dan mendongkrak omzet ekonomi warung warga sekitar.
          </p>
          <div class="row g-3">
            <div class="col-sm-6">
              <div class="p-3 bg-light rounded-3 border-start border-3 border-success">
                <strong class="d-block text-dark small mb-1"><i class="bi bi-droplet-half text-success me-1"></i> Pelestarian Air</strong>
                <small class="text-muted">Penjagaan debit mata air abadi untuk irigasi sawah dan konsumsi.</small>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="p-3 bg-light rounded-3 border-start border-3 border-primary">
                <strong class="d-block text-dark small mb-1"><i class="bi bi-cash-stack text-primary me-1"></i> Ekonomi Wisata</strong>
                <small class="text-muted">Pemberdayaan pemuda pemandu tubing dan stan kuliner lokal.</small>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- 6 Grid Thumbnails Potensi Riil Tampirkulon -->
    <div class="row g-4">
      <div class="col-md-6 col-lg-4">
        <div class="prog-potensi-thumb-card">
          <div class="prog-potensi-thumb-img">
            <img src="assets/images/program/potensi_mata_air.jpg" alt="Tuk Lanang dan Tuk Putri" class="w-100 h-100 object-fit-cover">
          </div>
          <div class="prog-potensi-thumb-body">
            <h5 class="fw-bold text-dark mb-1">Mata Air Tuk Lanang &amp; Tuk Putri</h5>
            <small class="text-success fw-semibold d-block mb-2"><i class="bi bi-geo-alt me-1"></i> 0,33 km dari Pusat Dusun</small>
            <p class="text-muted small mb-0">Cagar konservasi air bersih abadi yang mengalir ke areal persawahan dan permukiman warga.</p>
          </div>
        </div>
      </div>

      <div class="col-md-6 col-lg-4">
        <div class="prog-potensi-thumb-card">
          <div class="prog-potensi-thumb-img">
            <img src="assets/images/program/potensi_tubing.jpg" alt="Wisata Tubing Tampirkulon" class="w-100 h-100 object-fit-cover">
          </div>
          <div class="prog-potensi-thumb-body">
            <h5 class="fw-bold text-dark mb-1">Wisata Tubing Tampirkulon</h5>
            <small class="text-primary fw-semibold d-block mb-2"><i class="bi bi-water me-1"></i> Rute Arung Sungai 1,89 km</small>
            <p class="text-muted small mb-0">Daya tarik wisata petualangan ramah keluarga yang siap dipromosikan lebih luas bersama Pokdarwis.</p>
          </div>
        </div>
      </div>

      <div class="col-md-6 col-lg-4">
        <div class="prog-potensi-thumb-card">
          <div class="prog-potensi-thumb-img">
            <img src="assets/images/program/potensi_umkm.jpg" alt="Sentra Keripik Tempe" class="w-100 h-100 object-fit-cover">
          </div>
          <div class="prog-potensi-thumb-body">
            <h5 class="fw-bold text-dark mb-1">Sentra UMKM Keripik Tempe</h5>
            <small class="text-warning-emphasis fw-semibold d-block mb-2"><i class="bi bi-bag-check me-1"></i> Bu Tatik, Pak Budi &amp; Warga</small>
            <p class="text-muted small mb-0">Produksi olahan tempe khas berkualitas tinggi yang siap difasilitasi izin P-IRT, Halal, dan kemasan ritel.</p>
          </div>
        </div>
      </div>

      <div class="col-md-6 col-lg-4">
        <div class="prog-potensi-thumb-card">
          <div class="prog-potensi-thumb-img">
            <img src="assets/images/program/potensi_jathilan.jpg" alt="Kesenian Jathilan Krido Budoyo" class="w-100 h-100 object-fit-cover">
          </div>
          <div class="prog-potensi-thumb-body">
            <h5 class="fw-bold text-dark mb-1">Seni Jathilan &amp; Budaya Warga</h5>
            <small class="text-danger fw-semibold d-block mb-2"><i class="bi bi-music-note-beamed me-1"></i> Paguyuban Krido Budoyo</small>
            <p class="text-muted small mb-0">Pelestarian seni tari tradisional sebagai perekat kegotongroyongan dan pengisi panggung festival desa.</p>
          </div>
        </div>
      </div>

      <div class="col-md-6 col-lg-4">
        <div class="prog-potensi-thumb-card">
          <div class="prog-potensi-thumb-img">
            <img src="assets/images/program/potensi_pertanian.jpg" alt="Lahan Pertanian Tampirkulon" class="w-100 h-100 object-fit-cover">
          </div>
          <div class="prog-potensi-thumb-body">
            <h5 class="fw-bold text-dark mb-1">Hamparan Pertanian Subur</h5>
            <small class="text-success fw-semibold d-block mb-2"><i class="bi bi-flower2 me-1"></i> 6 Dusun Persawahan &amp; Hortikultura</small>
            <p class="text-muted small mb-0">Lumbung pangan desa yang membutuhkan jaminan perbaikan jaringan irigasi dan kemudahan akses pupuk.</p>
          </div>
        </div>
      </div>

      <div class="col-md-6 col-lg-4">
        <div class="prog-potensi-thumb-card">
          <div class="prog-potensi-thumb-img">
            <img src="assets/images/program/potensi_pendidikan.jpg" alt="Pendidikan Dasar Tampirkulon" class="w-100 h-100 object-fit-cover">
          </div>
          <div class="prog-potensi-thumb-body">
            <h5 class="fw-bold text-dark mb-1">Pendidikan Dasar &amp; Karakter</h5>
            <small class="text-secondary fw-semibold d-block mb-2"><i class="bi bi-building me-1"></i> SDN 1-2 &amp; TK Pertiwi 1-2</small>
            <p class="text-muted small mb-0">Fasilitas pembentukan karakter generasi penerus Tampirkulon dengan dukungan beasiswa santunan desa.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SECTION 5: ROADMAP PENGEMBANGAN DESA (STEPPER 4 TAHAPAN) -->
<section class="py-5 bg-light-subtle">
  <div class="container-custom">
    <div class="text-center max-w-700 mx-auto mb-5">
      <span class="badge bg-danger-subtle text-danger fw-bold px-3 py-2 rounded-pill mb-2">
        <i class="bi bi-signpost-split me-1"></i> TAHAPAN EKSEKUSI TERUKUR
      </span>
      <h2 class="fw-bold display-6 text-dark mb-2">Roadmap Pengembangan Desa</h2>
      <p class="text-muted">
        Pembangunan tidak dilakukan serampangan, melainkan melalui 4 tahapan strategis yang terstruktur dari konsolidasi hingga kemandirian desa.
      </p>
    </div>

    <div class="prog-roadmap-wrap">
      <div class="row g-4">
        <!-- Tahap 1 -->
        <div class="col-md-6 col-lg-3">
          <div class="prog-roadmap-step h-100">
            <div class="prog-roadmap-badge">Tahap 1</div>
            <span class="prog-roadmap-period">Bulan 1 &ndash; 6</span>
            <h4 class="prog-roadmap-title">Konsolidasi &amp; Pendataan Riil</h4>
            <p class="prog-roadmap-desc">
              Audit kondisi fisik jalan dan irigasi di 6 dusun, pemetaan legalitas UMKM, penyiapan layanan digital Sapa Warga, serta musyawarah bersama para tokoh masyarakat.
            </p>
          </div>
        </div>

        <!-- Tahap 2 -->
        <div class="col-md-6 col-lg-3">
          <div class="prog-roadmap-step h-100">
            <div class="prog-roadmap-badge">Tahap 2</div>
            <span class="prog-roadmap-period">Tahun 1 &ndash; 2</span>
            <h4 class="prog-roadmap-title">Penguatan Pondasi &amp; Infrastruktur</h4>
            <p class="prog-roadmap-desc">
              Pembersihan dan normalisasi irigasi, pembinaan intensif Pokdarwis 2026, fasilitasi sertifikasi Halal &amp; NIB bagi UMKM, serta pengoperasian sistem pelayanan cepat balai desa.
            </p>
          </div>
        </div>

        <!-- Tahap 3 -->
        <div class="col-md-6 col-lg-3">
          <div class="prog-roadmap-step h-100">
            <div class="prog-roadmap-badge">Tahap 3</div>
            <span class="prog-roadmap-period">Tahun 3 &ndash; 4</span>
            <h4 class="prog-roadmap-title">Akselerasi Ekonomi &amp; Wisata</h4>
            <p class="prog-roadmap-desc">
              Pembangunan display center UMKM di koridor wisata, promosi digital Tubing &amp; Mata Air, penyelenggaraan festival budaya Krido Budoyo tahunan, dan penguatan unit usaha BUMDes.
            </p>
          </div>
        </div>

        <!-- Tahap 4 -->
        <div class="col-md-6 col-lg-3">
          <div class="prog-roadmap-step h-100">
            <div class="prog-roadmap-badge">Tahap 4</div>
            <span class="prog-roadmap-period">Tahun 5 &ndash; 6</span>
            <h4 class="prog-roadmap-title">Kemandirian &amp; Keberlanjutan</h4>
            <p class="prog-roadmap-desc">
              Tercapainya kemandirian kas desa melalui BUMDes produktif, pengelolaan lingkungan bebas sampah liar, dan Tampirkulon menjadi desa percontohan tata kelola transparan di Magelang.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SECTION 6: TRANSPARANSI & PROGRES -->
<section class="py-5 bg-white">
  <div class="container-custom">
    <div class="text-center max-w-700 mx-auto mb-5">
      <span class="badge bg-primary-subtle text-primary fw-bold px-3 py-2 rounded-pill mb-2">
        <i class="bi bi-eye me-1"></i> AKUNTABILITAS PUBLIK
      </span>
      <h2 class="fw-bold display-6 text-dark mb-2">Transparansi &amp; Pengawasan Program</h2>
      <p class="text-muted">
        Kami percaya setiap rupiah dana desa dan setiap butir program kerja adalah amanah rakyat yang harus dipertanggungjawabkan secara terbuka.
      </p>
    </div>

    <div class="row g-4">
      <div class="col-md-6 col-lg-3">
        <div class="prog-transparansi-card text-center">
          <div class="prog-trans-icon text-success">
            <i class="bi bi-check-circle-fill"></i>
          </div>
          <h5 class="fw-bold text-dark mt-3 mb-1">100% Selesai Dirumuskan</h5>
          <p class="text-muted small mb-0">
            Dokumen 7 Program Kerja telah rampung disinkronkan dengan hasil temu warga di 6 dusun.
          </p>
        </div>
      </div>

      <div class="col-md-6 col-lg-3">
        <div class="prog-transparansi-card text-center">
          <div class="prog-trans-icon text-primary">
            <i class="bi bi-clipboard2-data-fill"></i>
          </div>
          <h5 class="fw-bold text-dark mt-3 mb-1">Faktual &amp; Terverifikasi</h5>
          <p class="text-muted small mb-0">
            Disusun berdasarkan fakta lapangan, profil desa terkini, dan data potensi riil yang terukur.
          </p>
        </div>
      </div>

      <div class="col-md-6 col-lg-3">
        <div class="prog-transparansi-card text-center">
          <div class="prog-trans-icon text-warning">
            <i class="bi bi-graph-up-arrow"></i>
          </div>
          <h5 class="fw-bold text-dark mt-3 mb-1">Publikasi APBDes Terbuka</h5>
          <p class="text-muted small mb-0">
            Komitmen penayangan laporan anggaran desa secara berkala di website dan papan informasi balai desa.
          </p>
        </div>
      </div>

      <div class="col-md-6 col-lg-3">
        <div class="prog-transparansi-card text-center">
          <div class="prog-trans-icon text-danger">
            <i class="bi bi-shield-lock-fill"></i>
          </div>
          <h5 class="fw-bold text-dark mt-3 mb-1">Pengawasan Warga 24/7</h5>
          <p class="text-muted small mb-0">
            Kanal Sapa Warga siap menampung tanggapan, koreksi, dan laporan warga secara aman dan terjamin.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SECTION 7: BERITA & KEGIATAN TERKAIT PROGRAM -->
<section class="py-5 bg-light-subtle">
  <div class="container-custom">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4">
      <div>
        <span class="badge bg-danger-subtle text-danger fw-bold px-3 py-2 rounded-pill mb-2">
          <i class="bi bi-newspaper me-1"></i> KABAR &amp; SOSIALISASI
        </span>
        <h2 class="fw-bold display-6 text-dark mb-1">Berita &amp; Kegiatan Terkait Program</h2>
        <p class="text-muted mb-0">Dokumentasi silaturahmi, rembuk warga, dan sosialisasi rencana kerja di dusun-dusun.</p>
      </div>
      <div class="mt-3 mt-md-0">
        <a href="index.php?page=berita" class="btn btn-outline-danger rounded-pill fw-bold btn-sm px-4">
          Lihat Semua Berita <i class="bi bi-arrow-right ms-1"></i>
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
              <span class="prog-news-badge"><?= e($n['kategori'] ?? 'Kegiatan') ?></span>
            </div>
            <div class="prog-news-body d-flex flex-column">
              <small class="text-muted mb-2">
                <i class="bi bi-calendar3 me-1"></i><?= format_tanggal_id($n['created_at']) ?>
              </small>
              <h5 class="prog-news-title"><?= e($n['judul']) ?></h5>
              <p class="prog-news-desc flex-grow-1"><?= e($n['ringkasan']) ?></p>
              <div class="pt-2 border-top">
                <a href="index.php?page=berita" class="text-danger fw-bold small text-decoration-none">
                  Baca Selengkapnya &rarr;
                </a>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      <?php else: ?>
        <!-- Fallback jika belum ada berita di database -->
        <div class="col-md-6 col-lg-3">
          <div class="card prog-news-card h-100">
            <div class="prog-news-img-wrap">
              <img src="assets/images/program/potensi_pertanian.jpg" alt="Rembuk Petani" class="w-100 h-100 object-fit-cover">
              <span class="prog-news-badge">Pertanian</span>
            </div>
            <div class="prog-news-body d-flex flex-column">
              <small class="text-muted mb-2"><i class="bi bi-calendar3 me-1"></i>Terkini</small>
              <h5 class="prog-news-title">Rembuk Tani: Memetakan Kebutuhan Irigasi Tampir Kulon I</h5>
              <p class="prog-news-desc flex-grow-1">Diskusi santai bersama para petani mengenai langkah konkret perbaikan parit dan pembagian air yang adil.</p>
              <div class="pt-2 border-top">
                <a href="index.php?page=sapa-warga#formAspirasi" class="text-danger fw-bold small text-decoration-none">Beri Tanggapan &rarr;</a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="card prog-news-card h-100">
            <div class="prog-news-img-wrap">
              <img src="assets/images/program/potensi_umkm.jpg" alt="Silaturahmi UMKM" class="w-100 h-100 object-fit-cover">
              <span class="prog-news-badge">UMKM</span>
            </div>
            <div class="prog-news-body d-flex flex-column">
              <small class="text-muted mb-2"><i class="bi bi-calendar3 me-1"></i>Terkini</small>
              <h5 class="prog-news-title">Silaturahmi Sentra Keripik Tempe Dusun Dukuh Kidul</h5>
              <p class="prog-news-desc flex-grow-1">Mendengar aspirasi perajin tempe terkait kemudahan perizinan P-IRT dan sarana display oleh-oleh khas.</p>
              <div class="pt-2 border-top">
                <a href="index.php?page=sapa-warga#formAspirasi" class="text-danger fw-bold small text-decoration-none">Beri Tanggapan &rarr;</a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="card prog-news-card h-100">
            <div class="prog-news-img-wrap">
              <img src="assets/images/program/potensi_tubing.jpg" alt="Tinjau Tubing" class="w-100 h-100 object-fit-cover">
              <span class="prog-news-badge">Wisata</span>
            </div>
            <div class="prog-news-body d-flex flex-column">
              <small class="text-muted mb-2"><i class="bi bi-calendar3 me-1"></i>Terkini</small>
              <h5 class="prog-news-title">Tinjauan Jalur Wisata Tubing Bersama Pemuda Karang Taruna</h5>
              <p class="prog-news-desc flex-grow-1">Mengecek kesiapan safety tubing dan kebersihan aliran air untuk menyambut kolaborasi Pokdarwis 2026.</p>
              <div class="pt-2 border-top">
                <a href="index.php?page=sapa-warga#formAspirasi" class="text-danger fw-bold small text-decoration-none">Beri Tanggapan &rarr;</a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="card prog-news-card h-100">
            <div class="prog-news-img-wrap">
              <img src="assets/images/program/potensi_jathilan.jpg" alt="Latihan Budaya" class="w-100 h-100 object-fit-cover">
              <span class="prog-news-badge">Budaya</span>
            </div>
            <div class="prog-news-body d-flex flex-column">
              <small class="text-muted mb-2"><i class="bi bi-calendar3 me-1"></i>Terkini</small>
              <h5 class="prog-news-title">Apresiasi Kesenian Tradisional Bersama Paguyuban Krido Budoyo</h5>
              <p class="prog-news-desc flex-grow-1">Mendorong pelestarian seni Jathilan sebagai magnet budaya desa yang membanggakan generasi muda.</p>
              <div class="pt-2 border-top">
                <a href="index.php?page=sapa-warga#formAspirasi" class="text-danger fw-bold small text-decoration-none">Beri Tanggapan &rarr;</a>
              </div>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- SECTION 8: BANNER CTA SAPA WARGA -->
<section class="py-5 bg-white">
  <div class="container-custom">
    <div class="prog-cta-banner">
      <div class="row align-items-center">
        <div class="col-lg-8">
          <span class="badge bg-white text-success fw-bold px-3 py-2 rounded-pill mb-3">
            <i class="bi bi-chat-heart-fill me-1 text-danger"></i> PARTISIPASI WARGA ADALAH KUNCI
          </span>
          <h3 class="fw-bold text-white mb-2 fs-2">Punya Saran atau Masukan untuk Dusun Anda?</h3>
          <p class="text-white-50 mb-4 mb-lg-0 fs-6 leading-relaxed">
            Program ini adalah awal dari ikhtiar bersama. Jika ada kebutuhan lingkungan dusun Anda yang belum terangkum, sampaikan aspirasi Anda sekarang secara langsung lewat kanal Sapa Warga.
          </p>
        </div>
        <div class="col-lg-4 text-lg-end">
          <div class="d-flex flex-column flex-sm-row flex-lg-column gap-2 justify-content-lg-end">
            <a href="index.php?page=sapa-warga#formAspirasi" class="btn btn-danger btn-lg rounded-pill fw-bold shadow-sm px-4">
              <i class="bi bi-pencil-square me-2"></i> Kirim Aspirasi Warga
            </a>
            <a href="https://wa.me/6281234567890?text=Halo%20Pak%20Edy%20Susanto,%20saya%20warga%20Tampirkulon%20ingin%20memberi%20masukan%20program" target="_blank" class="btn btn-outline-light btn-lg rounded-pill fw-bold px-4">
              <i class="bi bi-whatsapp me-2"></i> Hubungi Tim via WA
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- MODAL DETAIL LENGKAP UNTUK 7 PROGRAM PRIORITAS -->
<?php foreach ($programData as $p): ?>
<div class="modal fade" id="modalProgram<?= $p['id'] ?>" tabindex="-1" aria-labelledby="modalLabelProgram<?= $p['id'] ?>" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
      <!-- Modal Header -->
      <div class="modal-header text-white border-0 py-3 px-4" style="background-color: <?= e($p['icon_color']) ?>;">
        <div class="d-flex align-items-center gap-3">
          <div class="prog-modal-icon-wrap bg-white text-dark d-flex align-items-center justify-content-center rounded-circle" style="width: 44px; height: 44px; color: <?= e($p['icon_color']) ?> !important;">
            <i class="bi <?= e($p['icon']) ?> fs-5"></i>
          </div>
          <div>
            <span class="badge bg-white-subtle text-white rounded-pill px-2 py-0 small mb-1">
              Program #0<?= $p['id'] ?> • <?= e($p['kategori_label']) ?>
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

<!-- VANILLA JS UNTUK FILTER KATEGORI -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  const filterBtns = document.querySelectorAll('.prog-filter-btn');
  const gridItems = document.querySelectorAll('.prog-grid-item');

  filterBtns.forEach(btn => {
    btn.addEventListener('click', function() {
      // Update active state
      filterBtns.forEach(b => b.classList.remove('active'));
      this.classList.add('active');

      const filterValue = this.getAttribute('data-filter');

      gridItems.forEach(item => {
        const itemCat = item.getAttribute('data-category');
        if (filterValue === 'all') {
          item.style.display = 'block';
        } else if (itemCat && itemCat.includes(filterValue)) {
          item.style.display = 'block';
        } else if (itemCat && itemCat.includes('quote')) {
          // Tetap tampilkan kartu quote untuk keseimbangan layout jika semua atau bisa diatur
          item.style.display = 'none';
        } else {
          item.style.display = 'none';
        }
      });
    });
  });
});
</script>
