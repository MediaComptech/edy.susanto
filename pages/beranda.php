<?php
/**
 * Halaman Beranda (Home)
 * Sesuai Desain Mockup UI/1.png
 */
if (!defined('APP_NAME')) {
    require_once __DIR__ . '/../includes/config.php';
}

// Ambil data program unggulan dari database
$stmtPrograms = $pdo->query("SELECT * FROM program ORDER BY urutan ASC LIMIT 7");
$programs = $stmtPrograms->fetchAll();

// Ambil statistik aspirasi
$stats = get_aspirasi_stats($pdo);

// Ambil pengaturan dinamis untuk Hero Section
$fotoHero = get_pengaturan($pdo, 'foto_hero', 'assets/images/banner/edy_susanto_hero_clean.jpg');
$bgHero   = get_pengaturan($pdo, 'bg_hero', 'assets/images/banner/hero_bg_pure_landscape.jpg');
$namaCalon = get_pengaturan($pdo, 'nama_calon', APP_NAME);
$noUrut = get_pengaturan($pdo, 'no_urut', NO_URUT);
$tagline = get_pengaturan($pdo, 'tagline', TAGLINE);
$sloganQuote = get_pengaturan($pdo, 'slogan_quote', SLOGAN_QUOTE);
if (trim($sloganQuote) === '' || trim($sloganQuote) === '-') {
    $sloganQuote = SLOGAN_QUOTE;
}
$fotoSapaWarga = get_pengaturan($pdo, 'foto_sapa_warga', 'assets/images/banner/dialog_warga.jpg');
?>

<!-- 1. Hero Section — Flayer Card (Bounded in Container, Tidak Panjang Sampai Pinggir) -->
<div class="hero-card-wrapper">
  <div class="container-custom">
    <section class="hero-section hero-card" id="hero-flayer">

      <!-- Background Landscape: Dinamis dari database, fallback ke kota hijau -->
      <div class="hero-bg-layer" style="background-image: url('<?= e($bgHero) ?>');" id="heroBgLayer"></div>

      <!-- FLAYER INNER: Two Column Layout -->
      <div class="hero-flayer-inner">

        <!-- [1] TEKS KIRI: Nama, No Urut, Slogan, Badge Pilar, Tombol -->
        <div class="hero-text-block">
          <div class="hero-tagline-badge mb-2">
            <i class="bi bi-geo-alt-fill text-danger"></i>
            Calon Kepala Desa Tampirkulon
          </div>

          <h1 class="hero-name"><?= e($namaCalon) ?></h1>

          <div class="mb-2">
            <span class="badge-hero-no">No. Urut <?= e($noUrut) ?></span>
          </div>

          <p class="hero-quote-slogan mb-3"><?= e($tagline) ?></p>

          <!-- 3 Pillars -->
          <div class="hero-pillars mb-3">
            <div class="pillar-badge">
              <span class="pillar-icon-circle pillar-icon-asri"><i class="fa-solid fa-leaf"></i></span>
              <span>Asri</span>
            </div>
            <div class="pillar-badge">
              <span class="pillar-icon-circle pillar-icon-maju"><i class="bi bi-bar-chart-fill"></i></span>
              <span>Maju</span>
            </div>
            <div class="pillar-badge">
              <span class="pillar-icon-circle pillar-icon-rukun"><i class="bi bi-people-fill"></i></span>
              <span>Rukun</span>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="hero-cta-buttons">
            <a href="index.php?page=profil" class="btn btn-danger btn-md rounded-pill px-4 fw-bold shadow-sm d-inline-flex align-items-center gap-2">
              <span>Kenali Saya</span>
              <i class="bi bi-arrow-right"></i>
            </a>
            <a href="index.php?page=program" class="btn btn-light btn-md rounded-pill px-4 fw-semibold shadow-sm border">
              Lihat Program Kerja
            </a>
          </div>
        </div>

        <!-- [2] FOTO KANDIDAT: Tunggal, Proporsional, Responsif -->
        <div class="hero-candidate-wrapper">
          <!-- [3] Quote Box (Desktop) -->
          <div class="hero-quote-box d-none d-lg-block" aria-hidden="true">
            <span class="hero-quote-mark">"</span>
            <p class="hero-quote-text font-handwriting"><?= nl2br(e($sloganQuote)) ?></p>
            <p class="hero-quote-author">— <?= e($namaCalon) ?></p>
          </div>

          <!-- Single Candidate Image -->
          <img
            src="<?= e($fotoHero) ?>"
            alt="<?= e($namaCalon) ?> - Calon Kepala Desa Tampirkulon No. Urut <?= e($noUrut) ?>"
            class="hero-candidate-img"
            id="heroPhotoImg"
          >

          <!-- [4] SAPA WARGA PILL BAR: Floating Capsule Pill -->
          <a href="index.php?page=sapa-warga" class="hero-sapa-floating-pill" id="heroSapaBar" title="Sapa Warga - Sampaikan Aspirasi">
            <div class="hero-sapa-pill-left">
              <div class="hero-sapa-pill-icon">
                <i class="bi bi-chat-dots-fill"></i>
              </div>
              <div>
                <strong class="d-block hero-sapa-pill-title">Sapa Warga</strong>
                <span class="hero-sapa-pill-sub">Mari berdialog, dengar, dan cari solusi bersama.</span>
              </div>
            </div>
            <div class="hero-sapa-pill-arrow">
              <i class="bi bi-arrow-right"></i>
            </div>
          </a>
        </div>

      </div><!-- /.hero-flayer-inner -->

    </section>
  </div>
</div>

<!-- 2. Quick Action Navigation Bar (6 Cards) -->
<div class="container-custom quick-nav-wrapper">
  <div class="row row-cols-2 row-cols-md-3 row-cols-lg-6 g-3">
    <div class="col">
      <a href="index.php?page=profil" class="quick-card">
        <i class="bi bi-person quick-card-icon"></i>
        <span class="quick-card-label">Profil Calon</span>
      </a>
    </div>
    <div class="col">
      <a href="index.php?page=program" class="quick-card">
        <i class="bi bi-card-checklist quick-card-icon"></i>
        <span class="quick-card-label">Program Kerja</span>
      </a>
    </div>
    <div class="col">
      <a href="index.php?page=potensi" class="quick-card">
        <i class="bi bi-geo-alt quick-card-icon"></i>
        <span class="quick-card-label">Potensi Desa</span>
      </a>
    </div>
    <div class="col">
      <a href="index.php?page=sapa-warga" class="quick-card active-card">
        <i class="bi bi-chat-quote-fill quick-card-icon text-danger"></i>
        <span class="quick-card-label text-danger">Sapa Warga</span>
      </a>
    </div>
    <div class="col">
      <a href="index.php?page=berita" class="quick-card">
        <i class="bi bi-newspaper quick-card-icon"></i>
        <span class="quick-card-label">Berita &amp; Kegiatan</span>
      </a>
    </div>
    <div class="col">
      <a href="index.php?page=berita#dokumentasi" class="quick-card">
        <i class="bi bi-camera quick-card-icon"></i>
        <span class="quick-card-label">Dokumentasi</span>
      </a>
    </div>
  </div>
</div>

<!-- 3. Section: Tampirkulon yang Kita Kenal -->
<section class="pt-2 pb-5 bg-white">
  <div class="container-custom">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-end mb-4">
      <div>
        <h2 class="fw-bold mb-1 text-dark">Tampirkulon yang Kita Kenal</h2>
        <p class="text-muted mb-0">Desa dengan potensi besar, masyarakat yang guyub, dan lingkungan yang asri.</p>
      </div>
      <a href="index.php?page=potensi" class="text-danger fw-bold text-decoration-none mt-2 mt-md-0 d-inline-flex align-items-center gap-1">
        <span>Lihat Selengkapnya</span>
        <i class="bi bi-arrow-right"></i>
      </a>
    </div>

    <div class="row g-4">
      <!-- Pilar 1: Asri -->
      <div class="col-lg-3 col-md-6">
        <div class="card-pillar-feature">
          <div class="circle-pillar-large pillar-icon-asri">
            <i class="fa-solid fa-leaf"></i>
          </div>
          <h4 class="fw-bold mb-2">Asri</h4>
          <p class="text-muted small mb-0">Lingkungan desa yang bersih, sehat dan nyaman untuk seluruh keluarga.</p>
        </div>
      </div>

      <!-- Pilar 2: Maju -->
      <div class="col-lg-3 col-md-6">
        <div class="card-pillar-feature">
          <div class="circle-pillar-large pillar-icon-maju">
            <i class="bi bi-bar-chart-fill"></i>
          </div>
          <h4 class="fw-bold mb-2">Maju</h4>
          <p class="text-muted small mb-0">Ekonomi masyarakat dan pelayanan birokrasi desa berkembang cepat serta transparan.</p>
        </div>
      </div>

      <!-- Pilar 3: Rukun -->
      <div class="col-lg-3 col-md-6">
        <div class="card-pillar-feature">
          <div class="circle-pillar-large pillar-icon-rukun">
            <i class="bi bi-people-fill"></i>
          </div>
          <h4 class="fw-bold mb-2">Rukun</h4>
          <p class="text-muted small mb-0">Gotong royong dan hubungan antarwarga tetap terjaga erat penuh kekeluargaan.</p>
        </div>
      </div>

      <!-- Featured Card: Wisata Tubing Tampirkulon -->
      <div class="col-lg-3 col-md-6">
        <a href="index.php?page=potensi" class="card-tubing-featured d-block text-decoration-none">
          <img src="assets/images/galeri/wisata_tubing.jpg" alt="Wisata Tubing Tampirkulon">
          <div class="card-tubing-overlay">
            <div class="d-flex align-items-center justify-content-between">
              <div>
                <h5 class="fw-bold mb-0 text-white">Wisata Tubing Tampirkulon</h5>
                <small class="text-white-50">Salah satu potensi unggulan desa</small>
              </div>
              <div class="bg-white text-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; flex-shrink: 0;">
                <i class="bi bi-arrow-right"></i>
              </div>
            </div>
          </div>
        </a>
      </div>
    </div>
  </div>
</section>

<!-- 4. Section: Program Unggulan -->
<section class="py-5" style="background-color: #f8fafc;">
  <div class="container-custom">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-end mb-4">
      <div>
        <h2 class="fw-bold mb-1 text-dark">Program Unggulan</h2>
        <p class="text-muted mb-0">Program yang dirancang untuk menjawab kebutuhan dan tantangan Desa Tampirkulon.</p>
      </div>
      <a href="index.php?page=program" class="text-danger fw-bold text-decoration-none mt-2 mt-md-0 d-inline-flex align-items-center gap-1">
        <span>Lihat Semua Program</span>
        <i class="bi bi-arrow-right"></i>
      </a>
    </div>

    <!-- 7 Programs Grid -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">
      <?php foreach ($programs as $prog): ?>
      <div class="col">
        <div class="program-card" data-search-content="<?= e($prog['judul'] . ' ' . $prog['deskripsi_singkat']) ?>" data-search-title="<?= e($prog['judul']) ?>" data-search-url="index.php?page=program">
          <div class="program-card-icon" style="background-color: <?= e($prog['badge_color']) ?>;">
            <i class="<?= (strpos($prog['icon'], 'fa-') !== false) ? e($prog['icon']) : 'bi ' . e($prog['icon']) ?>"></i>
          </div>
          <h5 class="program-card-title"><?= e($prog['judul']) ?></h5>
          <p class="program-card-desc mb-3"><?= e($prog['deskripsi_singkat']) ?></p>
          <a href="index.php?page=program" class="small fw-bold text-decoration-none" style="color: <?= e($prog['badge_color']) ?>;">
            Pelajari Selengkapnya <i class="bi bi-chevron-right"></i>
          </a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- 5. CTA Banner: Sapa Warga, Karena Setiap Suara Itu Berarti -->
<section class="py-5 bg-white">
  <div class="container-custom">
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden border border-light-subtle">
      <div class="row g-0 align-items-center">
        <!-- Text & Action -->
        <div class="col-lg-6 p-4 p-md-5">
          <div class="d-flex align-items-center gap-3 mb-3">
            <div class="bg-success text-white rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
              <i class="bi bi-chat-left-dots-fill fs-4"></i>
            </div>
            <h3 class="fw-bold mb-0 text-dark">Sapa Warga, Karena Setiap Suara Itu Berarti</h3>
          </div>
          <p class="text-muted fs-6 mb-4">
            "Dari warga, bersama warga, untuk Tampirkulon yang lebih baik." Ruang langsung untuk berdialog, menyampaikan usulan fasilitas umum, dan mengawal pembangunan desa secara terbuka.
          </p>
          <div class="d-flex flex-wrap gap-3">
            <a href="index.php?page=sapa-warga" class="btn btn-danger btn-lg rounded-pill px-4 fw-bold d-inline-flex align-items-center gap-2 shadow-sm">
              <span>Mulai Sapa Warga</span>
              <i class="bi bi-arrow-right"></i>
            </a>
            <button type="button" id="btnEnableNotif" class="btn btn-outline-danger btn-lg rounded-pill px-4 fw-semibold">
              <i class="bi bi-bell-fill me-1"></i> Aktifkan Notifikasi Desa
            </button>
          </div>
        </div>

        <!-- Community Dialog Image: Dinamis dari Pengaturan Website -->
        <div class="col-lg-6">
          <img src="<?= e($fotoSapaWarga) ?>" alt="Dialog Silaturahmi Edy Susanto Bersama Warga" class="w-100 h-100 object-fit-cover" style="min-height: 280px;">
        </div>
      </div>
    </div>
  </div>
</section>
