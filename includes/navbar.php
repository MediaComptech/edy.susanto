<?php
if (!defined('APP_NAME')) {
    require_once __DIR__ . '/config.php';
}
$page = $_GET['page'] ?? 'beranda';
?>
<!-- Top Navigation Bar -->
<header class="sticky-top bg-white border-bottom shadow-sm">
  <nav class="navbar navbar-expand-xl navbar-light py-2">
    <div class="container-custom d-flex align-items-center justify-content-between">
      <!-- Brand Logo & Candidate Name -->
      <a class="navbar-brand d-flex align-items-center gap-2 py-0 me-3" href="index.php?page=beranda">
        <span class="badge-no-urut"><?= NO_URUT ?></span>
        <div class="d-flex flex-column">
          <span class="fw-bolder fs-5 text-dark lh-1 tracking-wide"><?= APP_NAME ?></span>
          <span class="text-muted small lh-1 mt-1" style="font-size: 0.76rem;"><?= APP_TITLE ?></span>
        </div>
      </a>

      <!-- Mobile Right Controls (Search + Toggler) -->
      <div class="d-flex align-items-center gap-2 d-xl-none">
        <button class="btn btn-light rounded-circle p-2" data-bs-toggle="modal" data-bs-target="#searchModal" aria-label="Cari">
          <i class="bi bi-search text-secondary"></i>
        </button>
        <button class="navbar-toggler border-0 shadow-none p-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Menu">
          <i class="bi bi-list fs-2 text-dark"></i>
        </button>
      </div>

      <!-- Offcanvas for Mobile / Standard Nav for Desktop -->
      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header border-bottom">
          <div class="d-flex align-items-center gap-2">
            <span class="badge-no-urut"><?= NO_URUT ?></span>
            <div>
              <h6 class="mb-0 fw-bold"><?= APP_NAME ?></h6>
              <small class="text-muted"><?= APP_TITLE ?></small>
            </div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body align-items-xl-center">
          <ul class="navbar-nav mx-auto align-items-xl-center gap-xl-1">
            <li class="nav-item">
              <a class="nav-link <?= ($page === 'beranda') ? 'active' : '' ?>" href="index.php?page=beranda">Beranda</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?= ($page === 'profil') ? 'active' : '' ?>" href="index.php?page=profil">Profil</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.php?page=profil#visi-misi">Gagasan</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?= ($page === 'program') ? 'active' : '' ?>" href="index.php?page=program">Program</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?= ($page === 'potensi') ? 'active' : '' ?>" href="index.php?page=potensi">Potensi Desa</a>
            </li>
            <li class="nav-item mx-xl-1 my-1 my-xl-0">
              <a class="nav-link nav-badge-sapa <?= ($page === 'sapa-warga') ? 'active' : '' ?>" href="index.php?page=sapa-warga">
                <i class="bi bi-chat-quote-fill fs-6 text-danger"></i>
                <span>Sapa Warga</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?= ($page === 'berita') ? 'active' : '' ?>" href="index.php?page=berita">Berita</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.php?page=berita#dokumentasi">Dokumentasi</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?= ($page === 'kontak') ? 'active' : '' ?>" href="index.php?page=kontak">Kontak</a>
            </li>
          </ul>

          <!-- Action Buttons & Search Icon -->
          <div class="d-flex align-items-center gap-2 mt-3 mt-xl-0">
            <a href="index.php?page=sapa-warga#formAspirasi" class="btn btn-aspirasi-header">
              Sampaikan Aspirasi
            </a>
            <button class="btn btn-search-icon d-none d-xl-flex" data-bs-toggle="modal" data-bs-target="#searchModal" title="Cari Informasi" aria-label="Cari">
              <i class="bi bi-search"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  </nav>
</header>
