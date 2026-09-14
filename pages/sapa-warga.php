<?php
/**
 * Halaman Sapa Warga (Kanal Aspirasi & Dialog Publik)
 * Sesuai Desain Mockup UI/1.png & UI/struktur.png
 */
if (!defined('APP_NAME')) {
    require_once __DIR__ . '/../includes/config.php';
}

// Baca daftar dusun dari database (dinamis), fallback ke config.php
$_dusunJson = get_pengaturan($pdo, 'dusun_list', '');
if (!empty($_dusunJson)) {
    $decoded = json_decode($_dusunJson, true);
    if (is_array($decoded) && count($decoded) > 0) {
        $DUSUN_LIST = $decoded;
    }
}
unset($_dusunJson, $decoded);

// Handle Form Submission POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'kirim_aspirasi') {
    if (!verify_csrf()) {
        set_flash('danger', 'Validasi sesi keamanan (CSRF) gagal. Silakan coba kirim kembali formulir.');
        header("Location: index.php?page=sapa-warga#formAspirasi");
        exit;
    }

    $nama = sanitize($_POST['nama_lengkap'] ?? '');
    $dusun = sanitize($_POST['dusun'] ?? '');
    $kategori = sanitize($_POST['kategori_aspirasi'] ?? '');
    $isi = sanitize($_POST['isi_aspirasi'] ?? '');
    $isAnonim = isset($_POST['is_anonim']) ? 1 : 0;
    $fotoPath = null;

    // Validasi
    $errors = [];
    if (empty($nama)) $errors[] = 'Nama lengkap wajib diisi.';
    if (empty($dusun)) $errors[] = 'Pilihan dusun wajib dipilih.';
    if (empty($kategori)) $errors[] = 'Kategori aspirasi wajib dipilih.';
    if (empty($isi) || strlen($isi) < 10) $errors[] = 'Isi aspirasi minimal 10 karakter.';

    // Upload Foto jika ada
    if (!empty($_FILES['foto_aspirasi']['name'])) {
        $uploadResult = handle_file_upload($_FILES['foto_aspirasi'], 'uploads', 5);
        if ($uploadResult['status']) {
            $fotoPath = $uploadResult['relative_path'];
        } else {
            $errors[] = $uploadResult['error'];
        }
    }

    if (empty($errors)) {
        // Buat kode tiket unik: ASP-YYYYMMDD-XXXX
        $kodeTiket = 'ASP-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(2)));
        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';

        try {
            $stmt = $pdo->prepare("INSERT INTO aspirasi 
                (kode_tiket, nama_warga, dusun, kategori, isi_aspirasi, foto, is_anonim, status, ip_address) 
                VALUES (?, ?, ?, ?, ?, ?, ?, 'Dalam Proses', ?)");
            $stmt->execute([$kodeTiket, $nama, $dusun, $kategori, $isi, $fotoPath, $isAnonim, $ip]);

            // Trigger notifikasi broadcast PWA
            create_pwa_notification(
                $pdo,
                "Aspirasi Baru dari $dusun ($kategori)",
                "Aspirasi warga telah diterima dengan tiket $kodeTiket dan sedang ditindaklanjuti.",
                "index.php?page=sapa-warga"
            );

            set_flash('success', "<strong>Terima kasih!</strong> Aspirasi Anda berhasil dikirim dengan Kode Tiket <strong>$kodeTiket</strong>. Tim kami akan segera meninjau dan merespon.");
            header("Location: index.php?page=sapa-warga#feedAspirasi");
            exit;
        } catch (Exception $e) {
            set_flash('danger', 'Gagal menyimpan aspirasi: ' . $e->getMessage());
        }
    } else {
        set_flash('danger', implode('<br>', $errors));
    }
}

// Ambil Statistik
$stats = get_aspirasi_stats($pdo);

// Ambil Aspirasi Terbaru dari DB
$stmtFeed = $pdo->query("SELECT * FROM aspirasi ORDER BY created_at DESC LIMIT 10");
$aspirasiFeed = $stmtFeed->fetchAll();
// Ambil Pengaturan Dinamis Hero Sapa Warga
$fotoSapa   = get_pengaturan($pdo, 'foto_sapa_warga', 'assets/images/banner/dialog_warga.jpg');
$quoteSapa  = get_pengaturan($pdo, 'quote_sapa_warga', 'Setiap masukan dari warga adalah langkah menuju desa yang lebih baik.');
$namaCalon  = get_pengaturan($pdo, 'nama_calon', APP_NAME);
?>

<div class="container-custom py-4">
  <!-- Flash Alert Message -->
  <?= render_flash() ?>

  <!-- 1. Sapa Warga Header Banner (Identik dengan UI/1.png) -->
  <div class="sapa-banner-rich mb-4" style="background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 100%);">
    <div class="row align-items-center g-4">
      <!-- Sisi Kiri: Judul & Subtitle -->
      <div class="col-lg-7">
        <h1 class="display-5 fw-bold text-white mb-2">Sapa Warga</h1>
        <p class="fs-5 text-white mb-0" style="opacity: 0.92; max-width: 540px; font-weight: 400;">
          Ruang untuk berdialog, mendengar, dan mencari solusi bersama untuk Tampirkulon yang lebih baik.
        </p>
      </div>

      <!-- Sisi Kanan: Kartu Kutipan & Foto Calon Bersama Warga -->
      <div class="col-lg-5">
        <div class="sapa-quote-card">
          <div class="pe-2">
            <i class="bi bi-quote fs-2 text-danger lh-1"></i>
            <p class="mb-1 fw-bold font-handwriting fs-5 text-dark" style="line-height: 1.25;">
              "<?= e($quoteSapa) ?>"
            </p>
            <div class="text-secondary small fw-bold font-handwriting fs-6 text-end">- <?= e($namaCalon) ?></div>
          </div>
          <div class="flex-shrink-0">
            <img src="<?= e($fotoSapa) ?>" alt="<?= e($namaCalon) ?> Bersama Warga" class="rounded-3 shadow-sm object-fit-cover" style="width: 130px; height: 90px;">
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- 2. Sub-Tabs Navigasi Bersih & Bergaris Bawah Merah (Sesuai UI/1.png) -->
  <div class="sapa-nav-tabs-clean" id="sapaNavTabs">
    <button class="tab-link-clean active" data-tab-target="#tab-aspirasi">Sampaikan Aspirasi</button>
    <button class="tab-link-clean" data-tab-target="#tab-diskusi">Diskusi Warga</button>
    <button class="tab-link-clean" data-tab-target="#tab-polling">Polling &amp; Usulan</button>
    <button class="tab-link-clean" data-tab-target="#tab-agenda">Agenda Pertemuan</button>
    <button class="tab-link-clean" data-tab-target="#tab-faq">Tanya Jawab (FAQ)</button>
    <button class="tab-link-clean" data-tab-target="#tab-peta">Peta Aspirasi</button>
  </div>

  <!-- Tab Panels Container -->
  <div id="sapaTabPanels">
    
    <!-- TAB 1: Sampaikan Aspirasi (Tampilan Utama Mockup) -->
    <div class="tab-pane-content" id="tab-aspirasi">
      <div class="row g-4">
        
        <!-- Kolom Kiri: Form Sampaikan Aspirasi -->
        <div class="col-lg-7">
          <div class="form-card-aspirasi" id="formAspirasi">
            <h3 class="fw-bold text-dark mb-1">Sampaikan Aspirasi</h3>
            <p class="text-muted small mb-4">Dari warga, bersama warga, untuk Tampirkulon yang lebih baik.</p>

            <form action="index.php?page=sapa-warga" method="POST" enctype="multipart/form-data">
              <?= csrf_field() ?>
              <input type="hidden" name="action" value="kirim_aspirasi">

              <!-- Nama Lengkap -->
              <div class="mb-3">
                <label for="namaLengkap" class="form-label fw-semibold small text-dark">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" class="form-control rounded-3 py-2 px-3" id="namaLengkap" name="nama_lengkap" placeholder="Masukkan nama Anda" required>
              </div>

              <!-- Pilih Dusun -->
              <div class="mb-3">
                <label for="pilihDusun" class="form-label fw-semibold small text-dark">Pilih Dusun <span class="text-danger">*</span></label>
                <select class="form-select rounded-3 py-2 px-3" id="pilihDusun" name="dusun" required>
                  <option value="" selected disabled>-- Pilih Dusun --</option>
                  <?php foreach ($DUSUN_LIST as $dusunName): ?>
                    <option value="<?= e($dusunName) ?>"><?= e($dusunName) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <!-- Kategori Aspirasi (2 Kolom Bersih seperti UI/1.png) -->
              <div class="mb-3">
                <label class="form-label fw-semibold small text-dark d-block mb-2">Kategori Aspirasi <span class="text-danger">*</span></label>
                <div class="row">
                  <!-- Kolom 1 -->
                  <div class="col-6">
                    <label class="radio-clean-item small">
                      <input type="radio" name="kategori_aspirasi" value="Infrastruktur" checked required>
                      <span>Infrastruktur</span>
                    </label>
                    <label class="radio-clean-item small">
                      <input type="radio" name="kategori_aspirasi" value="Pendidikan">
                      <span>Pendidikan</span>
                    </label>
                    <label class="radio-clean-item small">
                      <input type="radio" name="kategori_aspirasi" value="Pemuda">
                      <span>Pemuda</span>
                    </label>
                    <label class="radio-clean-item small">
                      <input type="radio" name="kategori_aspirasi" value="Lainnya">
                      <span>Lainnya</span>
                    </label>
                  </div>
                  <!-- Kolom 2 -->
                  <div class="col-6">
                    <label class="radio-clean-item small">
                      <input type="radio" name="kategori_aspirasi" value="Ekonomi">
                      <span>Ekonomi</span>
                    </label>
                    <label class="radio-clean-item small">
                      <input type="radio" name="kategori_aspirasi" value="Lingkungan">
                      <span>Lingkungan</span>
                    </label>
                    <label class="radio-clean-item small">
                      <input type="radio" name="kategori_aspirasi" value="Pelayanan">
                      <span>Pelayanan</span>
                    </label>
                  </div>
                </div>
              </div>

              <!-- Tulis Aspirasi Anda -->
              <div class="mb-3">
                <label for="isiAspirasi" class="form-label fw-semibold small text-dark">Tulis Aspirasi Anda <span class="text-danger">*</span></label>
                <textarea class="form-control rounded-3 p-3" id="isiAspirasi" name="isi_aspirasi" rows="4" placeholder="Ceritakan aspirasi, saran atau keluhan Anda..." required></textarea>
              </div>

              <!-- Upload Foto (Opsional) -->
              <div class="mb-3">
                <label class="form-label fw-semibold small text-dark">Upload Foto (Opsional)</label>
                <div class="d-flex align-items-center gap-3">
                  <input type="file" class="form-control rounded-3" id="uploadFotoAspirasi" name="foto_aspirasi" accept="image/jpeg,image/png,image/webp">
                </div>
                <div class="form-text text-muted" style="font-size: 0.78rem;">Maks. 5 MB (JPG, PNG)</div>
                <div id="previewFotoAspirasi" class="mt-2" style="display: none;">
                  <img id="imgPreviewFoto" src="" alt="Preview Foto" class="img-thumbnail rounded-3" style="max-height: 100px;">
                </div>
              </div>

              <!-- Anonim Checkbox -->
              <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" name="is_anonim" value="1" id="checkAnonim" style="cursor: pointer;">
                <label class="form-check-label small text-muted" for="checkAnonim" style="cursor: pointer;">
                  Izinkan aspirasi saya ditampilkan secara anonim di website untuk kepentingan umum.
                </label>
              </div>

              <!-- Submit Button Merah Lebar Sesuai Mockup -->
              <button type="submit" class="btn btn-danger btn-lg w-100 rounded-3 fw-bold py-3 shadow-sm" style="background-color: #b71c1c; border: none;">
                Kirim Aspirasi
              </button>

              <div class="d-flex align-items-center justify-content-center gap-1 mt-3 text-muted small" style="font-size: 0.8rem;">
                <i class="bi bi-shield-check text-success"></i>
                <span>Identitas warga dijaga kerahasiaannya.</span>
              </div>
            </form>
          </div>
        </div>

        <!-- Kolom Kanan: Statistik & Feed Aspirasi Terbaru -->
        <div class="col-lg-5">
          
          <!-- Box 1: Statistik Aspirasi -->
          <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white border border-light-subtle">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h5 class="fw-bold mb-0 text-dark">Statistik Aspirasi</h5>
              <a href="#feedAspirasi" class="text-danger small fw-bold text-decoration-none">Lihat Semua &rarr;</a>
            </div>

            <div class="row g-3">
              <!-- 124 Total Aspirasi -->
              <div class="col-6">
                <div class="stat-box">
                  <div class="stat-icon bg-danger-subtle text-danger">
                    <i class="bi bi-inbox-fill"></i>
                  </div>
                  <div>
                    <div class="stat-number"><?= $stats['total'] ?></div>
                    <div class="stat-label">Total Aspirasi</div>
                  </div>
                </div>
              </div>

              <!-- 32 Dalam Proses -->
              <div class="col-6">
                <div class="stat-box">
                  <div class="stat-icon bg-primary-subtle text-primary">
                    <i class="bi bi-person-walking"></i>
                  </div>
                  <div>
                    <div class="stat-number"><?= $stats['dalam_proses'] ?></div>
                    <div class="stat-label">Dalam Proses</div>
                  </div>
                </div>
              </div>

              <!-- 87 Selesai -->
              <div class="col-6">
                <div class="stat-box">
                  <div class="stat-icon bg-success-subtle text-success">
                    <i class="bi bi-check2-circle"></i>
                  </div>
                  <div>
                    <div class="stat-number"><?= $stats['selesai'] ?></div>
                    <div class="stat-label">Selesai</div>
                  </div>
                </div>
              </div>

              <!-- 5 Rencana Program -->
              <div class="col-6">
                <div class="stat-box">
                  <div class="stat-icon bg-purple-subtle" style="background-color: #f3e8ff; color: #7e22ce;">
                    <i class="bi bi-box-seam-fill"></i>
                  </div>
                  <div>
                    <div class="stat-number"><?= $stats['rencana_program'] ?></div>
                    <div class="stat-label">Rencana Program</div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Box 2: Aspirasi Terbaru -->
          <div class="card border-0 shadow-sm rounded-4 p-4 bg-white border border-light-subtle" id="feedAspirasi">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h5 class="fw-bold mb-0 text-dark">Aspirasi Terbaru</h5>
              <div class="d-flex gap-2">
                <select id="filterStatusAspirasi" class="form-select form-select-sm" style="font-size: 0.78rem;">
                  <option value="all">Semua Status</option>
                  <option value="dalam proses">Dalam Proses</option>
                  <option value="selesai">Selesai</option>
                  <option value="rencana program">Rencana</option>
                </select>
              </div>
            </div>

            <!-- List Aspirasi Feed -->
            <div class="aspirasi-list-scroll" style="max-height: 480px; overflow-y: auto; padding-right: 4px;">
              <?php foreach ($aspirasiFeed as $asp): 
                $statusClass = 'badge-status-proses';
                if ($asp['status'] === 'Selesai') $statusClass = 'badge-status-selesai';
                elseif ($asp['status'] === 'Rencana Program') $statusClass = 'badge-status-rencana';
              ?>
              <div class="card-aspirasi-item aspirasi-item-row" data-dusun="<?= e($asp['dusun']) ?>" data-status="<?= e($asp['status']) ?>">
                <div class="d-flex justify-content-between align-items-start mb-2">
                  <h6 class="fw-bold text-dark mb-0 fs-6">
                    <?= e(substr($asp['isi_aspirasi'], 0, 42)) ?><?= strlen($asp['isi_aspirasi']) > 42 ? '...' : '' ?>
                  </h6>
                  <span class="badge-status <?= $statusClass ?> ms-2 text-nowrap">
                    <?= e($asp['status']) ?>
                  </span>
                </div>
                
                <p class="small text-muted mb-2 lh-sm">
                  <?= e($asp['isi_aspirasi']) ?>
                </p>

                <?php if (!empty($asp['foto'])): ?>
                <div class="mb-2">
                  <img src="<?= e($asp['foto']) ?>" alt="Foto Aspirasi" class="img-thumbnail rounded-3" style="max-height: 80px;">
                </div>
                <?php endif; ?>

                <?php if (!empty($asp['tanggapan'])): ?>
                <div class="p-2 rounded bg-light border-start border-3 border-danger mb-2 small text-secondary">
                  <strong class="text-danger d-block"><i class="bi bi-reply-fill"></i> Tanggapan Tim:</strong>
                  <?= e($asp['tanggapan']) ?>
                </div>
                <?php endif; ?>

                <div class="d-flex flex-wrap align-items-center justify-content-between pt-1 border-top border-light-subtle text-muted" style="font-size: 0.75rem;">
                  <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-light text-dark border">
                      <i class="bi bi-tag-fill me-1 text-danger"></i><?= e($asp['kategori']) ?>
                    </span>
                    <span><i class="bi bi-geo-alt me-1"></i><?= e($asp['dusun']) ?></span>
                  </div>
                  <div class="d-flex align-items-center gap-2">
                    <span><i class="bi bi-calendar3 me-1"></i><?= format_tanggal_id($asp['created_at']) ?></span>
                    <span>•</span>
                    <span><?= $asp['is_anonim'] ? 'Anonim' : e($asp['nama_warga']) ?></span>
                  </div>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>

      <!-- 3 Fitur Bawah: Diskusi Warga, Agenda Pertemuan, Peta Aspirasi (Identik UI/1.png) -->
      <div class="row g-4 mt-2">
        <div class="col-md-4">
          <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white border border-light-subtle">
            <div class="d-flex align-items-center gap-3 mb-3">
              <div class="rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                <i class="bi bi-chat-dots-fill fs-5"></i>
              </div>
              <h5 class="fw-bold mb-0">Diskusi Warga</h5>
            </div>
            <p class="text-muted small mb-4">Forum diskusi antar warga dan tim calon untuk membahas ide, masalah, dan solusi bersama.</p>
            <div class="mt-auto">
              <button class="btn btn-link text-danger fw-bold p-0 text-decoration-none tab-trigger-btn" data-target="tab-diskusi">
                Lihat Contoh &rarr;
              </button>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white border border-light-subtle">
            <div class="d-flex align-items-center gap-3 mb-3">
              <div class="rounded-circle bg-danger-subtle text-danger d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                <i class="bi bi-calendar-check-fill fs-5"></i>
              </div>
              <h5 class="fw-bold mb-0">Agenda Pertemuan</h5>
            </div>
            <p class="text-muted small mb-4">Informasi jadwal pertemuan, kunjungan dusun, dan dialog bersama warga Tampirkulon.</p>
            <div class="mt-auto">
              <button class="btn btn-link text-danger fw-bold p-0 text-decoration-none tab-trigger-btn" data-target="tab-agenda">
                Lihat Contoh &rarr;
              </button>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white border border-light-subtle">
            <div class="d-flex align-items-center gap-3 mb-3">
              <div class="rounded-circle bg-info-subtle text-info d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                <i class="bi bi-geo-alt-fill fs-5"></i>
              </div>
              <h5 class="fw-bold mb-0">Peta Aspirasi</h5>
            </div>
            <p class="text-muted small mb-4">Peta sebaran aspirasi warga berdasarkan kategori dan persebaran lokasi dusun.</p>
            <div class="mt-auto">
              <button class="btn btn-link text-danger fw-bold p-0 text-decoration-none tab-trigger-btn" data-target="tab-peta">
                Lihat Contoh &rarr;
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- TAB 2: Diskusi Warga -->
    <div class="tab-pane-content" id="tab-diskusi" style="display: none;">
      <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
        <h4 class="fw-bold mb-3"><i class="bi bi-chat-square-text-fill text-danger me-2"></i>Forum Diskusi Warga Tampirkulon</h4>
        <p class="text-muted">Ruang rembug online untuk bertukar pandangan terkait pengembangan sektor pertanian, fasilitas pemuda, dan UMKM.</p>
        <div class="alert alert-info d-flex align-items-center">
          <i class="bi bi-info-circle-fill fs-4 me-2"></i>
          <div>Topik diskusi minggu ini: <strong>"Pemanfaatan Saluran Irigasi Tersier &amp; Kebersihan Aliran Wisata Tubing"</strong>. Sampaikan pandangan Anda melalui form Sapa Warga.</div>
        </div>
      </div>
    </div>

    <!-- TAB 3: Polling & Usulan -->
    <div class="tab-pane-content" id="tab-polling" style="display: none;">
      <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
        <h4 class="fw-bold mb-3"><i class="bi bi-pie-chart-fill text-danger me-2"></i>Polling &amp; Suara Warga</h4>
        <p class="text-muted mb-4">Berikan vote Anda untuk menentukan prioritas pembangunan tahun pertama jika Pak Edy Susanto terpilih memimpin Tampirkulon.</p>
        <div class="border rounded-4 p-4 mb-3">
          <h6 class="fw-bold">Manakah sektor prioritas yang paling mendesak di dusun Anda?</h6>
          <div class="progress mb-2" style="height: 24px;">
            <div class="progress-bar bg-success" style="width: 45%;">Pertanian &amp; Irigasi (45%)</div>
          </div>
          <div class="progress mb-2" style="height: 24px;">
            <div class="progress-bar bg-primary" style="width: 30%;">Infrastruktur Jalan Lingkungan (30%)</div>
          </div>
          <div class="progress" style="height: 24px;">
            <div class="progress-bar bg-warning text-dark" style="width: 25%;">Pemberdayaan UMKM &amp; Pemuda (25%)</div>
          </div>
        </div>
      </div>
    </div>

    <!-- TAB 4: Agenda Pertemuan -->
    <div class="tab-pane-content" id="tab-agenda" style="display: none;">
      <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
        <h4 class="fw-bold mb-3"><i class="bi bi-calendar-event-fill text-danger me-2"></i>Jadwal Sapa Warga &amp; Temu Tokoh</h4>
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead class="table-light">
              <tr>
                <th>Waktu &amp; Tanggal</th>
                <th>Lokasi / Dusun</th>
                <th>Agenda Kegiatan</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><strong>Sabtu, 18 Juni 2026</strong><br><small class="text-muted">19.30 WIB</small></td>
                <td>Balai Pertemuan Dusun Tampirkulon</td>
                <td>Rembug Tani &amp; Sosialisasi Program Pupuk Tepat Sasaran</td>
                <td><span class="badge bg-success">Terjadwal</span></td>
              </tr>
              <tr>
                <td><strong>Minggu, 19 Juni 2026</strong><br><small class="text-muted">08.00 WIB</small></td>
                <td>Bantaran Sungai Wisata Tubing</td>
                <td>Kerja Bakti Bersama Pemuda &amp; Karang Taruna Tampirkulon</td>
                <td><span class="badge bg-success">Terjadwal</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- TAB 5: Tanya Jawab (FAQ) -->
    <div class="tab-pane-content" id="tab-faq" style="display: none;">
      <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
        <h4 class="fw-bold mb-3"><i class="bi bi-question-circle-fill text-danger me-2"></i>Tanya Jawab Seputar Program Edy Susanto</h4>
        <div class="accordion" id="faqAccordion">
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                Bagaimana cara melacak tindak lanjut aspirasi yang saya kirim?
              </button>
            </h2>
            <div id="faq1" class="accordion-collapse collapse show">
              <div class="accordion-body">
                Setiap aspirasi akan mendapatkan kode tiket unik (misal: ASP-20260612-001). Status akan terupdate otomatis di halaman ini antara <strong>Dalam Proses</strong>, <strong>Selesai</strong>, atau <strong>Rencana Program</strong>.
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                Apakah identitas saya aman saat mengirim kritik atau saran?
              </button>
            </h2>
            <div id="faq2" class="accordion-collapse collapse">
              <div class="accordion-body">
                Sangat aman. Anda cukup mencentang opsi <strong>"Tampilkan secara anonim"</strong> sehingga nama Anda tidak dipublikasikan kepada khalayak umum.
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- TAB 6: Peta Aspirasi -->
    <div class="tab-pane-content" id="tab-peta" style="display: none;">
      <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white text-center">
        <h4 class="fw-bold mb-3"><i class="bi bi-map-fill text-danger me-2"></i>Peta Sebaran Aspirasi Tampirkulon</h4>
        <p class="text-muted">Distribusi aspirasi masuk per dusun di wilayah Desa Tampirkulon.</p>
        <div class="row g-3 justify-content-center text-start mt-2">
          <?php foreach ($DUSUN_LIST as $d): ?>
          <div class="col-md-4">
            <div class="p-3 border rounded-3 bg-light">
              <div class="fw-bold text-dark"><?= e($d) ?></div>
              <small class="text-muted">Fokus: Infrastruktur jalan, irigasi sawah &amp; penerangan gang</small>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

  </div>
</div>
