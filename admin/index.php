<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

require_admin_auth();

// Endpoint AJAX Realtime Stats (Ringan & Cepat < 2ms)
if (($_GET['action'] ?? '') === 'realtime_stats') {
    header('Content-Type: application/json; charset=utf-8');
    $stats = get_aspirasi_stats($pdo);
    $cntProgram = (int)$pdo->query("SELECT COUNT(*) FROM program")->fetchColumn();
    $cntBerita = (int)$pdo->query("SELECT COUNT(*) FROM berita")->fetchColumn();
    $cntGaleri = (int)$pdo->query("SELECT COUNT(*) FROM galeri")->fetchColumn();

    echo json_encode([
        'status' => 'success',
        'server_time' => date('H:i:s'),
        'stats' => [
            'aspirasi' => $stats['total'],
            'program' => $cntProgram,
            'berita' => $cntBerita,
            'galeri' => $cntGaleri
        ],
        'datasets' => [
            7  => get_chart_dashboard_data($pdo, 7),
            14 => get_chart_dashboard_data($pdo, 14),
            30 => get_chart_dashboard_data($pdo, 30)
        ],
        'map_data' => get_realtime_map_data($pdo)
    ], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
    exit;
}

// Handle Broadcast Notifikasi PWA
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['action']) && $_POST['action'] === 'broadcast_notif') {
    if (verify_csrf()) {
        $judul = sanitize($_POST['judul_notif'] ?? '');
        $pesan = sanitize($_POST['pesan_notif'] ?? '');
        $url = sanitize($_POST['url_notif'] ?? 'index.php?page=sapa-warga');

        if (!empty($judul) && !empty($pesan)) {
            create_pwa_notification($pdo, $judul, $pesan, $url);
            set_flash('success', 'Notifikasi PWA berhasil disimpan & disiarkan ke pengguna website.');
            safe_redirect("index.php");
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

// Dataset Chart Analytics (7, 14, 30 hari)
$chartData7  = get_chart_dashboard_data($pdo, 7);
$chartData14 = get_chart_dashboard_data($pdo, 14);
$chartData30 = get_chart_dashboard_data($pdo, 30);

// Dataset Peta Sebaran Lokasi Realtime
$mapData = get_realtime_map_data($pdo);

require_once __DIR__ . '/header_admin.php';
?>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
  <div>
    <div class="d-flex align-items-center gap-2 mb-1">
      <h3 class="fw-bold mb-0">Dashboard Administrator</h3>
      <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-1 small d-inline-flex align-items-center gap-1" style="font-size: 0.72rem;">
        <span class="spinner-grow spinner-grow-sm text-success" style="width: 7px; height: 7px;" role="status"></span> Live Realtime
      </span>
    </div>
    <p class="text-muted mb-0">Selamat datang kembali, <strong><?= e($_SESSION['admin_nama'] ?? 'Admin') ?></strong>. <span class="text-secondary small ms-2" id="lastUpdatedText">Sinkronisasi: <?= date('H:i:s') ?> WIB</span></p>
  </div>
  <div class="d-flex align-items-center gap-2">
    <button type="button" class="btn btn-sm btn-white bg-white border shadow-sm rounded-pill px-3 fw-semibold text-secondary" id="btnRefreshRealtime" title="Sinkronkan data realtime sekarang">
      <i class="bi bi-arrow-clockwise me-1" id="iconRefresh"></i> Segarkan Data
    </button>
    <a href="../index.php" target="_blank" class="btn btn-outline-danger btn-sm rounded-pill px-3">
      <i class="bi bi-globe me-1"></i> Buka Website
    </a>
  </div>
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
          <h4 class="fw-bold mb-0" id="statAspirasiTotal"><?= $stats['total'] ?></h4>
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
          <h4 class="fw-bold mb-0" id="statProgramTotal"><?= $cntProgram ?></h4>
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
          <h4 class="fw-bold mb-0" id="statBeritaTotal"><?= $cntBerita ?></h4>
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
          <h4 class="fw-bold mb-0" id="statGaleriTotal"><?= $cntGaleri ?></h4>
          <small class="text-muted">Dokumentasi Foto</small>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- SECTION BARU: Visual Analytics & Grafik Interaktif -->
<div class="row g-4 mb-4">
  <!-- Grafik Tren Kunjungan & Aspirasi Harian (Line/Area Chart) -->
  <div class="col-xl-8">
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
      <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div>
          <div class="d-flex align-items-center gap-2">
            <span class="rounded-circle bg-primary bg-opacity-10 text-primary d-inline-flex align-items-center justify-content-center" style="width: 34px; height: 34px;">
              <i class="bi bi-graph-up-arrow fs-6"></i>
            </span>
            <h5 class="fw-bold mb-0">Tren Kunjungan &amp; Aspirasi Sapa Warga</h5>
          </div>
          <small class="text-muted">Aktivitas kunjungan portal dan interaksi aspirasi masyarakat secara berkala</small>
        </div>
        
        <!-- Filter Periode (Interactive Buttons) -->
        <div class="btn-group btn-group-sm p-1 bg-light rounded-pill border" role="group" id="periodFilterGroup">
          <button type="button" class="btn btn-sm rounded-pill px-3 period-btn text-muted" data-days="7">7 Hari</button>
          <button type="button" class="btn btn-sm rounded-pill px-3 period-btn active bg-white shadow-sm fw-bold text-danger" data-days="14">14 Hari</button>
          <button type="button" class="btn btn-sm rounded-pill px-3 period-btn text-muted" data-days="30">30 Hari</button>
        </div>
      </div>

      <!-- Quick KPI Badges -->
      <div class="d-flex flex-wrap gap-2 gap-md-4 mb-3 pb-3 border-bottom small">
        <div class="d-flex align-items-center gap-2">
          <span class="badge bg-primary-subtle text-primary border rounded-pill px-2 py-1"><i class="bi bi-eye-fill me-1"></i> Total Kunjungan</span>
          <strong class="fs-6 text-dark" id="badgeTotalHits">-</strong>
        </div>
        <div class="d-flex align-items-center gap-2">
          <span class="badge bg-info-subtle text-info-emphasis border rounded-pill px-2 py-1"><i class="bi bi-people-fill me-1"></i> Pengunjung Unik</span>
          <strong class="fs-6 text-dark" id="badgeTotalVisitors">-</strong>
        </div>
        <div class="d-flex align-items-center gap-2">
          <span class="badge bg-danger-subtle text-danger border rounded-pill px-2 py-1"><i class="bi bi-chat-heart-fill me-1"></i> Aspirasi Masuk</span>
          <strong class="fs-6 text-dark" id="badgeTotalAspirasi">-</strong>
        </div>
      </div>

      <!-- Canvas Chart Tren -->
      <div class="position-relative" style="min-height: 290px; height: 300px; width: 100%;">
        <canvas id="trendChart"></canvas>
      </div>
    </div>
  </div>

  <!-- Grafik Distribusi Kategori Aspirasi (Doughnut Chart) -->
  <div class="col-xl-4">
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100 d-flex flex-column">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
          <div class="d-flex align-items-center gap-2">
            <span class="rounded-circle bg-danger bg-opacity-10 text-danger d-inline-flex align-items-center justify-content-center" style="width: 34px; height: 34px;">
              <i class="bi bi-pie-chart-fill fs-6"></i>
            </span>
            <h5 class="fw-bold mb-0">Topik Kategori Aspirasi</h5>
          </div>
          <small class="text-muted">Distribusi aspirasi yang disampaikan warga</small>
        </div>
      </div>

      <!-- Canvas Chart Kategori -->
      <div class="position-relative my-auto py-2" style="height: 220px; width: 100%;">
        <canvas id="categoryChart"></canvas>
      </div>

      <!-- Breakdown Legenda Ringkas -->
      <div class="pt-3 border-top mt-3" id="categoryLegendContainer" style="max-height: 130px; overflow-y: auto;">
        <!-- Dinamis diisi lewat JS -->
      </div>
    </div>
  </div>
</div>

<!-- SECTION BARU: Peta Sebaran Wilayah & Pengunjung Realtime -->
<div class="row g-4 mb-4">
  <div class="col-12">
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
      <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div>
          <div class="d-flex align-items-center gap-2">
            <span class="rounded-circle bg-danger bg-opacity-10 text-danger d-inline-flex align-items-center justify-content-center" style="width: 34px; height: 34px;">
              <i class="bi bi-geo-alt-fill fs-6"></i>
            </span>
            <h5 class="fw-bold mb-0">Peta Sebaran Lokasi Pengunjung Realtime</h5>
          </div>
          <small class="text-muted">Pemetaan geografis sebaran warga dan pengunjung yang mengakses website secara langsung</small>
        </div>

        <div class="d-flex align-items-center gap-2">
          <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2 small d-inline-flex align-items-center gap-1">
            <span class="spinner-grow spinner-grow-sm text-success" style="width: 7px; height: 7px;" role="status"></span>
            <strong id="badgeTotalActiveNow"><?= (int)($mapData['total_active'] ?? 0) ?></strong> Pengunjung Aktif (15 Menit)
          </span>
          <button type="button" class="btn btn-sm btn-light border rounded-pill px-3" id="btnCenterTampir" title="Pusatkan peta ke Tampirkulon">
            <i class="bi bi-compass me-1"></i> Pusatkan Desa
          </button>
        </div>
      </div>

      <div class="row g-3">
        <!-- Kolom Kiri: Peta Leaflet Interaktif -->
        <div class="col-lg-8 col-xl-9">
          <div class="rounded-4 overflow-hidden border position-relative" style="height: 380px;" id="visitorMapContainer">
            <div id="visitorMap" style="width: 100%; height: 100%;"></div>
          </div>
        </div>

        <!-- Kolom Kanan: Leaderboard Asal Kota & Status -->
        <div class="col-lg-4 col-xl-3 d-flex flex-column">
          <div class="border rounded-4 p-3 bg-light flex-grow-1 d-flex flex-column">
            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
              <h6 class="fw-bold mb-0 small text-uppercase text-secondary">
                <i class="bi bi-trophy-fill text-warning me-1"></i> Asal Kota Terbanyak
              </h6>
              <span class="badge bg-white text-dark border small" id="totalHitsBadge"><?= number_format($mapData['total_hits_all'] ?? 0, 0, ',', '.') ?> Hits</span>
            </div>

            <div class="leaderboard-list flex-grow-1" id="leaderboardList" style="max-height: 290px; overflow-y: auto;">
              <!-- Rendered dynamically -->
            </div>

            <div class="pt-2 border-top mt-2 small text-muted text-center" style="font-size: 0.75rem;">
              <i class="bi bi-shield-check text-success me-1"></i> Koordinat lokasi diproteksi (~1 km) demi privasi warga.
            </div>
          </div>
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

<!-- Script Inisialisasi Chart.js Analytics Interaktif -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Data dari backend PHP (Aman terhadap XSS via JSON_HEX)
  const chartDatasets = {
    7: <?= json_encode($chartData7, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>,
    14: <?= json_encode($chartData14, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>,
    30: <?= json_encode($chartData30, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>
  };

  const trendCanvas = document.getElementById('trendChart');
  const catCanvas = document.getElementById('categoryChart');
  if (!trendCanvas || !catCanvas) return;

  const ctxTrend = trendCanvas.getContext('2d');
  const ctxCat = catCanvas.getContext('2d');

  // Gradien modern untuk Kunjungan (Biru) dan Aspirasi (Merah)
  function createGradient(ctx, colorTop, colorBottom) {
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, colorTop);
    gradient.addColorStop(1, colorBottom);
    return gradient;
  }

  const gradBlue = createGradient(ctxTrend, 'rgba(59, 130, 246, 0.28)', 'rgba(59, 130, 246, 0.01)');
  const gradRed  = createGradient(ctxTrend, 'rgba(239, 68, 68, 0.32)', 'rgba(239, 68, 68, 0.01)');

  let currentDays = 14;
  let initialData = chartDatasets[currentDays] || chartDatasets[7];

  // Update badge ringkasan
  function updateSummaryBadges(data) {
    if (!data || !data.summary) return;
    document.getElementById('badgeTotalHits').textContent = Number(data.summary.total_hits).toLocaleString('id-ID');
    document.getElementById('badgeTotalVisitors').textContent = Number(data.summary.total_visitors).toLocaleString('id-ID');
    document.getElementById('badgeTotalAspirasi').textContent = Number(data.summary.total_aspirasi).toLocaleString('id-ID');
  }

  updateSummaryBadges(initialData);

  // Inisialisasi Line Chart Tren Harian
  const trendChart = new Chart(ctxTrend, {
    type: 'line',
    data: {
      labels: initialData.labels,
      datasets: [
        {
          label: 'Total Kunjungan',
          data: initialData.hits,
          borderColor: '#2563eb',
          backgroundColor: gradBlue,
          fill: true,
          tension: 0.38,
          borderWidth: 2.5,
          pointBackgroundColor: '#2563eb',
          pointBorderColor: '#ffffff',
          pointBorderWidth: 2,
          pointRadius: 3.5,
          pointHoverRadius: 6
        },
        {
          label: 'Pengunjung Unik',
          data: initialData.visitors,
          borderColor: '#06b6d4',
          backgroundColor: 'transparent',
          borderDash: [5, 4],
          tension: 0.38,
          borderWidth: 2,
          pointBackgroundColor: '#06b6d4',
          pointBorderColor: '#ffffff',
          pointBorderWidth: 2,
          pointRadius: 3,
          pointHoverRadius: 5
        },
        {
          label: 'Aspirasi Masuk',
          data: initialData.aspirasi,
          borderColor: '#dc2626',
          backgroundColor: gradRed,
          fill: true,
          tension: 0.38,
          borderWidth: 2.5,
          pointBackgroundColor: '#dc2626',
          pointBorderColor: '#ffffff',
          pointBorderWidth: 2,
          pointRadius: 4,
          pointHoverRadius: 6
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      interaction: {
        mode: 'index',
        intersect: false
      },
      plugins: {
        legend: {
          position: 'top',
          align: 'end',
          labels: {
            boxWidth: 12,
            boxHeight: 12,
            usePointStyle: true,
            pointStyle: 'circle',
            font: { family: "'Plus Jakarta Sans', sans-serif", size: 12, weight: 600 },
            color: '#475569'
          }
        },
        tooltip: {
          backgroundColor: '#0f172a',
          titleFont: { family: "'Plus Jakarta Sans', sans-serif", size: 12, weight: 700 },
          bodyFont: { family: "'Plus Jakarta Sans', sans-serif", size: 12 },
          padding: 10,
          cornerRadius: 8,
          boxPadding: 4
        }
      },
      scales: {
        x: {
          grid: { display: false },
          ticks: {
            font: { family: "'Plus Jakarta Sans', sans-serif", size: 11 },
            color: '#64748b'
          }
        },
        y: {
          beginAtZero: true,
          border: { dash: [4, 4] },
          grid: { color: 'rgba(226, 232, 240, 0.7)' },
          ticks: {
            precision: 0,
            font: { family: "'Plus Jakarta Sans', sans-serif", size: 11 },
            color: '#64748b'
          }
        }
      }
    }
  });

  // Filter Periode Interaktif (7 Hari / 14 Hari / 30 Hari)
  const periodBtns = document.querySelectorAll('.period-btn');
  periodBtns.forEach(btn => {
    btn.addEventListener('click', function() {
      periodBtns.forEach(b => {
        b.classList.remove('active', 'bg-white', 'shadow-sm', 'fw-bold', 'text-danger');
        b.classList.add('text-muted');
      });
      this.classList.add('active', 'bg-white', 'shadow-sm', 'fw-bold', 'text-danger');
      this.classList.remove('text-muted');

      const days = parseInt(this.getAttribute('data-days'), 10);
      const targetData = chartDatasets[days];
      if (!targetData) return;

      trendChart.data.labels = targetData.labels;
      trendChart.data.datasets[0].data = targetData.hits;
      trendChart.data.datasets[1].data = targetData.visitors;
      trendChart.data.datasets[2].data = targetData.aspirasi;
      trendChart.update();

      updateSummaryBadges(targetData);
    });
  });

  // Inisialisasi Donut Chart Kategori Aspirasi
  const catDataRaw = initialData.kategori || [];
  const catPalette = [
    '#dc2626', '#2563eb', '#10b981', '#f59e0b',
    '#8b5cf6', '#ec4899', '#06b6d4', '#64748b'
  ];

  let catLabels = catDataRaw.map(c => c.kategori || 'Umum');
  let catCounts = catDataRaw.map(c => parseInt(c.total, 10));

  if (catLabels.length === 0) {
    catLabels = ['Belum Ada Data'];
    catCounts = [1];
  }

  const catColors = catLabels.map((_, idx) => catPalette[idx % catPalette.length]);

  const categoryChart = new Chart(ctxCat, {
    type: 'doughnut',
    data: {
      labels: catLabels,
      datasets: [{
        data: catCounts,
        backgroundColor: catColors,
        borderWidth: 2,
        borderColor: '#ffffff',
        hoverOffset: 6
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      cutout: '70%',
      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor: '#0f172a',
          padding: 10,
          cornerRadius: 8,
          bodyFont: { family: "'Plus Jakarta Sans', sans-serif", size: 12 }
        }
      }
    }
  });

  // Render Legenda Kategori
  const legendBox = document.getElementById('categoryLegendContainer');
  if (legendBox && catDataRaw.length > 0) {
    const totalSemua = catCounts.reduce((a, b) => a + b, 0);
    let html = '<div class="row g-2">';
    catDataRaw.forEach((item, idx) => {
      const pct = totalSemua > 0 ? Math.round((item.total / totalSemua) * 100) : 0;
      const color = catPalette[idx % catPalette.length];
      html += `
        <div class="col-6">
          <div class="d-flex align-items-center justify-content-between p-1 px-2 rounded-2 bg-light">
            <div class="d-flex align-items-center gap-2 overflow-hidden me-1">
              <span class="rounded-circle flex-shrink-0" style="width: 8px; height: 8px; background-color: ${color};"></span>
              <span class="text-truncate" style="font-size: 0.78rem;" title="${item.kategori}">${item.kategori}</span>
            </div>
            <span class="fw-bold text-dark flex-shrink-0" style="font-size: 0.78rem;">${item.total} <small class="text-muted fw-normal">(${pct}%)</small></span>
          </div>
        </div>
      `;
    });
    html += '</div>';
    legendBox.innerHTML = html;
  } else if (legendBox) {
    legendBox.innerHTML = '<div class="text-muted text-center py-2" style="font-size: 0.8rem;">Belum ada kategori aspirasi masuk.</div>';
  }

  // --- Leaflet Interactive Visitor Map ---
  const initialMapData = <?= json_encode($mapData, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
  const mapElement = document.getElementById('visitorMap');
  let visitorMap = null;
  let mapLayerGroup = null;

  function renderMapData(data) {
    if (!visitorMap || !mapLayerGroup || !data) return;
    mapLayerGroup.clearLayers();

    // 1. Render Active Visitors Pins (Pulsing Radar Marker)
    const activeList = data.active || [];
    activeList.forEach(act => {
      const pulseIcon = L.divIcon({
        className: 'pulse-marker-wrapper',
        html: `
          <div class="pulse-ring"></div>
          <div class="pulse-core"></div>
        `,
        iconSize: [24, 24],
        iconAnchor: [12, 12]
      });

      const m = L.marker([act.lat, act.lng], { icon: pulseIcon }).addTo(mapLayerGroup);
      m.bindPopup(`
        <div class="p-1 text-center">
          <span class="badge bg-success-subtle text-success border border-success mb-1" style="font-size:0.7rem;">🟢 Sedang Aktif</span>
          <h6 class="fw-bold mb-0 text-dark">${act.kota}</h6>
          <small class="text-muted">${act.provinsi}</small>
          <div class="mt-1 small text-secondary">Halaman: <code>${act.halaman}</code></div>
          <div class="small text-muted" style="font-size:0.68rem;">Waktu: ${act.last_ping}</div>
        </div>
      `);
    });

    // 2. Render Circle Markers untuk Agregasi Lokasi Kota
    const locList = data.locations || [];
    locList.forEach(loc => {
      const hits = parseInt(loc.total_hits, 10);
      const radius = Math.min(26, Math.max(9, Math.sqrt(hits) * 3));

      const circle = L.circleMarker([loc.lat, loc.lng], {
        radius: radius,
        color: '#b71c1c',
        weight: 2,
        fillColor: '#ef4444',
        fillOpacity: 0.35
      }).addTo(mapLayerGroup);

      circle.bindPopup(`
        <div class="p-1">
          <h6 class="fw-bold mb-1 text-dark">${loc.kota}</h6>
          <div class="small text-muted mb-2">${loc.provinsi}, ${loc.negara}</div>
          <div class="d-flex justify-content-between gap-3 small border-top pt-1">
            <span>Total Kunjungan:</span>
            <strong>${hits.toLocaleString('id-ID')} hits</strong>
          </div>
          <div class="d-flex justify-content-between gap-3 small">
            <span>Pengunjung Unik:</span>
            <strong>${parseInt(loc.unique_visitors, 10).toLocaleString('id-ID')}</strong>
          </div>
        </div>
      `);
    });

    // Update Counter Pengunjung Aktif
    const elActiveCount = document.getElementById('badgeTotalActiveNow');
    if (elActiveCount) {
      elActiveCount.textContent = data.total_active || activeList.length;
    }

    // Update Leaderboard List
    const lbList = document.getElementById('leaderboardList');
    if (lbList) {
      const topCities = data.top_cities || [];
      if (topCities.length === 0) {
        lbList.innerHTML = '<div class="text-center text-muted py-3 small">Belum ada data wilayah.</div>';
      } else {
        let html = '';
        topCities.forEach(item => {
          const badgeClass = item.rank === 1 ? 'bg-danger text-white' : (item.rank === 2 ? 'bg-primary text-white' : 'bg-white text-dark border');
          html += `
            <div class="d-flex align-items-center justify-content-between p-2 mb-1 rounded-3 bg-white border shadow-xs city-row-item" style="cursor: pointer;" data-lat="${item.lat}" data-lng="${item.lng}">
              <div class="d-flex align-items-center gap-2 overflow-hidden me-1">
                <span class="badge ${badgeClass} rounded-circle px-1" style="width: 22px; height: 22px; display: inline-flex; align-items: center; justify-content: center; font-size: 0.72rem;">${item.rank}</span>
                <div class="text-truncate">
                  <strong class="d-block small text-dark text-truncate" title="${item.kota}">${item.kota}</strong>
                  <span class="text-muted" style="font-size: 0.7rem;">${item.provinsi}</span>
                </div>
              </div>
              <div class="text-end flex-shrink-0">
                <span class="fw-bold text-dark small">${item.hits}</span>
                <small class="text-muted d-block" style="font-size: 0.68rem;">${item.pct}%</small>
              </div>
            </div>
          `;
        });
        lbList.innerHTML = html;

        // Klik kota untuk fly to di peta
        document.querySelectorAll('.city-row-item').forEach(el => {
          el.addEventListener('click', function() {
            const lat = parseFloat(this.getAttribute('data-lat'));
            const lng = parseFloat(this.getAttribute('data-lng'));
            if (!isNaN(lat) && !isNaN(lng) && visitorMap) {
              visitorMap.flyTo([lat, lng], 11);
            }
          });
        });
      }
    }

    const elTotalHitsBadge = document.getElementById('totalHitsBadge');
    if (elTotalHitsBadge && data.total_hits_all !== undefined) {
      elTotalHitsBadge.textContent = Number(data.total_hits_all).toLocaleString('id-ID') + ' Hits';
    }
  }

  if (mapElement && typeof L !== 'undefined') {
    visitorMap = L.map('visitorMap', {
      zoomControl: true,
      scrollWheelZoom: false
    }).setView([-7.5020, 110.2740], 9);

    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
      attribution: '&copy; <a href="https://carto.com/">CARTO</a>, &copy; <a href="https://www.openstreetmap.org/copyright">OSM</a>',
      maxZoom: 18
    }).addTo(visitorMap);

    mapLayerGroup = L.layerGroup().addTo(visitorMap);

    renderMapData(initialMapData);

    const btnCenter = document.getElementById('btnCenterTampir');
    if (btnCenter) {
      btnCenter.addEventListener('click', () => {
        visitorMap.flyTo([-7.5020, 110.2740], 11);
      });
    }

    setTimeout(() => {
      if (visitorMap) visitorMap.invalidateSize();
    }, 400);
  }

  // --- Realtime Sync Engine (Ringan & Cepat < 2ms) ---
  let isFetching = false;
  async function fetchRealtimeData(manual = false) {
    if (isFetching) return;
    const refreshBtn = document.getElementById('btnRefreshRealtime');
    const refreshIcon = document.getElementById('iconRefresh');
    if (manual && refreshIcon) {
      refreshIcon.style.animation = 'spin 0.8s linear infinite';
      refreshIcon.style.display = 'inline-block';
    }

    isFetching = true;
    try {
      const res = await fetch('index.php?action=realtime_stats', {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      });
      if (!res.ok) throw new Error('HTTP ' + res.status);
      const json = await res.json();

      if (json.status === 'success') {
        // 1. Update 4 Kartu KPI Atas
        if (json.stats) {
          const elAsp = document.getElementById('statAspirasiTotal');
          const elProg = document.getElementById('statProgramTotal');
          const elBer = document.getElementById('statBeritaTotal');
          const elGal = document.getElementById('statGaleriTotal');
          if (elAsp) elAsp.textContent = json.stats.aspirasi;
          if (elProg) elProg.textContent = json.stats.program;
          if (elBer) elBer.textContent = json.stats.berita;
          if (elGal) elGal.textContent = json.stats.galeri;
        }

        // 2. Update Dataset Grafik
        if (json.datasets) {
          chartDatasets[7] = json.datasets[7];
          chartDatasets[14] = json.datasets[14];
          chartDatasets[30] = json.datasets[30];

          const activeData = chartDatasets[currentDays];
          if (activeData) {
            trendChart.data.labels = activeData.labels;
            trendChart.data.datasets[0].data = activeData.hits;
            trendChart.data.datasets[1].data = activeData.visitors;
            trendChart.data.datasets[2].data = activeData.aspirasi;
            trendChart.update('none'); // Update visual tanpa flickering
            updateSummaryBadges(activeData);
          }
        }

        // 3. Update Peta Sebaran & Leaderboard Kota
        if (json.map_data) {
          renderMapData(json.map_data);
        }

        // 4. Update Jam Sinkronisasi
        const timeEl = document.getElementById('lastUpdatedText');
        if (timeEl && json.server_time) {
          timeEl.textContent = 'Sinkronisasi: ' + json.server_time + ' WIB';
        }
      }
    } catch (e) {
      console.warn('Realtime sync skipped:', e);
    } finally {
      isFetching = false;
      if (refreshIcon) {
        refreshIcon.style.animation = '';
      }
    }
  }

  // Auto-polling setiap 30 detik (hanya jika tab browser sedang aktif dibuka)
  setInterval(() => {
    if (!document.hidden) {
      fetchRealtimeData(false);
    }
  }, 30000);

  // Manual Refresh Listener
  const refreshBtn = document.getElementById('btnRefreshRealtime');
  if (refreshBtn) {
    refreshBtn.addEventListener('click', () => fetchRealtimeData(true));
  }
});
</script>

<style>
@keyframes spin { 100% { transform: rotate(360deg); } }

/* Pulse radar marker styling untuk visitor aktif */
.pulse-marker-wrapper {
  position: relative;
  width: 24px;
  height: 24px;
}
.pulse-core {
  position: absolute;
  top: 6px;
  left: 6px;
  width: 12px;
  height: 12px;
  border-radius: 50%;
  background-color: #10b981;
  border: 2px solid #ffffff;
  box-shadow: 0 0 8px rgba(16, 185, 129, 0.9);
  z-index: 2;
}
.pulse-ring {
  position: absolute;
  top: 0;
  left: 0;
  width: 24px;
  height: 24px;
  border-radius: 50%;
  background-color: rgba(16, 185, 129, 0.45);
  animation: pulse-ring 1.8s ease-out infinite;
  z-index: 1;
}
@keyframes pulse-ring {
  0% { transform: scale(0.5); opacity: 1; }
  100% { transform: scale(2.3); opacity: 0; }
}
</style>

<?php require_once __DIR__ . '/footer_admin.php'; ?>
