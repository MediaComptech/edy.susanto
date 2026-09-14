<?php
/**
 * Halaman Kontak & Posko Pemenangan
 * Calon Kepala Desa Tampirkulon - Edy Susanto (No. Urut 2)
 */
if (!defined('APP_NAME')) {
    require_once __DIR__ . '/../includes/config.php';
}

$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'kirim_pesan_kontak') {
    if (verify_csrf()) {
        $nama = sanitize($_POST['nama'] ?? '');
        $wa = sanitize($_POST['no_wa'] ?? '');
        $pesan = sanitize($_POST['pesan'] ?? '');

        // Notifikasi PWA
        create_pwa_notification(
            $pdo,
            "Pesan Masuk dari $nama",
            "Pesan via Kontak: " . substr($pesan, 0, 80),
            "admin/index.php"
        );
        set_flash('success', "Terima kasih <strong>$nama</strong>! Pesan Anda telah diterima tim kami dan akan segera dihubungi.");
        header("Location: index.php?page=kontak");
        exit;
    } else {
        set_flash('danger', 'Validasi sesi gagal, silakan ulangi pengiriman pesan.');
    }
}
?>

<div class="container-custom py-5">
  <?= render_flash() ?>

  <div class="text-center max-w-700 mx-auto mb-5">
    <span class="badge bg-danger-subtle text-danger fw-bold px-3 py-2 rounded-pill mb-2">
      <i class="bi bi-chat-left-dots-fill me-1"></i> Terhubung Langsung
    </span>
    <h1 class="fw-bold display-5 text-dark mb-2">Kontak &amp; Posko Silaturahmi</h1>
    <p class="text-muted fs-5">Pintu komunikasi selalu terbuka bagi seluruh elemen masyarakat Desa Tampirkulon.</p>
  </div>

  <div class="row g-5">
    <!-- Kolom Kiri: Detail Informasi & Peta -->
    <div class="col-lg-5">
      <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white h-100">
        <h4 class="fw-bold text-dark mb-4">Informasi Posko Warga</h4>

        <div class="d-flex gap-3 mb-4">
          <div class="bg-danger-subtle text-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; flex-shrink: 0;">
            <i class="bi bi-geo-alt-fill fs-5"></i>
          </div>
          <div>
            <h6 class="fw-bold text-dark mb-1">Alamat Posko Utama</h6>
            <p class="text-muted small mb-0"><?= ALAMAT_DESA ?></p>
          </div>
        </div>

        <div class="d-flex gap-3 mb-4">
          <div class="bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; flex-shrink: 0;">
            <i class="bi bi-whatsapp fs-5"></i>
          </div>
          <div>
            <h6 class="fw-bold text-dark mb-1">WhatsApp Center</h6>
            <p class="text-muted small mb-1">+<?= WHATSAPP_NUMBER ?></p>
            <a href="https://wa.me/<?= WHATSAPP_NUMBER ?>?text=Halo%20Pak%20Edy%20Susanto" target="_blank" class="btn btn-sm btn-success rounded-pill px-3 fw-bold">
              Chat Sekarang &rarr;
            </a>
          </div>
        </div>

        <div class="d-flex gap-3 mb-4">
          <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; flex-shrink: 0;">
            <i class="bi bi-envelope-fill fs-5"></i>
          </div>
          <div>
            <h6 class="fw-bold text-dark mb-1">Email Resmi</h6>
            <p class="text-muted small mb-0"><?= EMAIL_DESA ?></p>
          </div>
        </div>

        <div class="p-3 bg-light rounded-3 mt-auto">
          <small class="text-muted d-block mb-1">Jam Pelayanan Posko:</small>
          <strong class="text-dark small">Setiap Hari: 08.00 - 21.00 WIB</strong>
        </div>
      </div>
    </div>

    <!-- Kolom Kanan: Formulir Kirim Pesan Cepat -->
    <div class="col-lg-7">
      <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
        <h4 class="fw-bold text-dark mb-2">Kirim Pesan / Permohonan Silaturahmi</h4>
        <p class="text-muted small mb-4">Ingin mengundang Pak Edy Susanto ke kegiatan dusun atau bertukar pikiran langsung? Silakan isi form di bawah ini.</p>

        <form action="index.php?page=kontak" method="POST">
          <?= csrf_field() ?>
          <input type="hidden" name="action" value="kirim_pesan_kontak">

          <div class="mb-3">
            <label for="namaKontak" class="form-label fw-semibold small">Nama Lengkap <span class="text-danger">*</span></label>
            <input type="text" class="form-control rounded-3" id="namaKontak" name="nama" placeholder="Masukkan nama Anda" required>
          </div>

          <div class="mb-3">
            <label for="waKontak" class="form-label fw-semibold small">Nomor WhatsApp / HP <span class="text-danger">*</span></label>
            <input type="tel" class="form-control rounded-3" id="waKontak" name="no_wa" placeholder="08xxxxxxxxxx" required>
          </div>

          <div class="mb-4">
            <label for="pesanKontak" class="form-label fw-semibold small">Pesan / Agenda <span class="text-danger">*</span></label>
            <textarea class="form-control rounded-3" id="pesanKontak" name="pesan" rows="4" placeholder="Tuliskan pesan, permohonan kunjungan, atau pertanyaan Anda..." required></textarea>
          </div>

          <button type="submit" class="btn btn-danger btn-lg rounded-pill px-5 fw-bold w-100 shadow-sm">
            <i class="bi bi-send-fill me-2"></i> Kirim Pesan
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
