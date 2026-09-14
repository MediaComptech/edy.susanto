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
        } elseif ($_POST['action'] === 'edit_foto') {
            $id = (int)$_POST['id'];
            $judul = sanitize($_POST['judul']);
            $kategori = sanitize($_POST['kategori'] ?? 'Dokumentasi');
            $deskripsi = sanitize($_POST['deskripsi'] ?? '');

            if (!empty($_FILES['foto_baru']['name'])) {
                $upload = handle_file_upload($_FILES['foto_baru'], 'uploads', 5);
                if ($upload['status']) {
                    $stmt = $pdo->prepare("UPDATE galeri SET judul = ?, deskripsi = ?, foto = ?, kategori = ? WHERE id = ?");
                    $stmt->execute([$judul, $deskripsi, $upload['relative_path'], $kategori, $id]);
                    set_flash('success', 'Foto dan data galeri berhasil diperbarui.');
                } else {
                    set_flash('danger', $upload['error']);
                }
            } else {
                $stmt = $pdo->prepare("UPDATE galeri SET judul = ?, deskripsi = ?, kategori = ? WHERE id = ?");
                $stmt->execute([$judul, $deskripsi, $kategori, $id]);
                set_flash('success', 'Data galeri berhasil diperbarui.');
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
    <?php if (empty($galeri)): ?>
      <div class="col-12 text-center py-5 text-muted">
        <i class="bi bi-images fs-1 d-block mb-2 text-secondary"></i>
        Belum ada foto galeri yang diunggah.
      </div>
    <?php else: ?>
      <?php foreach ($galeri as $item): ?>
      <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="card border rounded-3 overflow-hidden h-100 shadow-sm d-flex flex-column">
          <img src="../<?= e($item['foto']) ?>" alt="<?= e($item['judul']) ?>" style="height: 160px; object-fit: cover;" class="w-100">
          <div class="p-2 d-flex flex-column flex-grow-1">
            <h6 class="fw-bold small mb-1 text-truncate" title="<?= e($item['judul']) ?>"><?= e($item['judul']) ?></h6>
            <small class="text-muted mb-2 flex-grow-1" style="font-size: 0.8rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"><?= e($item['deskripsi'] ?? '-') ?></small>
            <div class="d-flex justify-content-between align-items-center pt-2 border-top mt-auto">
              <span class="badge bg-light text-dark border" style="font-size: 0.7rem;"><?= e($item['kategori'] ?? 'Dokumentasi') ?></span>
              <div class="d-flex gap-1">
                <button type="button" class="btn btn-xs btn-outline-primary py-0 px-2 btn-edit-galeri"
                  data-id="<?= $item['id'] ?>"
                  data-judul="<?= htmlspecialchars($item['judul'], ENT_QUOTES) ?>"
                  data-deskripsi="<?= htmlspecialchars($item['deskripsi'] ?? '', ENT_QUOTES) ?>"
                  data-kategori="<?= htmlspecialchars($item['kategori'] ?? 'Dokumentasi', ENT_QUOTES) ?>"
                  data-foto="../<?= e($item['foto']) ?>">
                  <i class="bi bi-pencil me-1"></i>Edit
                </button>
                <form action="data_galeri.php" method="POST" onsubmit="return confirm('Hapus foto ini?');" class="d-inline mb-0">
                  <?= csrf_field() ?>
                  <input type="hidden" name="action" value="hapus_foto">
                  <input type="hidden" name="id" value="<?= $item['id'] ?>">
                  <button type="submit" class="btn btn-xs btn-outline-danger py-0 px-2">Hapus</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>

<!-- Modal Tambah Foto -->
<div class="modal fade" id="modalTambahFoto" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header bg-light">
        <h6 class="modal-title fw-bold"><i class="bi bi-upload me-2 text-danger"></i>Upload Foto Baru</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="data_galeri.php" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="tambah_foto">
        <div class="modal-body p-4">
          <div class="mb-3">
            <label class="form-label small fw-semibold">Judul Dokumentasi</label>
            <input type="text" class="form-control" name="judul" required placeholder="Contoh: Kerja Bakti Dusun">
          </div>
          <div class="mb-3">
            <label class="form-label small fw-semibold">Kategori</label>
            <input type="text" class="form-control" name="kategori" value="Kegiatan" placeholder="Contoh: Kegiatan, Wisata, Pertanian">
          </div>
          <div class="mb-3">
            <label class="form-label small fw-semibold">Deskripsi Singkat</label>
            <textarea class="form-control" name="deskripsi" rows="3" placeholder="Keterangan foto..."></textarea>
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

<!-- Modal Edit Foto Galeri -->
<div class="modal fade" id="modalEditGaleri" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header bg-light">
        <h6 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2 text-primary"></i>Edit Foto Galeri</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="data_galeri.php" method="POST" enctype="multipart/form-data" id="formEditGaleri">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="edit_foto">
        <input type="hidden" name="id" id="editGaleriId">
        <div class="modal-body p-4">
          <!-- Preview Foto Saat Ini -->
          <div class="mb-3 text-center">
            <label class="form-label small fw-semibold d-block text-start">Foto Saat Ini</label>
            <div class="bg-light p-2 rounded-3 border">
              <img id="editGaleriFotoPreview" src="" alt="Preview Foto" class="img-fluid rounded-2 shadow-sm" style="max-height: 180px; object-fit: cover; width: 100%;">
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-semibold">Ganti Foto (Opsional)</label>
            <input type="file" class="form-control" id="editGaleriFotoBaru" name="foto_baru" accept="image/*">
            <div class="form-text small">Biarkan kosong jika tidak ingin mengganti file foto.</div>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-semibold">Judul Dokumentasi</label>
            <input type="text" class="form-control" name="judul" id="editGaleriJudul" required>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-semibold">Kategori</label>
            <input type="text" class="form-control" name="kategori" id="editGaleriKategori">
          </div>
          <div class="mb-3">
            <label class="form-label small fw-semibold">Deskripsi Singkat</label>
            <textarea class="form-control" name="deskripsi" id="editGaleriDeskripsi" rows="3" placeholder="Keterangan foto..."></textarea>
          </div>
        </div>
        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary btn-sm rounded-3" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary btn-sm rounded-3 fw-bold">
            <i class="bi bi-save me-1"></i>Simpan Perubahan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const modalEditEl = document.getElementById('modalEditGaleri');
  if (!modalEditEl) return;
  const modalEdit = new bootstrap.Modal(modalEditEl);
  
  const idInput = document.getElementById('editGaleriId');
  const judulInput = document.getElementById('editGaleriJudul');
  const kategoriInput = document.getElementById('editGaleriKategori');
  const deskripsiInput = document.getElementById('editGaleriDeskripsi');
  const previewImg = document.getElementById('editGaleriFotoPreview');
  const fileInput = document.getElementById('editGaleriFotoBaru');
  let originalFotoSrc = '';

  document.querySelectorAll('.btn-edit-galeri').forEach(btn => {
    btn.addEventListener('click', function() {
      idInput.value = this.dataset.id || '';
      judulInput.value = this.dataset.judul || '';
      kategoriInput.value = this.dataset.kategori || '';
      deskripsiInput.value = this.dataset.deskripsi || '';
      originalFotoSrc = this.dataset.foto || '';
      previewImg.src = originalFotoSrc;
      fileInput.value = ''; // Reset input file
      modalEdit.show();
    });
  });

  // Live preview ganti foto
  fileInput.addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        previewImg.src = e.target.result;
      };
      reader.readAsDataURL(file);
    } else {
      previewImg.src = originalFotoSrc;
    }
  });
});
</script>

<?php require_once __DIR__ . '/footer_admin.php'; ?>
