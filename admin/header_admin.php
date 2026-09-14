<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

require_admin_auth();

$adminCurrentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - Tampirkulon (Edy Susanto)</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: #f8fafc;
      color: #1e293b;
    }
    .admin-sidebar {
      width: 260px;
      min-height: 100vh;
      background-color: #0f172a;
      color: #cbd5e1;
    }
    .admin-sidebar .nav-link {
      color: #94a3b8;
      border-radius: 10px;
      padding: 0.65rem 1rem;
      margin-bottom: 0.35rem;
      font-weight: 500;
      transition: all 0.2s;
    }
    .admin-sidebar .nav-link:hover, .admin-sidebar .nav-link.active {
      color: #fff;
      background-color: #1e293b;
    }
    .admin-sidebar .nav-link.active {
      background-color: #b71c1c;
      font-weight: 700;
    }
    .admin-content {
      flex: 1;
      padding: 2rem;
      overflow-y: auto;
    }
    .badge-no {
      width: 32px;
      height: 32px;
      background-color: #b71c1c;
      color: #fff;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-weight: 800;
    }
  </style>
</head>
<body>

<div class="d-flex flex-column flex-md-row min-vh-100">
  <!-- Sidebar -->
  <aside class="admin-sidebar p-3 d-flex flex-column">
    <div class="d-flex align-items-center gap-2 mb-4 pb-3 border-bottom border-secondary border-opacity-25 px-2">
      <span class="badge-no">2</span>
      <div>
        <h6 class="text-white mb-0 fw-bold">Admin Tampirkulon</h6>
        <small class="text-secondary" style="font-size: 0.75rem;">Edy Susanto (No. Urut 2)</small>
      </div>
    </div>

    <ul class="nav flex-column mb-auto">
      <li class="nav-item">
        <a href="index.php" class="nav-link <?= ($adminCurrentPage === 'index.php') ? 'active' : '' ?>">
          <i class="bi bi-speedometer2 me-2"></i> Dashboard
        </a>
      </li>
      <li class="nav-item">
        <a href="data_aspirasi.php" class="nav-link <?= ($adminCurrentPage === 'data_aspirasi.php') ? 'active' : '' ?>">
          <i class="bi bi-chat-dots-fill me-2"></i> Kelola Aspirasi
        </a>
      </li>
      <li class="nav-item">
        <a href="data_program.php" class="nav-link <?= ($adminCurrentPage === 'data_program.php') ? 'active' : '' ?>">
          <i class="bi bi-grid-fill me-2"></i> 7 Program Kerja
        </a>
      </li>
      <li class="nav-item">
        <a href="data_berita.php" class="nav-link <?= ($adminCurrentPage === 'data_berita.php') ? 'active' : '' ?>">
          <i class="bi bi-newspaper me-2"></i> Berita &amp; Kegiatan
        </a>
      </li>
      <li class="nav-item">
        <a href="data_galeri.php" class="nav-link <?= ($adminCurrentPage === 'data_galeri.php') ? 'active' : '' ?>">
          <i class="bi bi-images me-2"></i> Galeri &amp; Foto
        </a>
      </li>
      <li class="nav-item">
        <a href="pengaturan.php" class="nav-link <?= ($adminCurrentPage === 'pengaturan.php') ? 'active' : '' ?>">
          <i class="bi bi-sliders me-2"></i> Pengaturan &amp; Foto Hero
        </a>
      </li>
    </ul>

    <hr class="border-secondary border-opacity-25 my-3">

    <div class="px-2 mb-2">
      <div class="small text-secondary mb-1">Masuk sebagai:</div>
      <div class="fw-bold text-white small"><?= e($_SESSION['admin_nama'] ?? 'Admin') ?></div>
    </div>

    <div class="d-grid gap-2">
      <a href="../index.php" target="_blank" class="btn btn-sm btn-outline-light rounded-3">
        <i class="bi bi-box-arrow-up-right me-1"></i> Lihat Website
      </a>
      <a href="logout.php" class="btn btn-sm btn-danger rounded-3" onclick="return confirm('Apakah Anda yakin ingin keluar?');">
        <i class="bi bi-box-arrow-right me-1"></i> Keluar
      </a>
    </div>
  </aside>

  <!-- Content Area -->
  <main class="admin-content">
    <?= render_flash() ?>
