<?php
/**
 * Login Administrator
 * Calon Kepala Desa Tampirkulon - Edy Susanto (No. Urut 2)
 */

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

// Jika sudah login, langsung ke dashboard
if (is_admin_logged_in()) {
    header("Location: index.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf()) {
        $error = 'Validasi sesi CSRF gagal. Silakan coba lagi.';
    } else {
        $username = sanitize($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            $error = 'Username dan password wajib diisi.';
        } else {
            $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ? LIMIT 1");
            $stmt->execute([$username]);
            $admin = $stmt->fetch();

            if ($admin && password_verify($password, $admin['password'])) {
                // Regenerate session id untuk mencegah session fixation
                session_regenerate_id(true);
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_username'] = $admin['username'];
                $_SESSION['admin_nama'] = $admin['nama'];
                $_SESSION['admin_role'] = $admin['role'];

                header("Location: index.php");
                exit;
            } else {
                $error = 'Username atau password yang Anda masukkan salah.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Administrator - Tampirkulon</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: linear-gradient(135deg, #f8fafc 0%, #ffebee 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1rem;
    }
    .card-login {
      width: 100%;
      max-width: 420px;
      border: none;
      border-radius: 20px;
      box-shadow: 0 14px 34px rgba(0, 0, 0, 0.08);
      overflow: hidden;
      background: #fff;
    }
    .badge-no-urut {
      width: 44px;
      height: 44px;
      background-color: #b71c1c;
      color: #fff;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-weight: 800;
      font-size: 1.4rem;
    }
  </style>
</head>
<body>

<div class="card card-login p-4 p-md-5">
  <div class="text-center mb-4">
    <div class="d-flex justify-content-center mb-2">
      <span class="badge-no-urut">2</span>
    </div>
    <h4 class="fw-bold text-dark mb-1">Portal Administrator</h4>
    <small class="text-muted">Sistem Manajemen Website &amp; Sapa Warga</small>
  </div>

  <?php if (!empty($error)): ?>
  <div class="alert alert-danger py-2 small d-flex align-items-center" role="alert">
    <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
    <div><?= e($error) ?></div>
  </div>
  <?php endif; ?>

  <form action="login.php" method="POST">
    <?= csrf_field() ?>

    <div class="mb-3">
      <label class="form-label small fw-semibold">Username</label>
      <div class="input-group">
        <span class="input-group-text bg-light"><i class="bi bi-person text-muted"></i></span>
        <input type="text" class="form-control" name="username" placeholder="Masukkan username" required autofocus>
      </div>
    </div>

    <div class="mb-4">
      <label class="form-label small fw-semibold">Password</label>
      <div class="input-group">
        <span class="input-group-text bg-light"><i class="bi bi-lock text-muted"></i></span>
        <input type="password" class="form-control" name="password" placeholder="Masukkan password" required>
      </div>
    </div>

    <button type="submit" class="btn btn-danger w-100 py-2 fw-bold rounded-3 shadow-sm mb-3">
      <i class="bi bi-box-arrow-in-right me-1"></i> Masuk ke Dashboard
    </button>

    <div class="text-center">
      <a href="../index.php" class="text-secondary small text-decoration-none">&larr; Kembali ke Website Publik</a>
    </div>
  </form>

  <div class="mt-4 p-2 bg-light rounded text-center small text-muted">
    Default Akses: <strong>admin</strong> / <strong>admin123</strong>
  </div>
</div>

</body>
</html>
