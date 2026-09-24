<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

require_admin_auth();

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

require_once __DIR__ . '/header_admin.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h3 class="fw-bold mb-1">Dashboard Administrator</h3>
    <p class="text-muted mb-0">Selamat datang kembali, <strong><?= e($_SESSION['admin_nama'] ?? 'Admin') ?></strong>.</p>
  </div>
  <a href="../index.php" target="_blank" class="btn btn-outline-danger btn-sm rounded-pill px-3">
    <i class="bi bi-globe me-1"></i> Buka Website Tampirkulon
  </a>
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
          <h4 class="fw-bold mb-0"><?= $stats['total'] ?></h4>
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
          <h4 class="fw-bold mb-0"><?= $cntProgram ?></h4>
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
          <h4 class="fw-bold mb-0"><?= $cntBerita ?></h4>
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
          <h4 class="fw-bold mb-0"><?= $cntGaleri ?></h4>
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
});
</script>

<?php require_once __DIR__ . '/footer_admin.php'; ?>
