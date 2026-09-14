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
        } elseif ($_POST['action'] === 'ganti_bg_hero') {
            if (!empty($_FILES['bg_hero_baru']['name'])) {
                $upload = handle_file_upload($_FILES['bg_hero_baru'], 'uploads', 10);
                if ($upload['status']) {
                    set_pengaturan($pdo, 'bg_hero', $upload['relative_path'], 'Background landscape Hero Section Beranda');
                    set_flash('success', 'Background Hero berhasil diperbarui!');
                } else {
                    set_flash('danger', $upload['error']);
                }
            } else {
                set_flash('warning', 'Pilih berkas gambar background terlebih dahulu.');
            }
            header("Location: pengaturan.php");
            exit;
        } elseif ($_POST['action'] === 'reset_bg_hero') {
            set_pengaturan($pdo, 'bg_hero', 'assets/images/banner/hero_bg_pure_landscape.jpg', 'Background landscape bawaan');
            set_flash('success', 'Background Hero dikembalikan ke landscape bawaan.');
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
        } elseif ($_POST['action'] === 'ganti_foto_profil') {
            if (!empty($_FILES['foto_profil_baru']['name'])) {
                $upload = handle_file_upload($_FILES['foto_profil_baru'], 'uploads', 5);
                if ($upload['status']) {
                    set_pengaturan($pdo, 'foto_profil', $upload['relative_path'], 'Foto profil calon di Halaman Profil');
                    set_flash('success', 'Foto profil calon berhasil diperbarui!');
                } else {
                    set_flash('danger', $upload['error']);
                }
            } else {
                set_flash('warning', 'Pilih berkas foto profil terlebih dahulu.');
            }
            header("Location: pengaturan.php");
            exit;
        } elseif ($_POST['action'] === 'reset_foto_profil') {
            set_pengaturan($pdo, 'foto_profil', 'assets/images/banner/edy_susanto_hero.jpg', 'Foto profil bawaan');
            set_flash('success', 'Foto profil dikembalikan ke foto bawaan.');
            header("Location: pengaturan.php");
            exit;
        } elseif ($_POST['action'] === 'simpan_konten_profil') {
            $asal     = sanitize($_POST['profil_asal'] ?? 'Asli Warga Desa Tampirkulon');
            $judul    = sanitize($_POST['profil_judul_dedikasi'] ?? 'Dedikasi Nyata untuk Kemajuan Desa Tampirkulon');
            $bio1     = sanitize($_POST['profil_biodata_1'] ?? '');
            $bio2     = sanitize($_POST['profil_biodata_2'] ?? '');
            $nilai    = sanitize($_POST['profil_nilai_kepemimpinan'] ?? '');
            $komitmen = sanitize($_POST['profil_komitmen_pengabdian'] ?? '');

            set_pengaturan($pdo, 'profil_asal', $asal);
            set_pengaturan($pdo, 'profil_judul_dedikasi', $judul);
            set_pengaturan($pdo, 'profil_biodata_1', $bio1);
            set_pengaturan($pdo, 'profil_biodata_2', $bio2);
            set_pengaturan($pdo, 'profil_nilai_kepemimpinan', $nilai);
            set_pengaturan($pdo, 'profil_komitmen_pengabdian', $komitmen);

            set_flash('success', 'Konten data diri & biodata Halaman Profil berhasil disimpan!');
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
$fotoHero   = get_pengaturan($pdo, 'foto_hero', 'assets/images/banner/edy_susanto_hero_clean.jpg');
$bgHero     = get_pengaturan($pdo, 'bg_hero', 'assets/images/banner/hero_bg_pure_landscape.jpg');
$namaCalon  = get_pengaturan($pdo, 'nama_calon', APP_NAME);
$noUrut     = get_pengaturan($pdo, 'no_urut', NO_URUT);
$tagline    = get_pengaturan($pdo, 'tagline', TAGLINE);
$sloganQuote = get_pengaturan($pdo, 'slogan_quote', SLOGAN_QUOTE);

// Ambil data halaman profil calon
$fotoProfil         = get_pengaturan($pdo, 'foto_profil', 'assets/images/banner/edy_susanto_hero.jpg');
$profilAsal         = get_pengaturan($pdo, 'profil_asal', 'Asli Warga Desa Tampirkulon');
$judulDedikasi      = get_pengaturan($pdo, 'profil_judul_dedikasi', 'Dedikasi Nyata untuk Kemajuan Desa Tampirkulon');
$biodata1           = get_pengaturan($pdo, 'profil_biodata_1', 'Lahir dan tumbuh bersama masyarakat Desa Tampirkulon, ' . $namaCalon . ' memahami secara mendalam detak kehidupan warga, potensi agraris yang melimpah, serta harapan besar pemuda dan keluarga di setiap dusun.');
$biodata2           = get_pengaturan($pdo, 'profil_biodata_2', 'Dengan bekal pengalaman kepemimpinan sosial, dedikasi kemasyarakatan yang kuat, serta jejaring kolaborasi yang luas, beliau hadir membawa tekad mengabdi secara tulus tanpa sekat demi terciptanya pemerintahan desa yang bersih, transparan, dan melayani.');
$nilaiKepemimpinan  = get_pengaturan($pdo, 'profil_nilai_kepemimpinan', 'Amanah, mendengarkan rakyat, transparan dalam pengelolaan dana desa, dan responsif terhadap keluhan warga.');
$komitmenPengabdian = get_pengaturan($pdo, 'profil_komitmen_pengabdian', 'Hadir di tengah warga, membuka pintu komunikasi 24/7 melalui inovasi Sapa Warga dan rembug dusun rutin.');

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
  <!-- 0. KARTU: GANTI BACKGROUND LANDSCAPE HERO -->
  <div class="col-12">
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
      <div class="d-flex align-items-center gap-2 mb-3">
        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: #e8f5e9;">
          <i class="bi bi-image-fill" style="color: #2e7d32; font-size: 1.1rem;"></i>
        </div>
        <div>
          <h5 class="fw-bold mb-0">Background Landscape Hero</h5>
          <small class="text-muted">Gambar pemandangan/landscape yang menjadi latar belakang Hero Section Beranda</small>
        </div>
      </div>

      <div class="row g-4 align-items-start">
        <!-- Preview Background Aktif -->
        <div class="col-md-5">
          <div class="p-2 bg-light rounded-4 border text-center">
            <div class="small fw-semibold text-muted mb-2">Background Aktif:</div>
            <img src="../<?= e($bgHero) ?>" alt="Background Hero" id="currentBgPreview"
              class="img-fluid rounded-3 shadow-sm border w-100"
              style="max-height: 160px; object-fit: cover;">
            <div class="text-muted small mt-1">
              <code><?= e(basename($bgHero)) ?></code>
            </div>
          </div>
        </div>

        <!-- Form Upload & Reset -->
        <div class="col-md-7">
          <form action="pengaturan.php" method="POST" enctype="multipart/form-data" class="mb-2">
            <?= csrf_field() ?>
            <input type="hidden" name="action" value="ganti_bg_hero">
            <div class="mb-3">
              <label for="inputBgHero" class="form-label small fw-semibold">Upload Gambar Background Baru</label>
              <input type="file" class="form-control rounded-3" id="inputBgHero" name="bg_hero_baru"
                accept="image/jpeg,image/png,image/webp" required>
              <div class="form-text small text-muted">Format: JPG, PNG, WEBP. Maks 10 MB. Disarankan landscape 16:9 minimal 1400px lebar.</div>
            </div>
            <!-- Live Preview -->
            <div id="bgLivePreviewContainer" class="mb-3 text-center p-2 border rounded-3 bg-white" style="display:none;">
              <div class="small fw-bold text-success mb-1"><i class="bi bi-eye-fill me-1"></i>Preview:</div>
              <img id="imgBgLivePreview" src="" alt="Preview" class="img-fluid rounded-3" style="max-height: 120px; object-fit: cover; width: 100%;">
            </div>
            <button type="submit" class="btn w-100 fw-bold rounded-3 py-2" style="background:#2e7d32; color:#fff;">
              <i class="bi bi-cloud-arrow-up-fill me-1"></i> Simpan Background Baru
            </button>
          </form>
          <form action="pengaturan.php" method="POST" onsubmit="return confirm('Kembalikan background ke landscape bawaan?');">
            <?= csrf_field() ?>
            <input type="hidden" name="action" value="reset_bg_hero">
            <button type="submit" class="btn btn-outline-secondary btn-sm w-100 rounded-3">
              <i class="bi bi-arrow-counterclockwise me-1"></i> Reset ke Background Bawaan (Kota Hijau)
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>

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
          <label class="form-label small fw-semibold">Kutipan / Quote Hero (Tampil di atas foto hero — Kotak Ungu)</label>
          <input type="text" class="form-control rounded-3" name="slogan_quote" value="<?= e($sloganQuote) ?>" required>
          <div class="form-text small text-muted">Tulisan di sudut kanan atas foto hero (kotak ungu pada beranda). Contoh: <code>Desa kuat karena warganya.</code></div>
        </div>

        <button type="submit" class="btn btn-primary w-100 rounded-3 fw-bold py-2 shadow-sm">
          <i class="bi bi-save-fill me-1"></i> Simpan Teks Kampanye
        </button>
      </form>
    </div>
  </div>
</div>


<!-- 2.5 KARTU KELOLA HALAMAN PROFIL (FOTO PROFIL & KONTEN DATA DIRI) -->
<div class="row g-4 mt-1">
  <div class="col-12">
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center gap-2">
          <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #fce4ec;">
            <i class="bi bi-person-lines-fill" style="color: #c2185b; font-size: 1.1rem;"></i>
          </div>
          <div>
            <h5 class="fw-bold mb-0">Pengaturan Halaman Profil Calon</h5>
            <small class="text-muted">Kelola foto profil dan isi biodata/narasi dedikasi pada menu Profil</small>
          </div>
        </div>
        <a href="../index.php?page=profil" target="_blank" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
          <i class="bi bi-box-arrow-up-right me-1"></i> Buka Halaman Profil
        </a>
      </div>

      <div class="row g-4">
        <!-- Kolom Kiri: Foto Profil Calon -->
        <div class="col-lg-4 border-end-lg">
          <h6 class="fw-bold text-dark mb-3"><i class="bi bi-camera-fill me-1 text-danger"></i> Foto Profil Calon</h6>
          
          <div class="p-3 bg-light rounded-4 border text-center mb-3">
            <div class="small fw-semibold text-muted mb-2">Foto Profil Aktif:</div>
            <img src="../<?= e($fotoProfil) ?>" alt="Foto Profil Calon" id="currentProfilPreview"
              class="img-fluid rounded-3 shadow-sm border" style="max-height: 240px; object-fit: cover;">
            <div class="text-muted small mt-2">
              <code><?= e(basename($fotoProfil)) ?></code>
            </div>
          </div>

          <form action="pengaturan.php" method="POST" enctype="multipart/form-data" class="mb-2">
            <?= csrf_field() ?>
            <input type="hidden" name="action" value="ganti_foto_profil">
            
            <div class="mb-3">
              <label for="inputFotoProfil" class="form-label small fw-semibold">Upload Foto Profil Baru</label>
              <input type="file" class="form-control rounded-3" id="inputFotoProfil" name="foto_profil_baru"
                accept="image/jpeg,image/png,image/webp" required>
              <div class="form-text small text-muted">Format: JPG, PNG, WEBP. Maksimal 5 MB.</div>
            </div>

            <!-- Live Preview -->
            <div id="profilLivePreviewContainer" class="mb-3 text-center p-2 border rounded-3 bg-white" style="display:none;">
              <div class="small fw-bold text-danger mb-1"><i class="bi bi-eye-fill me-1"></i>Preview Foto:</div>
              <img id="imgProfilLivePreview" src="" alt="Preview Profil" class="img-fluid rounded-3" style="max-height: 180px; object-fit: cover;">
            </div>

            <button type="submit" class="btn btn-danger w-100 fw-bold rounded-3 py-2 shadow-sm">
              <i class="bi bi-cloud-arrow-up-fill me-1"></i> Simpan Foto Profil
            </button>
          </form>

          <form action="pengaturan.php" method="POST" onsubmit="return confirm('Kembalikan foto profil ke foto bawaan?');">
            <?= csrf_field() ?>
            <input type="hidden" name="action" value="reset_foto_profil">
            <button type="submit" class="btn btn-outline-secondary btn-sm w-100 rounded-3">
              <i class="bi bi-arrow-counterclockwise me-1"></i> Reset ke Foto Bawaan
            </button>
          </form>
        </div>

        <!-- Kolom Kanan: Isi Konten Data Diri & Narasi -->
        <div class="col-lg-8">
          <h6 class="fw-bold text-dark mb-3"><i class="bi bi-file-earmark-person-fill me-1 text-primary"></i> Konten Data Diri &amp; Narasi Dedikasi</h6>
          
          <form action="pengaturan.php" method="POST">
            <?= csrf_field() ?>
            <input type="hidden" name="action" value="simpan_konten_profil">

            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <label class="form-label small fw-semibold">Keterangan Asal / Sub-Identitas</label>
                <input type="text" class="form-control rounded-3" name="profil_asal" value="<?= e($profilAsal) ?>" required placeholder="Contoh: Asli Warga Desa Tampirkulon">
                <div class="form-text small text-muted">Tampil di bawah nama pada kartu foto profil.</div>
              </div>
              <div class="col-md-6">
                <label class="form-label small fw-semibold">Judul Narasi Dedikasi</label>
                <input type="text" class="form-control rounded-3" name="profil_judul_dedikasi" value="<?= e($judulDedikasi) ?>" required placeholder="Judul besar di samping foto profil">
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label small fw-semibold">Paragraf Biodata 1 (Latar Belakang &amp; Kedekatan Warga)</label>
              <textarea class="form-control rounded-3" name="profil_biodata_1" rows="3" required><?= e($biodata1) ?></textarea>
            </div>

            <div class="mb-3">
              <label class="form-label small fw-semibold">Paragraf Biodata 2 (Pengalaman &amp; Tekad Pengabdian)</label>
              <textarea class="form-control rounded-3" name="profil_biodata_2" rows="3" required><?= e($biodata2) ?></textarea>
            </div>

            <div class="row g-3 mb-4">
              <div class="col-md-6">
                <label class="form-label small fw-semibold"><i class="bi bi-award-fill text-danger me-1"></i> Nilai Kepemimpinan</label>
                <textarea class="form-control rounded-3" name="profil_nilai_kepemimpinan" rows="3" required><?= e($nilaiKepemimpinan) ?></textarea>
              </div>
              <div class="col-md-6">
                <label class="form-label small fw-semibold"><i class="bi bi-heart-fill text-danger me-1"></i> Komitmen Pengabdian</label>
                <textarea class="form-control rounded-3" name="profil_komitmen_pengabdian" rows="3" required><?= e($komitmenPengabdian) ?></textarea>
              </div>
            </div>

            <button type="submit" class="btn btn-primary rounded-3 fw-bold px-4 py-2 shadow-sm">
              <i class="bi bi-save-fill me-1"></i> Simpan Konten Data Diri Profil
            </button>
          </form>
        </div>
      </div>
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

  // ===== Live Preview Background Hero =====
  const bgInput = document.getElementById('inputBgHero');
  const bgContainer = document.getElementById('bgLivePreviewContainer');
  const bgImg = document.getElementById('imgBgLivePreview');
  const bgCurrentPreview = document.getElementById('currentBgPreview');

  if (bgInput && bgContainer && bgImg) {
    bgInput.addEventListener('change', function() {
      const file = this.files[0];
      if (file) {
        if (file.size > 10 * 1024 * 1024) {
          alert('Ukuran file background maksimal 10 MB!');
          this.value = '';
          bgContainer.style.display = 'none';
          return;
        }
        const reader = new FileReader();
        reader.onload = function(e) {
          bgImg.src = e.target.result;
          bgContainer.style.display = 'block';
          // Update preview aktif juga
          if (bgCurrentPreview) bgCurrentPreview.src = e.target.result;
        };
        reader.readAsDataURL(file);
      } else {
        bgContainer.style.display = 'none';
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

  // ===== Live Preview Foto Profil =====
  const profilInput = document.getElementById('inputFotoProfil');
  const profilContainer = document.getElementById('profilLivePreviewContainer');
  const profilImg = document.getElementById('imgProfilLivePreview');
  const profilCurrentPreview = document.getElementById('currentProfilPreview');

  if (profilInput && profilContainer && profilImg) {
    profilInput.addEventListener('change', function() {
      const file = this.files[0];
      if (file) {
        if (file.size > 5 * 1024 * 1024) {
          alert('Ukuran foto profil maksimal 5 MB!');
          this.value = '';
          profilContainer.style.display = 'none';
          return;
        }
        const reader = new FileReader();
        reader.onload = function(e) {
          profilImg.src = e.target.result;
          profilContainer.style.display = 'block';
          if (profilCurrentPreview) profilCurrentPreview.src = e.target.result;
        };
        reader.readAsDataURL(file);
      } else {
        profilContainer.style.display = 'none';
      }
    });
  }
});
</script>

<?php require_once __DIR__ . '/footer_admin.php'; ?>
