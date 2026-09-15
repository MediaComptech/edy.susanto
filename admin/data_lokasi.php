<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

require_admin_auth();

// Handle Add / Edit / Delete Lokasi Potensi (Diproses sebelum me-render output HTML)
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['action'])) {
    if (verify_csrf()) {
        if ($_POST['action'] === 'tambah_lokasi') {
            $nama = sanitize($_POST['nama']);
            $kategori = sanitize($_POST['kategori']);
            $kategori_label = sanitize($_POST['kategori_label'] ?? $nama);
            $jarak = sanitize($_POST['jarak'] ?? '');
            $lokasi = sanitize($_POST['lokasi'] ?? '');
            $lat = (float)$_POST['lat'];
            $lng = (float)$_POST['lng'];
            $deskripsi = sanitize($_POST['deskripsi'] ?? '');
            $icon = sanitize($_POST['icon'] ?? 'bi-geo-alt-fill');
            $color = sanitize($_POST['color'] ?? '#0288d1');
            $urutan = (int)($_POST['urutan'] ?? 0);
            $fotoPath = 'assets/images/potensi/kolam_ngudal_tuk_putri.jpg'; // default

            if (!empty($_FILES['foto']['name'])) {
                $upload = handle_file_upload($_FILES['foto'], 'uploads', 5);
                if ($upload['status']) {
                    $fotoPath = $upload['relative_path'];
                } else {
                    set_flash('danger', $upload['error']);
                    safe_redirect("data_lokasi.php");
                }
            }

            $stmt = $pdo->prepare("INSERT INTO lokasi_potensi (nama, kategori, kategori_label, jarak, lokasi, lat, lng, foto, deskripsi, icon, color, urutan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nama, $kategori, $kategori_label, $jarak, $lokasi, $lat, $lng, $fotoPath, $deskripsi, $icon, $color, $urutan]);
            set_flash('success', 'Titik lokasi berhasil ditambahkan ke peta potensi.');
            safe_redirect("data_lokasi.php");

        } elseif ($_POST['action'] === 'edit_lokasi') {
            $id = (int)$_POST['id'];
            $nama = sanitize($_POST['nama']);
            $kategori = sanitize($_POST['kategori']);
            $kategori_label = sanitize($_POST['kategori_label'] ?? $nama);
            $jarak = sanitize($_POST['jarak'] ?? '');
            $lokasi = sanitize($_POST['lokasi'] ?? '');
            $lat = (float)$_POST['lat'];
            $lng = (float)$_POST['lng'];
            $deskripsi = sanitize($_POST['deskripsi'] ?? '');
            $icon = sanitize($_POST['icon'] ?? 'bi-geo-alt-fill');
            $color = sanitize($_POST['color'] ?? '#0288d1');
            $urutan = (int)($_POST['urutan'] ?? 0);

            if (!empty($_FILES['foto_baru']['name'])) {
                $upload = handle_file_upload($_FILES['foto_baru'], 'uploads', 5);
                if ($upload['status']) {
                    $stmt = $pdo->prepare("UPDATE lokasi_potensi SET nama = ?, kategori = ?, kategori_label = ?, jarak = ?, lokasi = ?, lat = ?, lng = ?, foto = ?, deskripsi = ?, icon = ?, color = ?, urutan = ? WHERE id = ?");
                    $stmt->execute([$nama, $kategori, $kategori_label, $jarak, $lokasi, $lat, $lng, $upload['relative_path'], $deskripsi, $icon, $color, $urutan, $id]);
                    set_flash('success', 'Data titik lokasi dan foto berhasil diperbarui.');
                } else {
                    set_flash('danger', $upload['error']);
                }
            } else {
                $stmt = $pdo->prepare("UPDATE lokasi_potensi SET nama = ?, kategori = ?, kategori_label = ?, jarak = ?, lokasi = ?, lat = ?, lng = ?, deskripsi = ?, icon = ?, color = ?, urutan = ? WHERE id = ?");
                $stmt->execute([$nama, $kategori, $kategori_label, $jarak, $lokasi, $lat, $lng, $deskripsi, $icon, $color, $urutan, $id]);
                set_flash('success', 'Data titik lokasi berhasil diperbarui.');
            }
            safe_redirect("data_lokasi.php");

        } elseif ($_POST['action'] === 'hapus_lokasi') {
            $id = (int)$_POST['id'];
            $stmt = $pdo->prepare("DELETE FROM lokasi_potensi WHERE id = ?");
            $stmt->execute([$id]);
            set_flash('success', 'Titik lokasi peta berhasil dihapus.');
            safe_redirect("data_lokasi.php");
        }
    }
}

$daftarLokasi = $pdo->query("SELECT * FROM lokasi_potensi ORDER BY urutan ASC, id ASC")->fetchAll(PDO::FETCH_ASSOC);

// Render Template Admin Header & Navigasi
require_once __DIR__ . '/header_admin.php';
?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-2">
  <div>
    <h3 class="fw-bold mb-1">Manajemen Tag &amp; Titik Lokasi Peta</h3>
    <p class="text-muted mb-0">Kelola titik koordinat, foto, nama, dan info potensi desa yang tampil di Peta Interaktif Tampirkulon.</p>
  </div>
  <button class="btn btn-danger rounded-pill px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambahLokasi">
    <i class="bi bi-plus-circle me-1"></i> Tambah Lokasi Baru
  </button>
</div>

<div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="bg-light">
        <tr>
          <th class="ps-4" style="width: 60px;">No</th>
          <th style="width: 90px;">Foto</th>
          <th>Nama &amp; Kategori</th>
          <th>Alamat / Jarak</th>
          <th>Koordinat (Lat, Lng)</th>
          <th class="text-center" style="width: 140px;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($daftarLokasi)): ?>
          <tr>
            <td colspan="6" class="text-center py-5 text-muted">
              <i class="bi bi-geo-alt fs-1 d-block mb-2 text-secondary"></i>
              Belum ada data titik lokasi peta.
            </td>
          </tr>
        <?php else: ?>
          <?php $no = 1; foreach ($daftarLokasi as $lok): ?>
          <tr>
            <td class="ps-4 fw-bold text-secondary"><?= $no++ ?></td>
            <td>
              <img src="../<?= e($lok['foto']) ?>" alt="<?= e($lok['nama']) ?>" class="rounded-3 shadow-sm" style="width: 70px; height: 50px; object-fit: cover;">
            </td>
            <td>
              <div class="fw-bold text-dark"><?= e($lok['nama']) ?></div>
              <div class="d-flex align-items-center gap-1 mt-1">
                <span class="badge" style="background-color: <?= e($lok['color']) ?>; font-size: 0.7rem;">
                  <i class="<?= e($lok['icon']) ?> me-1"></i><?= e($lok['kategori_label']) ?>
                </span>
                <span class="text-muted small" style="font-size: 0.72rem;">(<?= e($lok['kategori']) ?>)</span>
              </div>
            </td>
            <td>
              <div class="small fw-semibold text-secondary"><i class="bi bi-geo-alt text-danger me-1"></i><?= e($lok['jarak']) ?></div>
              <div class="small text-muted text-truncate" style="max-width: 200px;"><?= e($lok['lokasi']) ?></div>
            </td>
            <td>
              <span class="badge bg-light text-dark border font-monospace" style="font-size: 0.75rem;">
                <?= number_format((float)$lok['lat'], 4) ?>, <?= number_format((float)$lok['lng'], 4) ?>
              </span>
              <a href="https://www.google.com/maps/search/?api=1&query=<?= $lok['lat'] ?>,<?= $lok['lng'] ?>" target="_blank" class="d-block small text-primary text-decoration-none mt-1" style="font-size: 0.72rem;">
                <i class="bi bi-box-arrow-up-right me-1"></i>Cek Google Maps
              </a>
            </td>
            <td class="text-center">
              <div class="d-inline-flex gap-1">
                <button type="button" class="btn btn-sm btn-outline-primary rounded-3 px-2 py-1 btn-edit-lokasi"
                  data-id="<?= $lok['id'] ?>"
                  data-nama="<?= htmlspecialchars($lok['nama'], ENT_QUOTES) ?>"
                  data-kategori="<?= htmlspecialchars($lok['kategori'], ENT_QUOTES) ?>"
                  data-kategori_label="<?= htmlspecialchars($lok['kategori_label'], ENT_QUOTES) ?>"
                  data-jarak="<?= htmlspecialchars($lok['jarak'], ENT_QUOTES) ?>"
                  data-lokasi="<?= htmlspecialchars($lok['lokasi'], ENT_QUOTES) ?>"
                  data-lat="<?= $lok['lat'] ?>"
                  data-lng="<?= $lok['lng'] ?>"
                  data-deskripsi="<?= htmlspecialchars($lok['deskripsi'] ?? '', ENT_QUOTES) ?>"
                  data-icon="<?= htmlspecialchars($lok['icon'], ENT_QUOTES) ?>"
                  data-color="<?= htmlspecialchars($lok['color'], ENT_QUOTES) ?>"
                  data-urutan="<?= $lok['urutan'] ?>"
                  data-foto="../<?= e($lok['foto']) ?>">
                  <i class="bi bi-pencil-square me-1"></i>Edit
                </button>
                <form action="data_lokasi.php" method="POST" onsubmit="return confirm('Hapus titik lokasi ini dari peta?');" class="d-inline mb-0">
                  <?= csrf_field() ?>
                  <input type="hidden" name="action" value="hapus_lokasi">
                  <input type="hidden" name="id" value="<?= $lok['id'] ?>">
                  <button type="submit" class="btn btn-sm btn-outline-danger rounded-3 px-2 py-1">
                    <i class="bi bi-trash"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Modal Tambah Titik Lokasi -->
<div class="modal fade" id="modalTambahLokasi" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header bg-light">
        <h6 class="modal-title fw-bold"><i class="bi bi-plus-circle me-2 text-danger"></i>Tambah Titik Lokasi Peta</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="data_lokasi.php" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="tambah_lokasi">
        <div class="modal-body p-4">
          <div class="row g-3">
            <div class="col-md-7">
              <label class="form-label small fw-semibold">Nama Lokasi / Tag</label>
              <input type="text" class="form-control" name="nama" required placeholder="Contoh: Kolam Ngudal Tuk Putri">
            </div>
            <div class="col-md-5">
              <label class="form-label small fw-semibold">Kategori Filter</label>
              <select class="form-select" name="kategori" id="tambahKategori" required onchange="updateKategoriLabelTambah()">
                <option value="sumber-air">Sumber Mata Air (sumber-air)</option>
                <option value="wisata">Wisata Desa (wisata)</option>
                <option value="pertanian">Pertanian (pertanian)</option>
                <option value="umkm">UMKM (umkm)</option>
                <option value="kuliner">Kuliner Lokal (kuliner)</option>
                <option value="budaya">Seni &amp; Budaya (budaya)</option>
                <option value="pendidikan">Pendidikan (pendidikan)</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label small fw-semibold">Label Kategori (Tampil di Popup)</label>
              <input type="text" class="form-control" name="kategori_label" id="tambahKategoriLabel" value="Sumber Mata Air" required>
            </div>
            <div class="col-md-6">
              <label class="form-label small fw-semibold">Jarak dari Balai Desa</label>
              <input type="text" class="form-control" name="jarak" placeholder="Contoh: ± 0,34 km dari Balai Desa" required>
            </div>
            <div class="col-md-12">
              <label class="form-label small fw-semibold">Alamat / Keterangan Letak</label>
              <input type="text" class="form-control" name="lokasi" placeholder="Contoh: Tampirkulon, Candimulyo, Magelang" required>
            </div>
            <div class="col-md-6">
              <label class="form-label small fw-semibold">Latitude</label>
              <input type="number" step="any" class="form-control font-monospace" name="lat" value="-7.5020" required>
              <div class="form-text small">Contoh Magelang/Candimulyo: -7.5015</div>
            </div>
            <div class="col-md-6">
              <label class="form-label small fw-semibold">Longitude</label>
              <input type="number" step="any" class="form-control font-monospace" name="lng" value="110.2740" required>
              <div class="form-text small">Contoh Magelang/Candimulyo: 110.2735</div>
            </div>
            <div class="col-md-4">
              <label class="form-label small fw-semibold">Icon Pin (Bootstrap / Font Awesome)</label>
              <input type="text" class="form-control" name="icon" value="bi-geo-alt-fill" placeholder="bi-droplet-fill, fa-solid fa-wheat-awn">
            </div>
            <div class="col-md-4">
              <label class="form-label small fw-semibold">Warna Pin Marker</label>
              <input type="color" class="form-control form-control-color w-100" name="color" value="#0288d1">
            </div>
            <div class="col-md-4">
              <label class="form-label small fw-semibold">Urutan Tampil</label>
              <input type="number" class="form-control" name="urutan" value="1">
            </div>
            <div class="col-md-12">
              <label class="form-label small fw-semibold">Foto Lokasi</label>
              <input type="file" class="form-control" name="foto" accept="image/*">
            </div>
            <div class="col-md-12">
              <label class="form-label small fw-semibold">Deskripsi Singkat</label>
              <textarea class="form-control" name="deskripsi" rows="3" placeholder="Keterangan singkat potensi lokasi ini..."></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary btn-sm rounded-3" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger btn-sm rounded-3 fw-bold">Simpan Titik Lokasi</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edit Titik Lokasi -->
<div class="modal fade" id="modalEditLokasi" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header bg-light">
        <h6 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2 text-primary"></i>Edit Titik Lokasi Peta</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="data_lokasi.php" method="POST" enctype="multipart/form-data" id="formEditLokasi">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="edit_lokasi">
        <input type="hidden" name="id" id="editLokasiId">
        <div class="modal-body p-4">
          <div class="row g-3">
            <!-- Preview Foto -->
            <div class="col-12 text-center mb-1">
              <label class="form-label small fw-semibold d-block text-start">Foto Lokasi Saat Ini</label>
              <div class="bg-light p-2 rounded-3 border text-center">
                <img id="editLokasiFotoPreview" src="" alt="Preview Foto" class="img-fluid rounded-2 shadow-sm" style="max-height: 180px; object-fit: cover; width: 100%;">
              </div>
            </div>
            <div class="col-12">
              <label class="form-label small fw-semibold">Ganti Foto (Opsional)</label>
              <input type="file" class="form-control" id="editLokasiFotoBaru" name="foto_baru" accept="image/*">
              <div class="form-text small">Biarkan kosong jika tidak ingin mengganti file foto lokasi.</div>
            </div>
            <div class="col-md-7">
              <label class="form-label small fw-semibold">Nama Lokasi / Tag</label>
              <input type="text" class="form-control" name="nama" id="editLokasiNama" required>
            </div>
            <div class="col-md-5">
              <label class="form-label small fw-semibold">Kategori Filter</label>
              <select class="form-select" name="kategori" id="editLokasiKategori" required>
                <option value="sumber-air">Sumber Mata Air (sumber-air)</option>
                <option value="wisata">Wisata Desa (wisata)</option>
                <option value="pertanian">Pertanian (pertanian)</option>
                <option value="umkm">UMKM (umkm)</option>
                <option value="kuliner">Kuliner Lokal (kuliner)</option>
                <option value="budaya">Seni &amp; Budaya (budaya)</option>
                <option value="pendidikan">Pendidikan (pendidikan)</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label small fw-semibold">Label Kategori</label>
              <input type="text" class="form-control" name="kategori_label" id="editLokasiKategoriLabel" required>
            </div>
            <div class="col-md-6">
              <label class="form-label small fw-semibold">Jarak dari Balai Desa</label>
              <input type="text" class="form-control" name="jarak" id="editLokasiJarak" required>
            </div>
            <div class="col-md-12">
              <label class="form-label small fw-semibold">Alamat / Keterangan Letak</label>
              <input type="text" class="form-control" name="lokasi" id="editLokasiAlamat" required>
            </div>
            <div class="col-md-6">
              <label class="form-label small fw-semibold">Latitude</label>
              <input type="number" step="any" class="form-control font-monospace" name="lat" id="editLokasiLat" required>
            </div>
            <div class="col-md-6">
              <label class="form-label small fw-semibold">Longitude</label>
              <input type="number" step="any" class="form-control font-monospace" name="lng" id="editLokasiLng" required>
            </div>
            <div class="col-md-4">
              <label class="form-label small fw-semibold">Icon Pin</label>
              <input type="text" class="form-control" name="icon" id="editLokasiIcon">
            </div>
            <div class="col-md-4">
              <label class="form-label small fw-semibold">Warna Pin Marker</label>
              <input type="color" class="form-control form-control-color w-100" name="color" id="editLokasiColor">
            </div>
            <div class="col-md-4">
              <label class="form-label small fw-semibold">Urutan Tampil</label>
              <input type="number" class="form-control" name="urutan" id="editLokasiUrutan">
            </div>
            <div class="col-md-12">
              <label class="form-label small fw-semibold">Deskripsi Singkat</label>
              <textarea class="form-control" name="deskripsi" id="editLokasiDeskripsi" rows="3"></textarea>
            </div>
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
function updateKategoriLabelTambah() {
  const sel = document.getElementById('tambahKategori');
  const labelInput = document.getElementById('tambahKategoriLabel');
  const mapLabel = {
    'sumber-air': 'Sumber Mata Air',
    'wisata': 'Wisata Desa',
    'pertanian': 'Pertanian',
    'umkm': 'UMKM',
    'kuliner': 'Kuliner Lokal',
    'budaya': 'Seni & Budaya',
    'pendidikan': 'Pendidikan'
  };
  if (mapLabel[sel.value]) {
    labelInput.value = mapLabel[sel.value];
  }
}

document.addEventListener('DOMContentLoaded', function() {
  const modalEditEl = document.getElementById('modalEditLokasi');
  if (!modalEditEl) return;
  const modalEdit = new bootstrap.Modal(modalEditEl);

  const idInput = document.getElementById('editLokasiId');
  const namaInput = document.getElementById('editLokasiNama');
  const kategoriInput = document.getElementById('editLokasiKategori');
  const kategoriLabelInput = document.getElementById('editLokasiKategoriLabel');
  const jarakInput = document.getElementById('editLokasiJarak');
  const alamatInput = document.getElementById('editLokasiAlamat');
  const latInput = document.getElementById('editLokasiLat');
  const lngInput = document.getElementById('editLokasiLng');
  const iconInput = document.getElementById('editLokasiIcon');
  const colorInput = document.getElementById('editLokasiColor');
  const urutanInput = document.getElementById('editLokasiUrutan');
  const deskripsiInput = document.getElementById('editLokasiDeskripsi');
  const previewImg = document.getElementById('editLokasiFotoPreview');
  const fileInput = document.getElementById('editLokasiFotoBaru');
  let originalFotoSrc = '';

  document.querySelectorAll('.btn-edit-lokasi').forEach(btn => {
    btn.addEventListener('click', function() {
      idInput.value = this.dataset.id || '';
      namaInput.value = this.dataset.nama || '';
      kategoriInput.value = this.dataset.kategori || '';
      kategoriLabelInput.value = this.dataset.kategori_label || '';
      jarakInput.value = this.dataset.jarak || '';
      alamatInput.value = this.dataset.lokasi || '';
      latInput.value = this.dataset.lat || '';
      lngInput.value = this.dataset.lng || '';
      iconInput.value = this.dataset.icon || '';
      colorInput.value = this.dataset.color || '#0288d1';
      urutanInput.value = this.dataset.urutan || '0';
      deskripsiInput.value = this.dataset.deskripsi || '';
      originalFotoSrc = this.dataset.foto || '';
      previewImg.src = originalFotoSrc;
      fileInput.value = '';
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
