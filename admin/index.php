<?php
require_once __DIR__ . '/header_admin.php';

// Handle Broadcast Notifikasi PWA
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'broadcast_notif') {
    if (verify_csrf()) {
        $judul = sanitize($_POST['judul_notif'] ?? '');
        $pesan = sanitize($_POST['pesan_notif'] ?? '');
        $url = sanitize($_POST['url_notif'] ?? 'index.php?page=sapa-warga');

        if (!empty($judul) && !empty($pesan)) {
            create_pwa_notification($pdo, $judul, $pesan, $url);
            set_flash('success', 'Notifikasi PWA berhasil disimpan & disiarkan ke pengguna website.');
            header("Location: index.php");
            exit;
        } else {
            set_flash('danger', 'Judul dan pesan notifikasi wajib diisi.');
        }
    } else {
        set_flash('danger', 'Validasi sesi CSRF gagal.');
    }
}

// Statistik
$stats = get_aspirasi_stats($pdo);
$cntProgram = $pdo->query("SELECT COUNT(*) FROM program")->fetchColumn();
$cntBerita = $pdo->query("SELECT COUNT(*) FROM berita")->fetchColumn();
$cntGaleri = $pdo->query("SELECT COUNT(*) FROM galeri")->fetchColumn();

// 5 Aspirasi Terkini
$recentAspirasi = $pdo->query("SELECT * FROM aspirasi ORDER BY created_at DESC LIMIT 5")->fetchAll();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h3 class="fw-bold mb-1">Dashboard Administrator</h3>
    <p class="text-muted mb-0">Selamat datang kembali, <strong><?= e($_SESSION['admin_nama'] ?? 'Admin') ?></strong>.</p>
  </div>
  <a href="../index.php" target="_blank" class="btn btn-outline-danger btn-sm rounded-pill px-3">
    <i class="bi bi-globe me-1"></i> Buka Website Tampirkulon
  </a>
</div>

<!-- 4 Stat Cards Row -->
<div class="row g-3 mb-4">
  <div class="col-sm-6 col-xl-3">
    <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
      <div class="d-flex align-items-center gap-3">
        <div class="rounded-3 bg-danger-subtle text-danger d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
          <i class="bi bi-chat-quote-fill fs-4"></i>
        </div>
        <div>
          <h4 class="fw-bold mb-0"><?= $stats['total'] ?></h4>
          <small class="text-muted">Total Aspirasi Masuk</small>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-xl-3">
    <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
      <div class="d-flex align-items-center gap-3">
        <div class="rounded-3 bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
          <i class="bi bi-grid-fill fs-4"></i>
        </div>
        <div>
          <h4 class="fw-bold mb-0"><?= $cntProgram ?></h4>
          <small class="text-muted">Program Kerja Aktif</small>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-xl-3">
    <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
      <div class="d-flex align-items-center gap-3">
        <div class="rounded-3 bg-success-subtle text-success d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
          <i class="bi bi-newspaper fs-4"></i>
        </div>
        <div>
          <h4 class="fw-bold mb-0"><?= $cntBerita ?></h4>
          <small class="text-muted">Artikel &amp; Kegiatan</small>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-xl-3">
    <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
      <div class="d-flex align-items-center gap-3">
        <div class="rounded-3 bg-warning-subtle text-warning d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
          <i class="bi bi-images fs-4"></i>
        </div>
        <div>
          <h4 class="fw-bold mb-0"><?= $cntGaleri ?></h4>
          <small class="text-muted">Dokumentasi Foto</small>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row g-4">
  <!-- Kolom Kiri: Aspirasi Masuk Terbaru -->
  <div class="col-lg-7">
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0">Aspirasi Terkini Warga</h5>
        <a href="data_aspirasi.php" class="btn btn-sm btn-outline-danger rounded-pill px-3">Kelola Semua</a>
      </div>

      <div class="table-responsive">
        <table class="table table-hover align-middle small">
          <thead class="table-light">
            <tr>
              <th>Tiket</th>
              <th>Warga &amp; Dusun</th>
              <th>Kategori</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($recentAspirasi as $row): ?>
            <tr>
              <td><code><?= e($row['kode_tiket']) ?></code></td>
              <td>
                <strong><?= $row['is_anonim'] ? 'Anonim' : e($row['nama_warga']) ?></strong><br>
                <small class="text-muted"><?= e($row['dusun']) ?></small>
              </td>
              <td><span class="badge bg-light text-dark border"><?= e($row['kategori']) ?></span></td>
              <td>
                <span class="badge <?= $row['status'] === 'Selesai' ? 'bg-success' : ($row['status'] === 'Dalam Proses' ? 'bg-warning text-dark' : 'bg-primary') ?>">
                  <?= e($row['status']) ?>
                </span>
              </td>
              <td>
                <a href="data_aspirasi.php?id=<?= $row['id'] ?>" class="btn btn-xs btn-outline-secondary py-0 px-2">Buka</a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Kolom Kanan: Kirim Siaran Notifikasi PWA Terintegrasi -->
  <div class="col-lg-5">
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white border-top border-4 border-danger">
      <div class="d-flex align-items-center gap-2 mb-3">
        <div class="rounded-circle bg-danger-subtle text-danger d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
          <i class="bi bi-broadcast fs-5"></i>
        </div>
        <h5 class="fw-bold mb-0">Kirim Notifikasi PWA Warga</h5>
      </div>
      <p class="text-muted small mb-3">Kirimkan siaran pemberitahuan langsung ke ponsel atau peramban warga yang telah memasang PWA atau mengaktifkan notifikasi.</p>

      <form action="index.php" method="POST">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="broadcast_notif">

        <div class="mb-3">
          <label class="form-label small fw-semibold">Judul Notifikasi</label>
          <input type="text" class="form-control" name="judul_notif" placeholder="Misal: Update Perbaikan Jalan Dusun Krajan" required>
        </div>

        <div class="mb-3">
          <label class="form-label small fw-semibold">Isi Pesan Notifikasi</label>
          <textarea class="form-control" name="pesan_notif" rows="3" placeholder="Tuliskan pesan ringkas untuk warga..." required></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label small fw-semibold">URL Tujuan Saat Diklik</label>
          <input type="text" class="form-control" name="url_notif" value="index.php?page=sapa-warga">
        </div>

        <button type="submit" class="btn btn-danger w-100 rounded-3 fw-bold">
          <i class="bi bi-send-fill me-1"></i> Siarkan Notifikasi Sekarang
        </button>
      </form>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/footer_admin.php'; ?>
