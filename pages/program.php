<?php
/**
 * Halaman 7 Program Unggulan
 * Calon Kepala Desa Tampirkulon - Edy Susanto (No. Urut 2)
 */
if (!defined('APP_NAME')) {
    require_once __DIR__ . '/../includes/config.php';
}

$stmt = $pdo->query("SELECT * FROM program ORDER BY urutan ASC");
$programs = $stmt->fetchAll();
?>

<div class="container-custom py-5">
  <div class="text-center max-w-700 mx-auto mb-5">
    <span class="badge bg-danger-subtle text-danger fw-bold px-3 py-2 rounded-pill mb-2">
      <i class="bi bi-grid-fill me-1"></i> Rencana Kerja Nyata
    </span>
    <h1 class="fw-bold display-5 text-dark mb-2">7 Program Unggulan</h1>
    <p class="text-muted fs-5">Program komprehensif untuk menjawab tantangan dan memaksimalkan potensi Desa Tampirkulon.</p>
  </div>

  <div class="row g-4">
    <?php foreach ($programs as $prog): ?>
    <div class="col-lg-6">
      <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 h-100 bg-white border-top border-4" style="border-color: <?= e($prog['badge_color']) ?> !important;">
        <div class="d-flex align-items-center gap-3 mb-3">
          <div class="program-card-icon mb-0" style="background-color: <?= e($prog['badge_color']) ?>;">
            <i class="bi <?= e($prog['icon']) ?>"></i>
          </div>
          <div>
            <span class="badge rounded-pill text-white px-3 py-1 small" style="background-color: <?= e($prog['badge_color']) ?>;">
              Program #<?= $prog['urutan'] ?> • <?= e($prog['kategori']) ?>
            </span>
            <h3 class="fw-bold text-dark mt-1 mb-0 fs-4"><?= e($prog['judul']) ?></h3>
          </div>
        </div>

        <h6 class="fw-semibold text-secondary mb-3">"<?= e($prog['deskripsi_singkat']) ?>"</h6>
        
        <p class="text-muted small mb-4 leading-relaxed">
          <?= e($prog['deskripsi_lengkap']) ?>
        </p>

        <?php if (!empty($prog['target_capaian'])): ?>
        <div class="p-3 rounded-3 bg-light border-start border-3" style="border-color: <?= e($prog['badge_color']) ?> !important;">
          <strong class="d-block small text-dark mb-1"><i class="bi bi-bullseye me-1"></i> Target Capaian:</strong>
          <small class="text-muted"><?= e($prog['target_capaian']) ?></small>
        </div>
        <?php endif; ?>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- Bottom Action Card -->
  <div class="mt-5 p-4 p-md-5 rounded-4 bg-primary-soft text-center border border-danger-subtle">
    <h4 class="fw-bold text-dark mb-2">Punya Masukan Terkait Program di Dusun Anda?</h4>
    <p class="text-muted mb-4">Sampaikan ide, kritik membangun, atau kebutuhan fasilitas lingkungan Anda langsung lewat kanal Sapa Warga.</p>
    <a href="index.php?page=sapa-warga#formAspirasi" class="btn btn-danger btn-lg rounded-pill px-5 fw-bold shadow-sm">
      <i class="bi bi-chat-quote-fill me-2"></i> Usulkan Aspirasi Sekarang
    </a>
  </div>
</div>
