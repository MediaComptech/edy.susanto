<?php
/**
 * Ganti Password Administrator
 * Portal Administrator Calon Kepala Desa Tampirkulon - Edy Susanto (No. Urut 2)
 */

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

require_admin_auth();

$adminId = (int)($_SESSION['admin_id'] ?? 0);
$stmtAdmin = $pdo->prepare("SELECT * FROM admin WHERE id = ? LIMIT 1");
$stmtAdmin->execute([$adminId]);
$admin = $stmtAdmin->fetch();

if (!$admin) {
    set_flash('danger', 'Akun administrator tidak ditemukan.');
    safe_redirect('login.php');
}

// Proses form ganti password
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf()) {
        set_flash('danger', 'Validasi sesi CSRF gagal. Silakan coba lagi.');
        safe_redirect('ganti_password.php');
    }

    $nama = sanitize($_POST['nama'] ?? $admin['nama']);
    if (empty($nama)) {
        $nama = $admin['nama'];
    }

    $passwordLama = $_POST['password_lama'] ?? '';
    $passwordBaru = $_POST['password_baru'] ?? '';
    $konfirmasiPassword = $_POST['konfirmasi_password'] ?? '';

    // Validasi
    if (empty($passwordLama)) {
        set_flash('danger', 'Password saat ini (lama) wajib diisi untuk verifikasi keamanan.');
    } elseif (!password_verify($passwordLama, $admin['password'])) {
        set_flash('danger', 'Password saat ini (lama) yang Anda masukkan tidak sesuai.');
    } elseif (empty($passwordBaru)) {
        set_flash('danger', 'Password baru tidak boleh kosong.');
    } elseif (strlen($passwordBaru) < 6) {
        set_flash('danger', 'Password baru minimal harus 6 karakter.');
    } elseif ($passwordBaru !== $konfirmasiPassword) {
        set_flash('danger', 'Konfirmasi password baru tidak cocok.');
    } elseif ($passwordLama === $passwordBaru) {
        set_flash('warning', 'Password baru tidak boleh sama persis dengan password lama.');
    } else {
        // Enkripsi hash password baru
        $passwordHash = password_hash($passwordBaru, PASSWORD_DEFAULT);

        $stmtUpdate = $pdo->prepare("UPDATE admin SET password = ?, nama = ? WHERE id = ?");
        $stmtUpdate->execute([$passwordHash, $nama, $adminId]);

        $_SESSION['admin_nama'] = $nama;

        set_flash('success', 'Password administrator berhasil diperbarui! Silakan gunakan password baru ini pada login berikutnya.');
        safe_redirect('ganti_password.php');
    }
}

require_once __DIR__ . '/header_admin.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h3 class="fw-bold mb-1">Ganti Password Administrator</h3>
    <p class="text-muted mb-0">Kelola keamanan akun dan perbarui kata sandi login administrator.</p>
  </div>
  <a href="index.php" class="btn btn-outline-secondary rounded-pill px-3">
    <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
  </a>
</div>

<div class="row g-4">
  <!-- Kolom Form Ganti Password -->
  <div class="col-lg-7 col-xl-6">
    <div class="card border-0 shadow-sm rounded-4 bg-white p-4">
      <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
        <div class="rounded-circle bg-danger bg-opacity-10 text-danger d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
          <i class="bi bi-shield-lock-fill fs-4"></i>
        </div>
        <div>
          <h5 class="fw-bold mb-0">Formulir Kata Sandi</h5>
          <small class="text-muted">Masukkan kata sandi lama untuk mengonfirmasi perubahan.</small>
        </div>
      </div>

      <form action="ganti_password.php" method="POST" autocomplete="off">
        <?= csrf_field() ?>

        <!-- Nama Lengkap / Display Name -->
        <div class="mb-3">
          <label class="form-label small fw-semibold text-secondary">Nama Lengkap Administrator</label>
          <div class="input-group">
            <span class="input-group-text bg-light border-end-0"><i class="bi bi-person text-muted"></i></span>
            <input type="text" class="form-control border-start-0 ps-0" name="nama" value="<?= e($admin['nama']) ?>" required>
          </div>
          <div class="form-text small text-muted">Nama yang tampil pada dashboard admin.</div>
        </div>

        <!-- Username (Readonly) -->
        <div class="mb-3">
          <label class="form-label small fw-semibold text-secondary">Username Akun</label>
          <div class="input-group">
            <span class="input-group-text bg-light border-end-0"><i class="bi bi-at text-muted"></i></span>
            <input type="text" class="form-control border-start-0 ps-0 bg-light" value="<?= e($admin['username']) ?>" readonly disabled>
          </div>
          <div class="form-text small text-muted">Username login bersifat permanen dan tidak dapat diubah.</div>
        </div>

        <hr class="my-4 text-secondary opacity-25">

        <!-- Password Lama -->
        <div class="mb-3">
          <label class="form-label small fw-semibold text-secondary">Password Saat Ini (Lama) <span class="text-danger">*</span></label>
          <div class="input-group">
            <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock text-muted"></i></span>
            <input type="password" class="form-control border-start-0 border-end-0 ps-0" id="password_lama" name="password_lama" placeholder="Masukkan password lama Anda" required>
            <button class="btn btn-outline-secondary border-start-0 bg-light text-muted toggle-password" type="button" data-target="password_lama" title="Tampilkan/Sembunyikan Password">
              <i class="bi bi-eye"></i>
            </button>
          </div>
        </div>

        <!-- Password Baru -->
        <div class="mb-3">
          <label class="form-label small fw-semibold text-secondary">Password Baru <span class="text-danger">*</span></label>
          <div class="input-group">
            <span class="input-group-text bg-light border-end-0"><i class="bi bi-key text-muted"></i></span>
            <input type="password" class="form-control border-start-0 border-end-0 ps-0" id="password_baru" name="password_baru" placeholder="Minimal 6 karakter" minlength="6" required>
            <button class="btn btn-outline-secondary border-start-0 bg-light text-muted toggle-password" type="button" data-target="password_baru" title="Tampilkan/Sembunyikan Password">
              <i class="bi bi-eye"></i>
            </button>
          </div>
          <div class="form-text small text-muted">Gunakan minimal 6 karakter kombinasi huruf dan angka.</div>
        </div>

        <!-- Konfirmasi Password Baru -->
        <div class="mb-4">
          <label class="form-label small fw-semibold text-secondary">Konfirmasi Password Baru <span class="text-danger">*</span></label>
          <div class="input-group">
            <span class="input-group-text bg-light border-end-0"><i class="bi bi-check2-circle text-muted"></i></span>
            <input type="password" class="form-control border-start-0 border-end-0 ps-0" id="konfirmasi_password" name="konfirmasi_password" placeholder="Ulangi password baru Anda" minlength="6" required>
            <button class="btn btn-outline-secondary border-start-0 bg-light text-muted toggle-password" type="button" data-target="konfirmasi_password" title="Tampilkan/Sembunyikan Password">
              <i class="bi bi-eye"></i>
            </button>
          </div>
        </div>

        <div class="d-flex gap-2 pt-2">
          <button type="submit" class="btn btn-danger rounded-3 px-4 py-2 fw-semibold shadow-sm">
            <i class="bi bi-check-lg me-1"></i> Simpan Password Baru
          </button>
          <a href="index.php" class="btn btn-light border rounded-3 px-3 py-2 fw-semibold">
            Batal
          </a>
        </div>
      </form>
    </div>
  </div>

  <!-- Kolom Info Akun & Tips Keamanan -->
  <div class="col-lg-5 col-xl-5">
    <!-- Card Info Akun -->
    <div class="card border-0 shadow-sm rounded-4 bg-white p-4 mb-4">
      <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
        <i class="bi bi-person-badge text-danger"></i> Informasi Akun
      </h6>
      <ul class="list-group list-group-flush small">
        <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
          <span class="text-muted">Username</span>
          <span class="badge bg-secondary-subtle text-secondary font-monospace"><?= e($admin['username']) ?></span>
        </li>
        <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
          <span class="text-muted">Role / Peran</span>
          <span class="badge bg-danger-subtle text-danger fw-semibold"><?= e(ucfirst($admin['role'] ?? 'admin')) ?></span>
        </li>
        <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
          <span class="text-muted">Terdaftar Sejak</span>
          <span class="fw-semibold text-dark"><?= format_tanggal_id($admin['created_at'] ?? '', true) ?></span>
        </li>
      </ul>
    </div>

    <!-- Card Tips Keamanan -->
    <div class="card border-0 shadow-sm rounded-4 bg-light border-start border-4 border-warning p-4">
      <h6 class="fw-bold text-dark mb-2 d-flex align-items-center gap-2">
        <i class="bi bi-lightbulb-fill text-warning"></i> Tips Keamanan Password
      </h6>
      <ul class="text-muted small ps-3 mb-0" style="line-height: 1.7;">
        <li>Gunakan minimal <strong>6 karakter</strong> atau lebih.</li>
        <li>Kombinasikan <strong>huruf besar, huruf kecil, angka, dan simbol</strong> agar tidak mudah ditebak.</li>
        <li>Hindari menggunakan tanggal lahir, nomor telepon, atau data pribadi yang mudah diketahui.</li>
        <li>Jangan membagikan kata sandi administrator kepada pihak yang tidak berwenang.</li>
        <li>Perbarui kata sandi secara berkala untuk menjaga keamanan data aspirasi warga.</li>
      </ul>
    </div>
  </div>
</div>

<!-- Script Toggle Show / Hide Password -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  var toggleButtons = document.querySelectorAll('.toggle-password');
  toggleButtons.forEach(function(btn) {
    btn.addEventListener('click', function() {
      var targetId = this.getAttribute('data-target');
      var input = document.getElementById(targetId);
      var icon = this.querySelector('i');
      if (input) {
        if (input.type === 'password') {
          input.type = 'text';
          icon.classList.remove('bi-eye');
          icon.classList.add('bi-eye-slash');
        } else {
          input.type = 'password';
          icon.classList.remove('bi-eye-slash');
          icon.classList.add('bi-eye');
        }
      }
    });
  });
});
</script>

<?php require_once __DIR__ . '/footer_admin.php'; ?>
