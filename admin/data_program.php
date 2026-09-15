<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

require_admin_auth();

// Handle Add / Edit / Delete (Diproses sebelum render HTML)
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['action'])) {
    if (verify_csrf()) {
        if ($_POST['action'] === 'simpan_program') {
            $id = !empty($_POST['id']) ? (int)$_POST['id'] : null;
            $judul = sanitize($_POST['judul']);
            $slug = slugify($judul);
            $kategori = sanitize($_POST['kategori']);
            $deskripsiSingkat = sanitize($_POST['deskripsi_singkat']);
            $deskripsiLengkap = sanitize($_POST['deskripsi_lengkap']);
            $icon = sanitize($_POST['icon']);
            $badgeColor = sanitize($_POST['badge_color']);
            $targetCapaian = sanitize($_POST['target_capaian'] ?? '');
            $urutan = (int)($_POST['urutan'] ?? 0);

            if ($id) {
                $stmt = $pdo->prepare("UPDATE program SET judul = ?, slug = ?, kategori = ?, deskripsi_singkat = ?, deskripsi_lengkap = ?, icon = ?, badge_color = ?, target_capaian = ?, urutan = ? WHERE id = ?");
                $stmt->execute([$judul, $slug, $kategori, $deskripsiSingkat, $deskripsiLengkap, $icon, $badgeColor, $targetCapaian, $urutan, $id]);
                set_flash('success', 'Program kerja berhasil diperbarui.');
            } else {
                $stmt = $pdo->prepare("INSERT INTO program (judul, slug, kategori, deskripsi_singkat, deskripsi_lengkap, icon, badge_color, target_capaian, urutan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$judul, $slug, $kategori, $deskripsiSingkat, $deskripsiLengkap, $icon, $badgeColor, $targetCapaian, $urutan]);
                set_flash('success', 'Program kerja baru berhasil ditambahkan.');
            }
            safe_redirect("data_program.php");
        } elseif ($_POST['action'] === 'hapus_program') {
            $id = (int)$_POST['id'];
            $stmt = $pdo->prepare("DELETE FROM program WHERE id = ?");
            $stmt->execute([$id]);
            set_flash('success', 'Program kerja berhasil dihapus.');
            safe_redirect("data_program.php");
        }
    }
}

$programs = $pdo->query("SELECT * FROM program ORDER BY urutan ASC")->fetchAll();

require_once __DIR__ . '/header_admin.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h3 class="fw-bold mb-1">Manajemen Program Unggulan</h3>
    <p class="text-muted mb-0">Kelola 7 Program Strategis Edy Susanto untuk Desa Tampirkulon.</p>
  </div>
  <button class="btn btn-danger rounded-pill px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambahProgram">
    <i class="bi bi-plus-circle me-1"></i> Tambah Program
  </button>
</div>

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
  <div class="table-responsive">
    <table class="table table-hover align-middle">
      <thead class="table-light">
        <tr>
          <th>No</th>
          <th>Ikon</th>
          <th>Judul &amp; Kategori</th>
          <th>Ringkasan</th>
          <th>Target Capaian</th>
          <th class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($programs as $p): ?>
        <tr>
          <td><span class="badge bg-secondary rounded-pill">#<?= $p['urutan'] ?></span></td>
          <td>
            <div class="rounded-3 d-flex align-items-center justify-content-center text-white" style="width: 38px; height: 38px; background-color: <?= e($p['badge_color']) ?>;">
              <i class="<?= (strpos($p['icon'], 'fa-') !== false) ? e($p['icon']) : 'bi ' . e($p['icon']) ?> fs-5"></i>
            </div>
          </td>
          <td>
            <strong><?= e($p['judul']) ?></strong><br>
            <span class="badge bg-light text-dark border"><?= e($p['kategori']) ?></span>
          </td>
          <td style="max-width: 300px;">
            <small class="text-muted"><?= e($p['deskripsi_singkat']) ?></small>
          </td>
          <td style="max-width: 250px;">
            <small class="text-secondary"><?= e($p['target_capaian'] ?? '-') ?></small>
          </td>
          <td class="text-end">
            <button class="btn btn-sm btn-outline-danger rounded-3" data-bs-toggle="modal" data-bs-target="#modalEditProgram<?= $p['id'] ?>">
              <i class="bi bi-pencil"></i>
            </button>
            <form action="data_program.php" method="POST" class="d-inline" onsubmit="return confirm('Hapus program ini?');">
              <?= csrf_field() ?>
              <input type="hidden" name="action" value="hapus_program">
              <input type="hidden" name="id" value="<?= $p['id'] ?>">
              <button type="submit" class="btn btn-sm btn-outline-secondary rounded-3">
                <i class="bi bi-trash"></i>
              </button>
            </form>
          </td>
        </tr>

        <!-- Modal Edit Program -->
        <div class="modal fade" id="modalEditProgram<?= $p['id'] ?>" tabindex="-1">
          <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4 border-0 shadow">
              <div class="modal-header bg-light">
                <h6 class="modal-title fw-bold">Edit Program: <?= e($p['judul']) ?></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <form action="data_program.php" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="action" value="simpan_program">
                <input type="hidden" name="id" value="<?= $p['id'] ?>">
                <div class="modal-body p-4">
                  <div class="row g-3">
                    <div class="col-md-8">
                      <label class="form-label small fw-semibold">Judul Program</label>
                      <input type="text" class="form-control" name="judul" value="<?= e($p['judul']) ?>" required>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label small fw-semibold">Urutan</label>
                      <input type="number" class="form-control" name="urutan" value="<?= $p['urutan'] ?>" required>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label small fw-semibold">Kategori</label>
                      <input type="text" class="form-control" name="kategori" value="<?= e($p['kategori']) ?>" required>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label small fw-semibold">Icon Bootstrap (bi-*)</label>
                      <input type="text" class="form-control" name="icon" value="<?= e($p['icon']) ?>" required>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label small fw-semibold">Warna Badge (Hex)</label>
                      <input type="color" class="form-control form-control-color w-100" name="badge_color" value="<?= e($p['badge_color']) ?>" required>
                    </div>
                    <div class="col-12">
                      <label class="form-label small fw-semibold">Deskripsi Singkat (Slogan)</label>
                      <input type="text" class="form-control" name="deskripsi_singkat" value="<?= e($p['deskripsi_singkat']) ?>" required>
                    </div>
                    <div class="col-12">
                      <label class="form-label small fw-semibold">Deskripsi Lengkap</label>
                      <textarea class="form-control" name="deskripsi_lengkap" rows="3" required><?= e($p['deskripsi_lengkap']) ?></textarea>
                    </div>
                    <div class="col-12">
                      <label class="form-label small fw-semibold">Target Capaian</label>
                      <input type="text" class="form-control" name="target_capaian" value="<?= e($p['target_capaian']) ?>">
                    </div>
                  </div>
                </div>
                <div class="modal-footer bg-light">
                  <button type="button" class="btn btn-secondary btn-sm rounded-3" data-bs-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-danger btn-sm rounded-3 fw-bold">Simpan Perubahan</button>
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

<!-- Modal Tambah Program -->
<div class="modal fade" id="modalTambahProgram" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header bg-light">
        <h6 class="modal-title fw-bold">Tambah Program Kerja Baru</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="data_program.php" method="POST">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="simpan_program">
        <div class="modal-body p-4">
          <div class="row g-3">
            <div class="col-md-8">
              <label class="form-label small fw-semibold">Judul Program</label>
              <input type="text" class="form-control" name="judul" placeholder="Contoh: Ketahanan Pangan" required>
            </div>
            <div class="col-md-4">
              <label class="form-label small fw-semibold">Urutan</label>
              <input type="number" class="form-control" name="urutan" value="<?= count($programs) + 1 ?>" required>
            </div>
            <div class="col-md-4">
              <label class="form-label small fw-semibold">Kategori</label>
              <input type="text" class="form-control" name="kategori" placeholder="Ekonomi / Sosial" required>
            </div>
            <div class="col-md-4">
              <label class="form-label small fw-semibold">Icon Bootstrap (bi-*)</label>
              <input type="text" class="form-control" name="icon" value="bi-check-circle" required>
            </div>
            <div class="col-md-4">
              <label class="form-label small fw-semibold">Warna Badge (Hex)</label>
              <input type="color" class="form-control form-control-color w-100" name="badge_color" value="#b71c1c" required>
            </div>
            <div class="col-12">
              <label class="form-label small fw-semibold">Deskripsi Singkat</label>
              <input type="text" class="form-control" name="deskripsi_singkat" placeholder="Slogan atau ringkasan 1 kalimat" required>
            </div>
            <div class="col-12">
              <label class="form-label small fw-semibold">Deskripsi Lengkap</label>
              <textarea class="form-control" name="deskripsi_lengkap" rows="3" placeholder="Rincian program kerja..." required></textarea>
            </div>
            <div class="col-12">
              <label class="form-label small fw-semibold">Target Capaian</label>
              <input type="text" class="form-control" name="target_capaian" placeholder="Sasaran yang terukur">
            </div>
          </div>
        </div>
        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary btn-sm rounded-3" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger btn-sm rounded-3 fw-bold">Tambah Program</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/footer_admin.php'; ?>
