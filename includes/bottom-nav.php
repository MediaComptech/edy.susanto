<?php
if (!defined('APP_NAME')) {
    require_once __DIR__ . '/config.php';
}
$page = $_GET['page'] ?? 'beranda';
?>
<!-- Mobile Bottom App Bar (Khusus Perangkat Mobile < 768px) -->
<nav class="mobile-bottom-nav d-md-none" aria-label="Navigasi Mobile">
  <a href="index.php?page=beranda" class="mobile-bottom-item <?= ($page === 'beranda') ? 'active' : '' ?>">
    <i class="bi bi-house-door<?= ($page === 'beranda') ? '-fill' : '' ?>"></i>
    <span>Beranda</span>
  </a>
  <a href="index.php?page=program" class="mobile-bottom-item <?= ($page === 'program') ? 'active' : '' ?>">
    <i class="bi bi-grid<?= ($page === 'program') ? '-fill' : '' ?>"></i>
    <span>Program</span>
  </a>
  <a href="index.php?page=sapa-warga" class="mobile-bottom-item btn-sapa-center <?= ($page === 'sapa-warga') ? 'active' : '' ?>">
    <div class="circle-sapa-btn">
      <i class="bi bi-chat-quote-fill"></i>
    </div>
    <span class="fw-bold">Sapa Warga</span>
  </a>
  <a href="index.php?page=berita" class="mobile-bottom-item <?= ($page === 'berita') ? 'active' : '' ?>">
    <i class="bi bi-newspaper"></i>
    <span>Berita</span>
  </a>
  <a href="index.php?page=profil" class="mobile-bottom-item <?= ($page === 'profil') ? 'active' : '' ?>">
    <i class="bi bi-person<?= ($page === 'profil') ? '-fill' : '' ?>"></i>
    <span>Profil</span>
  </a>
</nav>
