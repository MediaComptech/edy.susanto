<?php
/**
 * Front Controller Utama Website & Sapa Warga
 * Calon Kepala Desa Tampirkulon - Edy Susanto (No. Urut 2)
 */

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

// Whitelist halaman yang diizinkan untuk keamanan
$allowedPages = [
    'beranda'    => 'pages/beranda.php',
    'profil'     => 'pages/profil.php',
    'program'    => 'pages/program.php',
    'potensi'    => 'pages/potensi.php',
    'sapa-warga' => 'pages/sapa-warga.php',
    'berita'     => 'pages/berita.php',
    'kontak'     => 'pages/kontak.php'
];

$page = $_GET['page'] ?? 'beranda';
if (!array_key_exists($page, $allowedPages)) {
    $page = 'beranda';
}

// Catat statistik pengunjung publik (ringan & otomatis)
catat_kunjungan($pdo, $page);

$pageFile = __DIR__ . '/' . $allowedPages[$page];

// Render Komponen Terintegrasi
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';

if (file_exists($pageFile)) {
    require_once $pageFile;
} else {
    echo '<div class="container py-5 text-center"><h2>Halaman tidak ditemukan.</h2><a href="index.php?page=beranda" class="btn btn-danger mt-3">Kembali ke Beranda</a></div>';
}

require_once __DIR__ . '/includes/footer.php';
