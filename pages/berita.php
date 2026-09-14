<?php
/**
 * Halaman Berita & Dokumentasi Kegiatan
 * Calon Kepala Desa Tampirkulon - Edy Susanto (No. Urut 2)
 */
if (!defined('APP_NAME')) {
    require_once __DIR__ . '/../includes/config.php';
}

// Ambil Berita
$stmtBerita = $pdo->query("SELECT * FROM berita ORDER BY created_at DESC");
$beritaList = $stmtBerita->fetchAll();

// Ambil Galeri
$stmtGaleri = $pdo->query("SELECT * FROM galeri ORDER BY created_at DESC");
$galeriList = $stmtGaleri->fetchAll();
?>

<div class="container-custom py-5">
  <!-- Header Berita -->
  <div class="text-center max-w-700 mx-auto mb-5">
    <span class="badge bg-danger-subtle text-danger fw-bold px-3 py-2 rounded-pill mb-2">
      <i class="bi bi-newspaper me-1"></i> Kabar &amp; Agenda
    </span>
    <h1 class="fw-bold display-5 text-dark mb-2">Berita &amp; Kegiatan</h1>
    <p class="text-muted fs-5">Informasi terbaru seputar silaturahmi warga, gagasan pembangunan, dan sosialisasi program kerja.</p>
  </div>

  <!-- List Berita Cards -->
  <div class="row g-4 mb-5">
    <?php foreach ($beritaList as $item): ?>
    <div class="col-lg-6">
      <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 bg-white">
        <div class="row g-0 h-100">
          <?php if (!empty($item['foto'])): ?>
          <div class="col-md-5">
            <img src="<?= e($item['foto']) ?>" alt="<?= e($item['judul']) ?>" class="w-100 h-100 object-fit-cover" style="min-height: 200px;">
          </div>
          <?php endif; ?>
          <div class="<?= !empty($item['foto']) ? 'col-md-7' : 'col-12' ?> p-4 d-flex flex-column">
            <div class="d-flex align-items-center gap-2 mb-2">
              <span class="badge bg-danger-subtle text-danger rounded-pill px-2 py-1 small"><?= e($item['kategori']) ?></span>
              <small class="text-muted"><i class="bi bi-calendar3 me-1"></i><?= format_tanggal_id($item['created_at']) ?></small>
            </div>
            <h5 class="fw-bold text-dark mb-2"><?= e($item['judul']) ?></h5>
            <p class="text-muted small mb-3 flex-grow-1"><?= e($item['ringkasan']) ?></p>
            <div class="d-flex justify-content-between align-items-center pt-2 border-top">
              <small class="text-muted"><i class="bi bi-person-fill me-1"></i><?= e($item['penulis']) ?></small>
              <a href="index.php?page=sapa-warga#formAspirasi" class="text-danger fw-bold small text-decoration-none">
                Tanggapi &rarr;
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- Section Galeri & Dokumentasi -->
  <div id="dokumentasi" class="pt-5 border-top">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-end mb-4">
      <div>
        <span class="badge bg-danger text-white rounded-pill px-3 py-1 mb-2">Foto &amp; Momen</span>
        <h2 class="fw-bold text-dark mb-1">Dokumentasi Silaturahmi</h2>
        <p class="text-muted mb-0">Kebersamaan dan tatap muka bersama warga masyarakat Desa Tampirkulon.</p>
      </div>
    </div>

    <div class="row g-4">
      <?php foreach ($galeriList as $g): ?>
      <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 bg-white">
          <img src="<?= e($g['foto']) ?>" alt="<?= e($g['judul']) ?>" class="card-img-top" style="height: 220px; object-fit: cover;">
          <div class="p-3">
            <h6 class="fw-bold text-dark mb-1"><?= e($g['judul']) ?></h6>
            <small class="text-muted"><?= e($g['deskripsi']) ?></small>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
