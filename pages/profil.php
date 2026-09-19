<?php
/**
 * Halaman Profil Calon & Gagasan Visi Misi
 * Calon Kepala Desa Tampirkulon - Edy Susanto (No. Urut 2)
 */
if (!defined('APP_NAME')) {
    require_once __DIR__ . '/../includes/config.php';
}
if (!function_exists('get_pengaturan')) {
    require_once __DIR__ . '/../includes/functions.php';
}

$namaCalon         = get_pengaturan($pdo, 'nama_calon', APP_NAME);
$noUrut            = get_pengaturan($pdo, 'no_urut', NO_URUT);
$fotoProfil        = get_pengaturan($pdo, 'foto_profil', 'assets/images/banner/edy_susanto_hero.jpg');
$profilRawAsal     = get_pengaturan($pdo, 'profil_asal', 'Putra Asli Tampirkulon');
if (strpos($profilRawAsal, '•') !== false) {
    $parts = explode('•', $profilRawAsal, 2);
    $profilStatus = trim($parts[0]);
    $profilAsal   = trim($parts[1]);
} else {
    $profilStatus = get_pengaturan($pdo, 'profil_status', 'Purnawirawan TNI AD');
    $profilAsal   = $profilRawAsal;
}
$judulDedikasi     = get_pengaturan($pdo, 'profil_judul_dedikasi', 'Integritas & Kedisiplinan Prajurit, Mengabdi Sepenuh Hati untuk Warga');
$biodata1          = get_pengaturan($pdo, 'profil_biodata_1', 'Sebagai putra asli Tampirkulon dan Purnawirawan TNI AD, ' . $namaCalon . ' dibentuk oleh kedisiplinan tinggi, loyalitas tanpa pamrih kepada masyarakat, serta ketegasan sikap yang senantiasa mengayomi. Beliau memahami secara mendalam denyut kehidupan warga, potensi agraris yang melimpah, serta harapan besar pemuda dan keluarga di setiap dusun.');
$biodata2          = get_pengaturan($pdo, 'profil_biodata_2', 'Berbekal pengalaman kepemimpinan kedinasan, keahlian tata kelola administrasi keuangan yang akuntabel, serta manajemen rantai pasok dan distribusi kebutuhan personil secara presisi, beliau hadir membawa tekad mengabdi seutuhnya demi terciptanya pemerintahan desa yang bersih, transparan, anti-bocor, dan melayani.');
$nilaiKepemimpinan = get_pengaturan($pdo, 'profil_nilai_kepemimpinan', 'Disiplin prajurit yang humanis, transparansi anggaran 100% tanpa celah kebocoran, dan keteladanan nyata melayani seluruh warga.');
$komitmenPengabdian = get_pengaturan($pdo, 'profil_komitmen_pengabdian', 'Distribusi bantuan dan sarana tani tepat sasaran, pelayanan kantor desa cepat & bebas pungli, serta siap hadir 24/7 untuk masyarakat.');

// Pengaturan 3 Pilar Keunggulan Kompetensi
$pilar1Judul = get_pengaturan($pdo, 'profil_pilar1_judul', 'Disiplin Tinggi & Integritas');
$pilar1Sub   = get_pengaturan($pdo, 'profil_pilar1_sub', 'Etos kerja tepat waktu, konsisten, dan kepemimpinan teladan yang mengayomi seluruh lapisan masyarakat tanpa membeda-bedakan.');

$pilar2Judul = get_pengaturan($pdo, 'profil_pilar2_judul', 'Tata Kelola Keuangan Akuntabel');
$pilar2Sub   = get_pengaturan($pdo, 'profil_pilar2_sub', 'Berpengalaman mengelola anggaran kedinasan secara tertib dan ketat. Menjamin Dana Desa (APBDes) dikelola transparan dan bebas kebocoran.');

$pilar3Judul = get_pengaturan($pdo, 'profil_pilar3_judul', 'Distribusi Kebutuhan Presisi');
$pilar3Sub   = get_pengaturan($pdo, 'profil_pilar3_sub', 'Teruji dalam manajemen logistik dan penyaluran kebutuhan personil. Memastikan pupuk subsidi, bansos, dan sarana tani terdistribusi adil & tepat sasaran.');
?>

<div class="container-custom py-5">
  <!-- Header Profil -->
  <div class="text-center max-w-700 mx-auto mb-4 mb-md-5">
    <span class="badge bg-danger-subtle text-danger fw-bold px-3 py-2 rounded-pill mb-2">
      <i class="bi bi-person-badge-fill me-1"></i> Mengenal Lebih Dekat
    </span>
    <h1 class="fw-bold display-5 text-dark mb-2 profil-header-title">Profil <?= e($namaCalon) ?></h1>
    <div class="profil-meta-bar d-flex flex-wrap align-items-center justify-content-center gap-2 mt-2">
      <span class="text-muted profil-meta-sub">Calon Kepala Desa Tampirkulon Masa Bakti 2026 – 2032</span>
      <span class="profil-badge-no">
        <span class="badge-label">Nomor Urut</span>
        <span class="badge-num"><?= e($noUrut) ?></span>
      </span>
    </div>
  </div>

  <div class="row g-5 align-items-center mb-5">
    <!-- Foto & Identitas -->
    <div class="col-lg-5 text-center mb-4 mb-lg-0">
      <div class="profil-photo-container position-relative d-inline-block">
        <img src="<?= e($fotoProfil) ?>" alt="<?= e($namaCalon) ?>" class="img-fluid rounded-4 shadow-lg profil-photo-img">
        <div class="profil-identity-card">
          <div class="d-flex align-items-center justify-content-between gap-2 mb-1">
            <h5 class="fw-bold text-dark mb-0 profil-card-name"><?= e($namaCalon) ?></h5>
            <span class="profil-card-badge">
              <i class="bi bi-check-circle-fill me-1"></i>No. Urut <?= e($noUrut) ?>
            </span>
          </div>
          <?php if (!empty($profilStatus)): ?>
          <div class="profil-card-status text-danger small fw-bold d-flex align-items-center gap-1 mb-1">
            <i class="bi bi-shield-fill-check"></i>
            <span><?= e($profilStatus) ?></span>
          </div>
          <?php endif; ?>
          <div class="profil-card-sub text-muted small d-flex align-items-center gap-1">
            <i class="bi bi-geo-alt-fill text-danger"></i>
            <span><?= e($profilAsal) ?></span>
          </div>
        </div>
      </div>
    </div>

    <!-- Narasi Biodata & Nilai Kepemimpinan -->
    <div class="col-lg-7">
      <h3 class="fw-bold mb-3 text-dark"><?= e($judulDedikasi) ?></h3>
      <p class="text-secondary fs-6 leading-relaxed">
        <?= nl2br(e($biodata1)) ?>
      </p>
      <p class="text-secondary fs-6 leading-relaxed">
        <?= nl2br(e($biodata2)) ?>
      </p>

      <div class="row g-3 mt-2">
        <div class="col-sm-6">
          <div class="p-3 border rounded-3 bg-light h-100">
            <h6 class="fw-bold text-danger mb-1"><i class="bi bi-award-fill me-1"></i> Nilai Kepemimpinan</h6>
            <p class="small text-muted mb-0"><?= nl2br(e($nilaiKepemimpinan)) ?></p>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="p-3 border rounded-3 bg-light h-100">
            <h6 class="fw-bold text-danger mb-1"><i class="bi bi-heart-fill me-1"></i> Komitmen Pengabdian</h6>
            <p class="small text-muted mb-0"><?= nl2br(e($komitmenPengabdian)) ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Section: 3 Pilar Keunggulan Rekam Jejak Purnawirawan TNI AD -->
  <div class="mb-5 pt-2">
    <div class="text-center max-w-700 mx-auto mb-4">
      <span class="badge bg-danger-subtle text-danger fw-bold px-3 py-2 rounded-pill mb-2">
        <i class="bi bi-shield-check me-1"></i> Rekam Jejak &amp; Kapabilitas
      </span>
      <h3 class="fw-bold text-dark mb-1 fs-3">Keahlian Strategis untuk Memajukan Desa</h3>
      <p class="text-muted small mb-0">
        Kombinasi kedisiplinan prajurit, ketertiban anggaran, dan kemahiran logistik yang didedikasikan seutuhnya bagi kemakmuran Tampirkulon.
      </p>
    </div>

    <div class="row g-3 g-md-4">
      <!-- 1. Disiplin & Integritas -->
      <div class="col-md-4">
        <div class="card h-100 border-0 rounded-4 shadow-sm p-4 bg-white profil-keunggulan-card">
          <div class="d-flex align-items-center gap-3 mb-3">
            <div class="profil-keunggulan-icon bg-danger-subtle text-danger rounded-3 d-flex align-items-center justify-content-center flex-shrink-0">
              <i class="bi bi-shield-shaded fs-4"></i>
            </div>
            <div>
              <span class="badge bg-light text-secondary border small fw-semibold">Karakter Prajurit</span>
              <h5 class="fw-bold text-dark mb-0 mt-1 fs-6"><?= e($pilar1Judul) ?></h5>
            </div>
          </div>
          <p class="text-muted small mb-0 leading-relaxed">
            <?= nl2br(e($pilar1Sub)) ?>
          </p>
        </div>
      </div>

      <!-- 2. Pengelolaan Keuangan Akuntabel -->
      <div class="col-md-4">
        <div class="card h-100 border-0 rounded-4 shadow-sm p-4 bg-white profil-keunggulan-card">
          <div class="d-flex align-items-center gap-3 mb-3">
            <div class="profil-keunggulan-icon bg-success-subtle text-success rounded-3 d-flex align-items-center justify-content-center flex-shrink-0">
              <i class="bi bi-cash-stack fs-4"></i>
            </div>
            <div>
              <span class="badge bg-light text-secondary border small fw-semibold">Anti-Kebocoran</span>
              <h5 class="fw-bold text-dark mb-0 mt-1 fs-6"><?= e($pilar2Judul) ?></h5>
            </div>
          </div>
          <p class="text-muted small mb-0 leading-relaxed">
            <?= nl2br(e($pilar2Sub)) ?>
          </p>
        </div>
      </div>

      <!-- 3. Distribusi Logistik Presisi -->
      <div class="col-md-4">
        <div class="card h-100 border-0 rounded-4 shadow-sm p-4 bg-white profil-keunggulan-card">
          <div class="d-flex align-items-center gap-3 mb-3">
            <div class="profil-keunggulan-icon bg-primary-subtle text-primary rounded-3 d-flex align-items-center justify-content-center flex-shrink-0">
              <i class="bi bi-boxes fs-4"></i>
            </div>
            <div>
              <span class="badge bg-light text-secondary border small fw-semibold">Penyaluran Tepat Sasaran</span>
              <h5 class="fw-bold text-dark mb-0 mt-1 fs-6"><?= e($pilar3Judul) ?></h5>
            </div>
          </div>
          <p class="text-muted small mb-0 leading-relaxed">
            <?= nl2br(e($pilar3Sub)) ?>
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- Section Gagasan: Visi & Misi -->
  <div id="visi-misi" class="pt-5 border-top">
    <div class="text-center mb-5">
      <span class="badge bg-danger text-white fw-bold px-3 py-2 rounded-pill mb-2">Arah Kebijakan</span>
      <h2 class="fw-bold display-6">Visi &amp; Misi Bersama</h2>
      <p class="text-muted">Fondasi kokoh mewujudkan Tampirkulon sebagai desa percontohan di Kabupaten Magelang.</p>
    </div>

    <!-- Visi Card -->
    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-5 text-center bg-primary-soft border-start border-5 border-danger">
      <h5 class="text-danger fw-bold text-uppercase tracking-wider mb-2">Visi Utama</h5>
      <p class="display-6 fw-bold text-dark mb-0 font-handwriting">
        "Terwujudnya Desa Tampirkulon yang Asri, Maju, Rukun, dan Sejahtera Berlandaskan Gotong Royong serta Pelayanan yang Transparan."
      </p>
    </div>

    <!-- 3 Misi Pilar -->
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white">
          <div class="circle-pillar-large pillar-icon-asri mb-3">
            <i class="fa-solid fa-leaf"></i>
          </div>
          <h4 class="fw-bold mb-2">1. Tampirkulon Asri</h4>
          <p class="text-muted small mb-0">
            Menjaga kelestarian lingkungan hidup, kebersihan aliran sungai, penataan sanitasi, dan pengelolaan sampah modern berbasis partisipasi warga.
          </p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white">
          <div class="circle-pillar-large pillar-icon-maju mb-3">
            <i class="bi bi-bar-chart-fill"></i>
          </div>
          <h4 class="fw-bold mb-2">2. Tampirkulon Maju</h4>
          <p class="text-muted small mb-0">
            Mengakselerasi perekonomian petani dan UMKM lokal, memajukan Wisata Tubing Tampirkulon, serta mendigitalisasi birokrasi pelayanan desa agar cepat dan akuntabel.
          </p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white">
          <div class="circle-pillar-large pillar-icon-rukun mb-3">
            <i class="bi bi-people-fill"></i>
          </div>
          <h4 class="fw-bold mb-2">3. Tampirkulon Rukun</h4>
          <p class="text-muted small mb-0">
            Merajut keharmonisan antar-dusun, memberdayakan pemuda dan karang taruna, serta menghidupkan kembali tradisi gotong royong dan silaturahmi tanpa sekat.
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
