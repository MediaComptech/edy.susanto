<?php
require_once __DIR__ . '/header_admin.php';

// Handle Add / Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if (verify_csrf()) {
        if ($_POST['action'] === 'tambah_foto') {
            $judul = sanitize($_POST['judul']);
            $kategori = sanitize($_POST['kategori'] ?? 'Dokumentasi');
            $deskripsi = sanitize($_POST['deskripsi'] ?? '');

            if (!empty($_FILES['foto']['name'])) {
                $upload = handle_file_upload($_FILES['foto'], 'uploads', 5);
                if ($upload['status']) {
                    $stmt = $pdo->prepare("INSERT INTO galeri (judul, deskripsi, foto, kategori) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$judul, $deskripsi, $upload['relative_path'], $kategori]);
                    set_flash('success', 'Foto dokumentasi berhasil ditambahkan.');
                } else {
                    set_flash('danger', $upload['error']);
                }
            } else {
                set_flash('danger', 'File foto wajib diunggah.');
            }
            header("Location: data_galeri.php");
            exit;
        } elseif ($_POST['action'] === 'hapus_foto') {
            $id = (int)$_POST['id'];
            $stmt = $pdo->prepare("DELETE FROM galeri WHERE id = ?");
            $stmt->execute([$id]);
            set_flash('success', 'Foto dokumentasi berhasil dihapus.');
            header("Location: data_galeri.php");
            exit;
        }
    }
}

$galeri = $pdo->query("SELECT * FROM galeri ORDER BY created_at DESC")->fetchAll();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h3 class="fw-bold mb-1">Galeri Dokumentasi Kegiatan</h3>
    <p class="text-muted mb-0">Kelola arsip foto kegiatan silaturahmi, rembug warga, dan potensi desa.</p>
  </div>
  <button class="btn btn-danger rounded-pill px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambahFoto">
    <i class="bi bi-upload me-1"></i> Upload Foto
  </button>
</div>

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
  <div class="row g-3">
    <?php foreach ($galeri as $item): ?>
    <div class="col-sm-6 col-md-4 col-lg-3">
      <div class="card border rounded-3 overflow-hidden h-100 shadow-sm">
        <img src="../<?= e($item['foto']) ?>" alt="<?= e($item['judul']) ?>" style="height: 160px; object-fit: cover;">
        <div class="p-2 d-flex flex-column flex-grow-1">
          <h6 class="fw-bold small mb-1 text-truncate"><?= e($item['judul']) ?></h6>
          <small class="text-muted mb-2 flex-grow-1"><?= e($item['deskripsi']) ?></small>
          <div class="d-flex justify-content-between align-items-center pt-1 border-top">
            <span class="badge bg-light text-dark border" style="font-size: 0.7rem;"><?= e($item['kategori']) ?></span>
            <form action="data_galeri.php" method="POST" onsubmit="return confirm('Hapus foto ini?');">
              <?= csrf_field() ?>
              <input type="hidden" name="action" value="hapus_foto">
              <input type="hidden" name="id" value="<?= $item['id'] ?>">
              <button type="submit" class="btn btn-xs btn-outline-danger py-0 px-2">Hapus</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>

<!-- Modal Tambah Foto -->
<div class="modal fade" id="modalTambahFoto" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header bg-light">
        <h6 class="modal-title fw-bold">Upload Foto Baru</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="data_galeri.php" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="tambah_foto">
        <div class="modal-body p-4">
          <div class="mb-3">
            <label class="form-label small fw-semibold">Judul Dokumentasi</label>
            <input type="text" class="form-control" name="judul" required>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-semibold">Kategori</label>
            <input type="text" class="form-control" name="kategori" value="Kegiatan">
          </div>
          <div class="mb-3">
            <label class="form-label small fw-semibold">Deskripsi Singkat</label>
            <input type="text" class="form-control" name="deskripsi" placeholder="Keterangan foto...">
          </div>
          <div class="mb-3">
            <label class="form-label small fw-semibold">Berkas Foto</label>
            <input type="file" class="form-control" name="foto" accept="image/*" required>
          </div>
        </div>
        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary btn-sm rounded-3" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger btn-sm rounded-3 fw-bold">Upload</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/footer_admin.php'; ?>
