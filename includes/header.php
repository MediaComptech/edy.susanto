<?php
if (!defined('APP_NAME')) {
    require_once __DIR__ . '/config.php';
}
require_once __DIR__ . '/functions.php';

$currentPage = $_GET['page'] ?? 'beranda';
$pageTitles = [
    'beranda' => 'Beranda - Bersama Membangun Desa Tampirkulon yang Asri, Maju & Rukun',
    'profil' => 'Profil & Visi Misi - Edy Susanto (No. Urut 2)',
    'program' => '7 Program Unggulan - Edy Susanto Calon Kades Tampirkulon',
    'potensi' => 'Potensi Desa & Wisata Tubing Tampirkulon',
    'sapa-warga' => 'Sapa Warga - Kanal Aspirasi & Solusi Bersama Warga Tampirkulon',
    'berita' => 'Berita & Kegiatan Kampanye - Edy Susanto',
    'kontak' => 'Kontak & Informasi - Posko Pemenangan Edy Susanto'
];
$metaTitle = ($pageTitles[$currentPage] ?? APP_NAME . ' - ' . APP_TITLE) . ' | No. Urut ' . NO_URUT;
$metaDesc = 'Website Resmi Edy Susanto (No. Urut 2) Calon Kepala Desa Tampirkulon, Kec. Candimulyo, Kab. Magelang. Bersama Membangun Desa yang Asri, Maju, dan Rukun.';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?= e($metaTitle) ?></title>
  
  <!-- SEO & Social Media Meta Tags -->
  <meta name="description" content="<?= e($metaDesc) ?>">
  <meta name="author" content="Edy Susanto - Calon Kepala Desa Tampirkulon No. Urut 2">
  <meta property="og:title" content="<?= e($metaTitle) ?>">
  <meta property="og:description" content="<?= e($metaDesc) ?>">
  <meta property="og:image" content="assets/images/banner/edy_susanto_hero.jpg">
  <meta property="og:type" content="website">
  
  <!-- PWA Settings -->
  <link rel="manifest" href="manifest.json">
  <meta name="theme-color" content="#b71c1c">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <meta name="apple-mobile-web-app-title" content="Sapa Warga">
  <link rel="apple-touch-icon" href="assets/images/icons/icon-192.png">
  <link rel="shortcut icon" href="assets/images/logo/logo_no2.png" type="image/png">
  
  <!-- Google Fonts: Plus Jakarta Sans & Caveat -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  
  <!-- Bootstrap 5 CSS & Bootstrap Icons & Font Awesome -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  
  <!-- Custom CSS with Auto Cache-Busting -->
  <link rel="stylesheet" href="assets/css/style.css?v=<?= file_exists(__DIR__ . '/../assets/css/style.css') ? filemtime(__DIR__ . '/../assets/css/style.css') : '20260914' ?>">
</head>
<body>
