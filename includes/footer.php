<?php
if (!defined('APP_NAME')) {
    require_once __DIR__ . '/config.php';
}
?>
<!-- Footer Website Utama -->
<footer class="site-footer">
  <div class="container-custom">
    <div class="row g-4 mb-5">
      <!-- Kolom Brand & Slogan -->
      <div class="col-lg-4 col-md-6">
        <div class="d-flex align-items-center gap-3 mb-3">
          <span class="badge-no-urut fs-3" style="width: 48px; height: 48px;"><?= NO_URUT ?></span>
          <div>
            <h5 class="text-white fw-bold mb-0 lh-1"><?= APP_NAME ?></h5>
            <small class="text-light-50"><?= APP_TITLE ?></small>
          </div>
        </div>
        <p class="font-handwriting text-warning mb-3 fs-3" style="line-height: 1.3;">
          "<?= TAGLINE ?>"
        </p>
        <p class="text-secondary small pe-lg-4">
          Wadah komunikasi langsung, transparansi program, dan partisipasi aktif seluruh warga demi kemajuan Desa Tampirkulon yang berkelanjutan.
        </p>
      </div>

      <!-- Kolom Navigasi -->
      <div class="col-lg-2 col-md-3 col-6">
        <h6 class="footer-heading">Navigasi</h6>
        <ul class="list-unstyled mb-0 d-flex flex-column gap-2 small">
          <li><a href="index.php?page=beranda">Beranda</a></li>
          <li><a href="index.php?page=profil">Profil</a></li>
          <li><a href="index.php?page=profil#visi-misi">Gagasan</a></li>
          <li><a href="index.php?page=program">Program</a></li>
          <li><a href="index.php?page=potensi">Potensi Desa</a></li>
        </ul>
      </div>

      <!-- Kolom Informasi -->
      <div class="col-lg-2 col-md-3 col-6">
        <h6 class="footer-heading">Informasi</h6>
        <ul class="list-unstyled mb-0 d-flex flex-column gap-2 small">
          <li><a href="index.php?page=berita">Berita</a></li>
          <li><a href="index.php?page=berita#dokumentasi">Dokumentasi</a></li>
          <li><a href="index.php?page=sapa-warga">Sapa Warga</a></li>
          <li><a href="index.php?page=kontak">Kontak</a></li>
          <li><a href="admin/login.php" class="text-secondary"><i class="bi bi-shield-lock me-1"></i>Portal Admin</a></li>
        </ul>
      </div>

      <!-- Kolom Kontak Kami -->
      <div class="col-lg-4 col-md-12">
        <h6 class="footer-heading">Kontak Kami</h6>
        <ul class="list-unstyled text-secondary small d-flex flex-column gap-2 mb-3">
          <li class="d-flex align-items-start gap-2">
            <i class="bi bi-geo-alt-fill text-danger fs-6 mt-1"></i>
            <span><?= ALAMAT_DESA ?></span>
          </li>
          <li class="d-flex align-items-center gap-2">
            <i class="bi bi-telephone-fill text-danger fs-6"></i>
            <span>+<?= WHATSAPP_NUMBER ?></span>
          </li>
          <li class="d-flex align-items-center gap-2">
            <i class="bi bi-envelope-fill text-danger fs-6"></i>
            <span><?= EMAIL_DESA ?></span>
          </li>
        </ul>

        <!-- Social Media Icons -->
        <div class="mb-4">
          <a href="#" class="footer-social-link" title="Facebook"><i class="bi bi-facebook"></i></a>
          <a href="#" class="footer-social-link" title="Instagram"><i class="bi bi-instagram"></i></a>
          <a href="#" class="footer-social-link" title="YouTube"><i class="bi bi-youtube"></i></a>
          <a href="#" class="footer-social-link" title="TikTok"><i class="bi bi-tiktok"></i></a>
        </div>

        <!-- Tombol Chat WhatsApp -->
        <div class="mt-2">
          <span class="d-block text-white fw-bold mb-2 small">Ikuti Perkembangannya:</span>
          <a href="https://wa.me/<?= WHATSAPP_NUMBER ?>?text=Halo%20Pak%20Edy%20Susanto,%20saya%20ingin%20menyampaikan%20aspirasi%20warga" target="_blank" rel="noopener" class="btn btn-whatsapp-float">
            <i class="bi bi-whatsapp fs-5"></i>
            <span>Chat WhatsApp</span>
          </a>
        </div>
      </div>
    </div>

    <hr class="border-secondary opacity-25 my-4">

    <!-- Bottom Bar Copyright -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center small text-secondary gap-2">
      <div>
        &copy; 2026 <?= APP_NAME ?>. Bersama Membangun Desa Tampirkulon.
      </div>
      <div class="d-flex gap-3">
        <a href="index.php?page=profil">Kebijakan Privasi</a>
        <span>|</span>
        <a href="index.php?page=profil">Syarat &amp; Ketentuan</a>
        <span>|</span>
        <span class="badge bg-success-subtle text-success border border-success-subtle">PWA Ready</span>
      </div>
    </div>
  </div>
</footer>

<!-- PWA Install Banner Toast -->
<div id="pwaInstallBanner" class="pwa-install-banner" role="alert" aria-live="polite">
  <div class="pwa-banner-content">
    <div class="pwa-banner-left">
      <img src="assets/images/icons/icon-192.png" alt="Sapa Warga" class="pwa-banner-icon">
      <div class="pwa-banner-text">
        <h6 class="pwa-banner-title mb-0">Pasang Aplikasi Sapa Warga</h6>
        <small class="pwa-banner-sub text-muted">Akses cepat &amp; info desa</small>
      </div>
    </div>
    <div class="pwa-banner-actions">
      <button id="btnPwaInstall" class="btn btn-danger btn-sm pwa-btn-install">Pasang</button>
      <button id="btnClosePwa" class="btn btn-outline-secondary pwa-btn-close" aria-label="Tutup"><i class="bi bi-x"></i></button>
    </div>
  </div>
</div>

<!-- Modal Pencarian Global -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
      <div class="modal-header bg-light border-bottom">
        <h6 class="modal-title fw-bold" id="searchModalLabel"><i class="bi bi-search me-2 text-danger"></i>Pencarian Website</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        <div class="input-group mb-3">
          <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
          <input type="text" id="globalSearchInput" class="form-control form-control-lg fs-6" placeholder="Ketik kata kunci (misal: pertanian, wisata, jalan)..." autofocus>
        </div>
        <div id="globalSearchResults" class="mt-3">
          <p class="text-muted small mb-0">Hasil pencarian cepat akan muncul otomatis di sini.</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bottom Nav untuk Mobile -->
<?php require_once __DIR__ . '/bottom-nav.php'; ?>

<!-- Scripts Bootstrap Bundle & Main JS with Auto Cache-Busting -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js?v=<?= file_exists(__DIR__ . '/../assets/js/main.js') ? filemtime(__DIR__ . '/../assets/js/main.js') : '20260914' ?>"></script>
</body>
</html>
