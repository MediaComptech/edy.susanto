<?php
require_once __DIR__ . '/header_admin.php';

// Handle POST updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if (verify_csrf()) {
        if ($_POST['action'] === 'ganti_foto_hero') {
            if (!empty($_FILES['foto_hero_baru']['name'])) {
                $upload = handle_file_upload($_FILES['foto_hero_baru'], 'uploads', 5);
                if ($upload['status']) {
                    set_pengaturan($pdo, 'foto_hero', $upload['relative_path'], 'Foto utama kandidat di Hero Section Beranda');
                    set_flash('success', 'Foto Hero Beranda berhasil diperbarui dan diterapkan ke website utama!');
                } else {
                    set_flash('danger', $upload['error']);
                }
            } else {
                set_flash('warning', 'Pilih berkas foto terlebih dahulu.');
            }
            header("Location: pengaturan.php");
            exit;
        } elseif ($_POST['action'] === 'reset_foto_hero') {
            set_pengaturan($pdo, 'foto_hero', 'assets/images/banner/edy_susanto_hero_clean.jpg', 'Foto bawaan kandidat');
            set_flash('success', 'Foto Hero berhasil dikembalikan ke foto bawaan (default).');
            header("Location: pengaturan.php");
            exit;
        } elseif ($_POST['action'] === 'simpan_teks_kampanye') {
            $nama = sanitize($_POST['nama_calon'] ?? 'EDY SUSANTO');
            $noUrut = sanitize($_POST['no_urut'] ?? '2');
            $tagline = sanitize($_POST['tagline'] ?? '');
            $quote = sanitize($_POST['slogan_quote'] ?? '');

            set_pengaturan($pdo, 'nama_calon', $nama);
            set_pengaturan($pdo, 'no_urut', $noUrut);
            set_pengaturan($pdo, 'tagline', $tagline);
            set_pengaturan($pdo, 'slogan_quote', $quote);

            set_flash('success', 'Teks dan informasi kampanye berhasil disimpan.');
            header("Location: pengaturan.php");
            exit;
        } elseif ($_POST['action'] === 'simpan_dusun') {
            // Proses daftar dusun yang dikirim
            $dusunRaw = $_POST['dusun'] ?? [];
            $dusunBersih = [];
            foreach ($dusunRaw as $d) {
                $d = trim(sanitize($d));
                if ($d !== '') {
                    $dusunBersih[] = $d;
                }
            }
            if (count($dusunBersih) < 1) {
                set_flash('warning', 'Minimal harus ada 1 nama dusun.');
            } else {
                set_pengaturan($pdo, 'dusun_list', json_encode($dusunBersih, JSON_UNESCAPED_UNICODE), 'Daftar nama dusun resmi Tampirkulon');
                set_flash('success', 'Daftar nama dusun berhasil diperbarui (' . count($dusunBersih) . ' dusun).');
            }
            header("Location: pengaturan.php");
            exit;
        }
    } else {
        set_flash('danger', 'Validasi sesi CSRF gagal.');
    }
}

// Ambil data pengaturan saat ini
$fotoHero = get_pengaturan($pdo, 'foto_hero', 'assets/images/banner/edy_susanto_hero_clean.jpg');
$namaCalon = get_pengaturan($pdo, 'nama_calon', APP_NAME);
$noUrut = get_pengaturan($pdo, 'no_urut', NO_URUT);
$tagline = get_pengaturan($pdo, 'tagline', TAGLINE);
$sloganQuote = get_pengaturan($pdo, 'slogan_quote', SLOGAN_QUOTE);

// Ambil daftar dusun dari database, fallback ke config.php
$dusunJson = get_pengaturan($pdo, 'dusun_list', '');
$dusunList = [];
if (!empty($dusunJson)) {
    $dusunList = json_decode($dusunJson, true) ?: $DUSUN_LIST;
} else {
    $dusunList = $DUSUN_LIST;
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h3 class="fw-bold mb-1">Pengaturan &amp; Foto Hero</h3>
    <p class="text-muted mb-0">Kelola foto utama bagian Hero dan teks identitas kampanye secara dinamis.</p>
  </div>
  <a href="../index.php?page=beranda" target="_blank" class="btn btn-outline-danger btn-sm rounded-pill px-3">
    <i class="bi bi-box-arrow-up-right me-1"></i> Pratinjau di Beranda
  </a>
</div>

<div class="row g-4">
  <!-- 1. KARTU UTAMA: GANTI FOTO HERO BERANDA -->
  <div class="col-lg-7">
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
      <div class="d-flex align-items-center gap-2 mb-3">
        <div class="rounded-circle bg-danger-subtle text-danger d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
          <i class="bi bi-image fs-5"></i>
        </div>
        <div>
          <h5 class="fw-bold mb-0">Ganti Foto Hero Beranda</h5>
          <small class="text-muted">Foto ini ditampilkan di sisi kanan Hero Section Beranda publik</small>
        </div>
      </div>

      <!-- Pratinjau Foto Saat Ini -->
      <div class="mb-4 text-center p-3 bg-light rounded-4 border">
        <div class="small fw-semibold text-muted mb-2">Foto Hero Aktif Saat Ini:</div>
        <img src="../<?= e($fotoHero) ?>" alt="Foto Hero Aktif" id="currentHeroPreview" class="img-fluid rounded-4 shadow-sm border" style="max-height: 260px; object-fit: cover;">
        <div class="text-muted small mt-2">
          File path: <code><?= e($fotoHero) ?></code>
        </div>
      </div>

      <!-- Form Unggah Foto Baru -->
      <form action="pengaturan.php" method="POST" enctype="multipart/form-data" class="mb-3">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="ganti_foto_hero">

        <div class="mb-3">
          <label for="inputFotoHero" class="form-label small fw-semibold">Pilih Berkas Foto Baru</label>
          <input type="file" class="form-control rounded-3" id="inputFotoHero" name="foto_hero_baru" accept="image/jpeg,image/png,image/webp" required>
          <div class="form-text small text-muted">Format yang didukung: JPG, PNG, WEBP (Maksimal 5 MB). Disarankan rasio proporsional.</div>
        </div>

        <!-- Pratinjau Live Sebelum Simpan -->
        <div id="livePreviewContainer" class="mb-3 text-center p-3 border border-dashed rounded-4 bg-white" style="display: none;">
          <div class="small fw-bold text-success mb-2"><i class="bi bi-eye-fill me-1"></i> Pratinjau Foto Baru yang Dipilih:</div>
          <img id="imgLivePreview" src="" alt="Live Preview" class="img-fluid rounded-4 shadow-sm" style="max-height: 220px; object-fit: cover;">
        </div>

        <button type="submit" class="btn btn-danger w-100 rounded-3 fw-bold py-2 shadow-sm">
          <i class="bi bi-cloud-arrow-up-fill me-1"></i> Simpan &amp; Terapkan Foto Hero Baru
        </button>
      </form>

      <!-- Tombol Reset ke Default -->
      <form action="pengaturan.php" method="POST" onsubmit="return confirm('Kembalikan foto hero ke foto bawaan (clean default)?');">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="reset_foto_hero">
        <button type="submit" class="btn btn-outline-secondary btn-sm w-100 rounded-3">
          <i class="bi bi-arrow-counterclockwise me-1"></i> Kembalikan ke Foto Hero Bawaan
        </button>
      </form>
    </div>
  </div>

  <!-- 2. KARTU INFORMASI TEKS KAMPANYE -->
  <div class="col-lg-5">
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
      <div class="d-flex align-items-center gap-2 mb-3">
        <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
          <i class="bi bi-pencil-square fs-5"></i>
        </div>
        <div>
          <h5 class="fw-bold mb-0">Teks Identitas Hero</h5>
          <small class="text-muted">Ubah nama, nomor urut, dan slogan</small>
        </div>
      </div>

      <form action="pengaturan.php" method="POST">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="simpan_teks_kampanye">

        <div class="mb-3">
          <label class="form-label small fw-semibold">Nama Calon</label>
          <input type="text" class="form-control rounded-3" name="nama_calon" value="<?= e($namaCalon) ?>" required>
        </div>

        <div class="mb-3">
          <label class="form-label small fw-semibold">Nomor Urut</label>
          <input type="text" class="form-control rounded-3" name="no_urut" value="<?= e($noUrut) ?>" required>
        </div>

        <div class="mb-3">
          <label class="form-label small fw-semibold">Slogan / Tagline Hero</label>
          <textarea class="form-control rounded-3" name="tagline" rows="2" required><?= e($tagline) ?></textarea>
        </div>

        <div class="mb-4">
          <label class="form-label small fw-semibold">Kutipan Calon</label>
          <input type="text" class="form-control rounded-3" name="slogan_quote" value="<?= e($sloganQuote) ?>" required>
        </div>

        <button type="submit" class="btn btn-primary w-100 rounded-3 fw-bold py-2 shadow-sm">
          <i class="bi bi-save-fill me-1"></i> Simpan Teks Kampanye
        </button>
      </form>
    </div>
  </div>
</div>


<!-- 3. KARTU EDIT DAFTAR DUSUN -->
<div class="row g-4 mt-1">
  <div class="col-12">
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
      <div class="d-flex align-items-center gap-2 mb-3">
        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #e8f5e9;">
          <i class="bi bi-house-fill" style="color: #2e7d32; font-size: 1.1rem;"></i>
        </div>
        <div>
          <h5 class="fw-bold mb-0">Daftar Dusun Tampirkulon</h5>
          <small class="text-muted">Kelola nama-nama dusun resmi yang tampil di formulir Sapa Warga dan halaman lainnya</small>
        </div>
      </div>

      <form action="pengaturan.php" method="POST" id="formEditDusun">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="simpan_dusun">

        <div id="dusunContainer" class="mb-3">
          <?php foreach ($dusunList as $idx => $dusunNama): ?>
          <div class="dusun-item d-flex align-items-center gap-2 mb-2" id="dusunItem<?= $idx ?>">
            <span class="text-muted small fw-semibold" style="width:28px; text-align:right;"><?= $idx + 1 ?>.</span>
            <input
              type="text"
              class="form-control form-control-sm rounded-3"
              name="dusun[]"
              value="<?= e($dusunNama) ?>"
              placeholder="Nama dusun..."
              required
              style="max-width: 360px;"
            >
            <button type="button" class="btn btn-sm btn-outline-danger rounded-3 btn-hapus-dusun" title="Hapus dusun ini">
              <i class="bi bi-trash3"></i>
            </button>
          </div>
          <?php endforeach; ?>
        </div>

        <div class="d-flex gap-2 mb-4 flex-wrap">
          <button type="button" id="btnTambahDusun" class="btn btn-sm btn-outline-success rounded-3">
            <i class="bi bi-plus-circle me-1"></i> Tambah Dusun
          </button>
          <span class="text-muted small d-flex align-items-center">
            <i class="bi bi-info-circle me-1"></i>
            Total: <strong id="totalDusun" class="ms-1"><?= count($dusunList) ?></strong> dusun
          </span>
        </div>

        <div class="alert alert-info alert-sm small rounded-3 py-2 mb-3" role="alert">
          <i class="bi bi-lightbulb me-1"></i>
          <strong>Tips:</strong> Nama dusun ini akan muncul di dropdown pilihan lokasi pada formulir <strong>Sapa Warga</strong>.
          Pastikan penulisan nama sesuai nama resmi dusun.
        </div>

        <button type="submit" class="btn btn-success rounded-3 fw-bold px-4 py-2 shadow-sm">
          <i class="bi bi-save-fill me-1"></i> Simpan Daftar Dusun
        </button>
      </form>
    </div>
  </div>
</div>

<script>
// Script Live Preview Foto Baru
document.addEventListener('DOMContentLoaded', function() {
  const input = document.getElementById('inputFotoHero');
  const container = document.getElementById('livePreviewContainer');
  const img = document.getElementById('imgLivePreview');

  if (input && container && img) {
    input.addEventListener('change', function() {
      const file = this.files[0];
      if (file) {
        if (file.size > 5 * 1024 * 1024) {
          alert('Ukuran file maksimal 5 MB!');
          this.value = '';
          container.style.display = 'none';
          return;
        }
        const reader = new FileReader();
        reader.onload = function(e) {
          img.src = e.target.result;
          container.style.display = 'block';
        };
        reader.readAsDataURL(file);
      } else {
        container.style.display = 'none';
      }
    });
  }

  // ===== Manajemen Dusun =====
  const dusunContainer = document.getElementById('dusunContainer');
  const btnTambah = document.getElementById('btnTambahDusun');
  const totalDusun = document.getElementById('totalDusun');

  function updateNomor() {
    const items = dusunContainer.querySelectorAll('.dusun-item');
    items.forEach((item, idx) => {
      const nomor = item.querySelector('span');
      if (nomor) nomor.textContent = (idx + 1) + '.';
    });
    if (totalDusun) totalDusun.textContent = items.length;
  }

  function buatItemDusun(nama = '') {
    const div = document.createElement('div');
    div.className = 'dusun-item d-flex align-items-center gap-2 mb-2';
    div.innerHTML = `
      <span class="text-muted small fw-semibold" style="width:28px; text-align:right;">0.</span>
      <input type="text" class="form-control form-control-sm rounded-3"
        name="dusun[]" value="${nama}" placeholder="Nama dusun..."
        required style="max-width: 360px;">
      <button type="button" class="btn btn-sm btn-outline-danger rounded-3 btn-hapus-dusun" title="Hapus">
        <i class="bi bi-trash3"></i>
      </button>
    `;
    return div;
  }

  if (btnTambah) {
    btnTambah.addEventListener('click', function() {
      const item = buatItemDusun('');
      dusunContainer.appendChild(item);
      updateNomor();
      item.querySelector('input').focus();
    });
  }

  if (dusunContainer) {
    dusunContainer.addEventListener('click', function(e) {
      const btn = e.target.closest('.btn-hapus-dusun');
      if (btn) {
        const items = dusunContainer.querySelectorAll('.dusun-item');
        if (items.length <= 1) {
          alert('Minimal harus ada 1 dusun.');
          return;
        }
        btn.closest('.dusun-item').remove();
        updateNomor();
      }
    });
  }
});
</script>

<?php require_once __DIR__ . '/footer_admin.php'; ?>
