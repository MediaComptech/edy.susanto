<?php
/**
 * Halaman Potensi Desa Tampirkulon
 * Calon Kepala Desa Tampirkulon - Edy Susanto (No. Urut 2)
 */
if (!defined('APP_NAME')) {
    require_once __DIR__ . '/../includes/config.php';
}
?>

<div class="container-custom py-5">
  <div class="text-center max-w-700 mx-auto mb-5">
    <span class="badge bg-danger-subtle text-danger fw-bold px-3 py-2 rounded-pill mb-2">
      <i class="bi bi-compass-fill me-1"></i> Kekayaan Lokal
    </span>
    <h1 class="fw-bold display-5 text-dark mb-2">Potensi Desa Tampirkulon</h1>
    <p class="text-muted fs-5">Mengenal keunggulan alam, agraris, dan kearifan lokal yang siap dimaksimalkan untuk kesejahteraan warga.</p>
  </div>

  <!-- Featured: Wisata Tubing Tampirkulon -->
  <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5 bg-white">
    <div class="row g-0 align-items-center">
      <div class="col-lg-6">
        <img src="assets/images/galeri/wisata_tubing.jpg" alt="Wisata Tubing Tampirkulon" class="w-100 h-100 object-fit-cover" style="min-height: 320px;">
      </div>
      <div class="col-lg-6 p-4 p-md-5">
        <span class="badge bg-primary text-white rounded-pill px-3 py-1 mb-2">Destinasi Unggulan</span>
        <h2 class="fw-bold text-dark mb-3">Wisata Tubing Tampirkulon</h2>
        <p class="text-secondary leading-relaxed mb-4">
          Aliran sungai jernih yang bersumber dari lereng pegunungan Magelang melewati kawasan persawahan Tampirkulon yang sejuk dan asri. Potensi wisata petualangan tubing ini merupakan aset berharga yang siap dikembangkan menjadi destinasi rekreasi keluarga unggulan.
        </p>
        <div class="row g-3 mb-4">
          <div class="col-6">
            <div class="p-2 border rounded-3 bg-light">
              <strong class="d-block text-dark small"><i class="bi bi-check2 text-success me-1"></i> Air Alami</strong>
              <small class="text-muted">Sungai bersih &amp; arus aman</small>
            </div>
          </div>
          <div class="col-6">
            <div class="p-2 border rounded-3 bg-light">
              <strong class="d-block text-dark small"><i class="bi bi-check2 text-success me-1"></i> Berbasis Warga</strong>
              <small class="text-muted">Dikelola pemuda karang taruna</small>
            </div>
          </div>
        </div>
        <a href="index.php?page=sapa-warga#formAspirasi" class="btn btn-danger rounded-pill px-4 fw-bold">
          <i class="bi bi-lightbulb-fill me-1"></i> Usulkan Gagasan Pengembangan Tubing
        </a>
      </div>
    </div>
  </div>

  <!-- 3 Potensi Lainnya -->
  <div class="row g-4">
    <div class="col-md-4">
      <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white">
        <div class="circle-pillar-large pillar-icon-asri mb-3">
          <i class="bi bi-flower1"></i>
        </div>
        <h4 class="fw-bold mb-2">Pertanian Subur &amp; Holtikultura</h4>
        <p class="text-muted small mb-0">
          Hamparan sawah padi, sayur mayur, dan cabai dengan sistem irigasi alami. Komitmen No. 2 adalah memastikan ketersediaan pupuk dan modernisasi alsintan bagi kelompok tani.
        </p>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white">
        <div class="circle-pillar-large pillar-icon-maju mb-3">
          <i class="bi bi-shop"></i>
        </div>
        <h4 class="fw-bold mb-2">UMKM &amp; Kuliner Tradisional</h4>
        <p class="text-muted small mb-0">
          Produk olahan makanan ringan, kerajinan tangan dusun, serta aneka jajanan pasar khas yang memiliki cita rasa autentik dan potensi pasar digital yang luas.
        </p>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white">
        <div class="circle-pillar-large pillar-icon-rukun mb-3">
          <i class="bi bi-people-fill"></i>
        </div>
        <h4 class="fw-bold mb-2">Modal Sosial &amp; Gotong Royong</h4>
        <p class="text-muted small mb-0">
          Kekuatan terbesar Tampirkulon terletak pada keharmonisan warganya. Nilai guyub rukun, kerja bakti rutin, dan kesetiakawanan sosial menjadi modal utama pembangunan desa.
        </p>
      </div>
    </div>
  </div>
</div>
