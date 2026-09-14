<?php
require_once __DIR__ . '/header_admin.php';

// Handle Add / Edit / Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if (verify_csrf()) {
        if ($_POST['action'] === 'simpan_berita') {
            $id = !empty($_POST['id']) ? (int)$_POST['id'] : null;
            $judul = sanitize($_POST['judul']);
            $slug = slugify($judul);
            $kategori = sanitize($_POST['kategori']);
            $ringkasan = sanitize($_POST['ringkasan']);
            $konten = $_POST['konten']; // Allow safe html
            $penulis = sanitize($_POST['penulis'] ?? 'Tim Edy Susanto');
            $fotoPath = null;

            if (!empty($_FILES['foto']['name'])) {
                $upload = handle_file_upload($_FILES['foto'], 'uploads', 5);
                if ($upload['status']) {
                    $fotoPath = $upload['relative_path'];
                }
            }

            if ($id) {
                if ($fotoPath) {
                    $stmt = $pdo->prepare("UPDATE berita SET judul = ?, slug = ?, kategori = ?, ringkasan = ?, konten = ?, foto = ?, penulis = ? WHERE id = ?");
                    $stmt->execute([$judul, $slug, $kategori, $ringkasan, $konten, $fotoPath, $penulis, $id]);
                } else {
                    $stmt = $pdo->prepare("UPDATE berita SET judul = ?, slug = ?, kategori = ?, ringkasan = ?, konten = ?, penulis = ? WHERE id = ?");
                    $stmt->execute([$judul, $slug, $kategori, $ringkasan, $konten, $penulis, $id]);
                }
                set_flash('success', 'Berita berhasil diperbarui.');
            } else {
                $stmt = $pdo->prepare("INSERT INTO berita (judul, slug, kategori, ringkasan, konten, foto, penulis) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$judul, $slug, $kategori, $ringkasan, $konten, $fotoPath, $penulis]);
                
                // Broadcast Notifikasi PWA
                create_pwa_notification($pdo, "Kabar Terbaru: $judul", $ringkasan, "index.php?page=berita");

                set_flash('success', 'Berita berhasil diterbitkan.');
            }
            header("Location: data_berita.php");
            exit;
        } elseif ($_POST['action'] === 'hapus_berita') {
            $id = (int)$_POST['id'];
            $stmt = $pdo->prepare("DELETE FROM berita WHERE id = ?");
            $stmt->execute([$id]);
            set_flash('success', 'Berita berhasil dihapus.');
            header("Location: data_berita.php");
            exit;
        }
    }
}

$beritaList = $pdo->query("SELECT * FROM berita ORDER BY created_at DESC")->fetchAll();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h3 class="fw-bold mb-1">Manajemen Berita &amp; Kegiatan</h3>
    <p class="text-muted mb-0">Publikasikan kabar terbaru, temu warga, dan agenda kampanye.</p>
  </div>
  <button class="btn btn-danger rounded-pill px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambahBerita">
    <i class="bi bi-plus-circle me-1"></i> Tulis Berita
  </button>
</div>

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
  <div class="table-responsive">
    <table class="table table-hover align-middle">
      <thead class="table-light">
        <tr>
          <th>Foto</th>
          <th>Judul &amp; Penulis</th>
          <th>Kategori</th>
          <th>Ringkasan</th>
          <th>Tanggal</th>
          <th class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($beritaList as $b): ?>
        <tr>
          <td style="width: 70px;">
            <?php if (!empty($b['foto'])): ?>
              <img src="../<?= e($b['foto']) ?>" alt="" class="rounded-3" style="width: 60px; height: 45px; object-fit: cover;">
            <?php else: ?>
              <div class="bg-light rounded-3 d-flex align-items-center justify-content-center text-muted" style="width: 60px; height: 45px;">
                <i class="bi bi-image"></i>
              </div>
            <?php endif; ?>
          </td>
          <td>
            <strong><?= e($b['judul']) ?></strong><br>
            <small class="text-muted"><?= e($b['penulis']) ?></small>
          </td>
          <td><span class="badge bg-light text-dark border"><?= e($b['kategori']) ?></span></td>
          <td style="max-width: 300px;"><small class="text-muted"><?= e(substr($b['ringkasan'], 0, 80)) ?>...</small></td>
          <td><small class="text-secondary"><?= format_tanggal_id($b['created_at']) ?></small></td>
          <td class="text-end">
            <form action="data_berita.php" method="POST" class="d-inline" onsubmit="return confirm('Hapus artikel ini?');">
              <?= csrf_field() ?>
              <input type="hidden" name="action" value="hapus_berita">
              <input type="hidden" name="id" value="<?= $b['id'] ?>">
              <button type="submit" class="btn btn-sm btn-outline-secondary rounded-3">
                <i class="bi bi-trash"></i>
              </button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Modal Tambah Berita -->
<div class="modal fade" id="modalTambahBerita" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header bg-light">
        <h6 class="modal-title fw-bold">Tulis Berita Baru</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="data_berita.php" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="simpan_berita">
        <div class="modal-body p-4">
          <div class="row g-3">
            <div class="col-md-8">
              <label class="form-label small fw-semibold">Judul Berita</label>
              <input type="text" class="form-control" name="judul" required>
            </div>
            <div class="col-md-4">
              <label class="form-label small fw-semibold">Kategori</label>
              <select class="form-select" name="kategori">
                <option value="Kegiatan">Kegiatan</option>
                <option value="Potensi">Potensi</option>
                <option value="Sosialisasi">Sosialisasi</option>
                <option value="Pengumuman">Pengumuman</option>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label small fw-semibold">Ringkasan Berita</label>
              <textarea class="form-control" name="ringkasan" rows="2" required></textarea>
            </div>
            <div class="col-12">
              <label class="form-label small fw-semibold">Konten Lengkap</label>
              <textarea class="form-control" name="konten" rows="5" required></textarea>
            </div>
            <div class="col-md-6">
              <label class="form-label small fw-semibold">Foto Berita</label>
              <input type="file" class="form-control" name="foto" accept="image/*">
            </div>
            <div class="col-md-6">
              <label class="form-label small fw-semibold">Penulis</label>
              <input type="text" class="form-control" name="penulis" value="Tim Media Edy Susanto">
            </div>
          </div>
        </div>
        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary btn-sm rounded-3" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger btn-sm rounded-3 fw-bold">Terbitkan Berita</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/footer_admin.php'; ?>
