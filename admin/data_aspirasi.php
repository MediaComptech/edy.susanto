<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

require_admin_auth();

// Handle Update Status & Tanggapan (Diproses sebelum render HTML)
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['action'])) {
    if (verify_csrf()) {
        if ($_POST['action'] === 'update_aspirasi') {
            $id = (int)$_POST['id'];
            $status = sanitize($_POST['status']);
            $tanggapan = sanitize($_POST['tanggapan'] ?? '');

            $stmt = $pdo->prepare("UPDATE aspirasi SET status = ?, tanggapan = ?, tanggal_tanggapan = NOW() WHERE id = ?");
            $stmt->execute([$status, $tanggapan, $id]);

            // Broadcast PWA jika diberi tanggapan
            $asp = $pdo->query("SELECT kode_tiket, dusun FROM aspirasi WHERE id = $id")->fetch();
            if ($asp) {
                create_pwa_notification($pdo, "Update Aspirasi {$asp['kode_tiket']}", "Status di {$asp['dusun']} kini: $status", "index.php?page=sapa-warga#feedAspirasi");
            }

            set_flash('success', 'Status & tanggapan aspirasi berhasil diperbarui.');
            safe_redirect("data_aspirasi.php");
        } elseif ($_POST['action'] === 'hapus_aspirasi') {
            $id = (int)$_POST['id'];
            $stmt = $pdo->prepare("DELETE FROM aspirasi WHERE id = ?");
            $stmt->execute([$id]);
            set_flash('success', 'Aspirasi berhasil dihapus.');
            safe_redirect("data_aspirasi.php");
        }
    } else {
        set_flash('danger', 'Validasi sesi CSRF gagal.');
    }
}

// Filter
$statusFilter = sanitize($_GET['status'] ?? 'all');
$query = "SELECT * FROM aspirasi";
$params = [];

if ($statusFilter !== 'all') {
    $query .= " WHERE status = ?";
    $params[] = $statusFilter;
}
$query .= " ORDER BY created_at DESC";

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$aspirasiList = $stmt->fetchAll();

require_once __DIR__ . '/header_admin.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h3 class="fw-bold mb-1">Manajemen Aspirasi Sapa Warga</h3>
    <p class="text-muted mb-0">Tinjau, tindak lanjuti, dan berikan tanggapan resmi tim pemenangan terhadap aspirasi warga.</p>
  </div>
</div>

<!-- Filter Tabs -->
<div class="card border-0 shadow-sm rounded-4 p-3 bg-white mb-4">
  <div class="d-flex flex-wrap gap-2 align-items-center">
    <span class="small fw-bold text-muted me-2">Filter Status:</span>
    <a href="data_aspirasi.php" class="btn btn-sm <?= $statusFilter === 'all' ? 'btn-danger' : 'btn-light' ?> rounded-pill">Semua</a>
    <a href="data_aspirasi.php?status=Dalam Proses" class="btn btn-sm <?= $statusFilter === 'Dalam Proses' ? 'btn-warning text-dark fw-bold' : 'btn-light' ?> rounded-pill">Dalam Proses</a>
    <a href="data_aspirasi.php?status=Selesai" class="btn btn-sm <?= $statusFilter === 'Selesai' ? 'btn-success fw-bold' : 'btn-light' ?> rounded-pill">Selesai</a>
    <a href="data_aspirasi.php?status=Rencana Program" class="btn btn-sm <?= $statusFilter === 'Rencana Program' ? 'btn-primary fw-bold' : 'btn-light' ?> rounded-pill">Rencana Program</a>
  </div>
</div>

<!-- List Aspirasi Table -->
<div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
  <div class="table-responsive">
    <table class="table table-hover align-middle">
      <thead class="table-light">
        <tr>
          <th>Tiket</th>
          <th>Warga</th>
          <th>Dusun &amp; Kategori</th>
          <th>Aspirasi</th>
          <th>Status</th>
          <th>Tanggapan</th>
          <th class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($aspirasiList as $item): ?>
        <tr>
          <td><code class="fw-bold"><?= e($item['kode_tiket']) ?></code></td>
          <td>
            <strong><?= $item['is_anonim'] ? 'Anonim' : e($item['nama_warga']) ?></strong><br>
            <small class="text-muted"><?= format_tanggal_id($item['created_at'], true) ?></small>
          </td>
          <td>
            <span class="d-block fw-semibold text-dark"><?= e($item['dusun']) ?></span>
            <span class="badge bg-light text-dark border"><?= e($item['kategori']) ?></span>
          </td>
          <td style="max-width: 280px;">
            <div class="small text-secondary"><?= e($item['isi_aspirasi']) ?></div>
            <?php if (!empty($item['foto'])): ?>
              <a href="../<?= e($item['foto']) ?>" target="_blank" class="small text-danger fw-bold d-inline-block mt-1">
                <i class="bi bi-image me-1"></i>Lihat Lampiran
              </a>
            <?php endif; ?>
          </td>
          <td>
            <span class="badge <?= $item['status'] === 'Selesai' ? 'bg-success' : ($item['status'] === 'Dalam Proses' ? 'bg-warning text-dark' : 'bg-primary') ?>">
              <?= e($item['status']) ?>
            </span>
          </td>
          <td style="max-width: 220px;">
            <small class="text-muted"><?= !empty($item['tanggapan']) ? e(substr($item['tanggapan'], 0, 80)) . '...' : '<em class="text-muted">Belum ada</em>' ?></small>
          </td>
          <td class="text-end">
            <button class="btn btn-sm btn-outline-danger rounded-3" data-bs-toggle="modal" data-bs-target="#editModal<?= $item['id'] ?>">
              <i class="bi bi-pencil-square"></i> Tanggapi
            </button>
            <form action="data_aspirasi.php" method="POST" class="d-inline" onsubmit="return confirm('Hapus aspirasi ini secara permanen?');">
              <?= csrf_field() ?>
              <input type="hidden" name="action" value="hapus_aspirasi">
              <input type="hidden" name="id" value="<?= $item['id'] ?>">
              <button type="submit" class="btn btn-sm btn-outline-secondary rounded-3">
                <i class="bi bi-trash"></i>
              </button>
            </form>
          </td>
        </tr>

        <!-- Modal Tanggapan & Ubah Status -->
        <div class="modal fade" id="editModal<?= $item['id'] ?>" tabindex="-1">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
              <div class="modal-header bg-light">
                <h6 class="modal-title fw-bold">Tindak Lanjut Tiket <?= e($item['kode_tiket']) ?></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <form action="data_aspirasi.php" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="action" value="update_aspirasi">
                <input type="hidden" name="id" value="<?= $item['id'] ?>">
                <div class="modal-body p-4">
                  <div class="p-3 bg-light rounded-3 mb-3 small">
                    <strong>Aspirasi:</strong> <?= e($item['isi_aspirasi']) ?>
                  </div>

                  <div class="mb-3">
                    <label class="form-label small fw-semibold">Status Tindak Lanjut</label>
                    <select class="form-select" name="status">
                      <option value="Dalam Proses" <?= $item['status'] === 'Dalam Proses' ? 'selected' : '' ?>>Dalam Proses</option>
                      <option value="Selesai" <?= $item['status'] === 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                      <option value="Rencana Program" <?= $item['status'] === 'Rencana Program' ? 'selected' : '' ?>>Rencana Program</option>
                    </select>
                  </div>

                  <div class="mb-3">
                    <label class="form-label small fw-semibold">Tanggapan Resmi Tim / Calon</label>
                    <textarea class="form-control" name="tanggapan" rows="4" placeholder="Tuliskan respon atau kabar tindak lanjut fisik yang dilakukan..."><?= e($item['tanggapan']) ?></textarea>
                  </div>
                </div>
                <div class="modal-footer bg-light">
                  <button type="button" class="btn btn-secondary rounded-3 btn-sm" data-bs-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-danger rounded-3 btn-sm fw-bold">Simpan &amp; Notifikasikan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once __DIR__ . '/footer_admin.php'; ?>
