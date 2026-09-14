<?php
/**
 * Konfigurasi Sistem Website & Sapa Warga
 * Calon Kepala Desa Tampirkulon - Edy Susanto (No. Urut 2)
 */

// Mulai sesi aman jika belum aktif
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_samesite', 'Lax');
    session_start();
}

// Pengaturan Database XAMPP Default
define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3306');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'edy_susanto');

// Konstanta Aplikasi & Kampanye
define('APP_NAME', 'EDY SUSANTO');
define('APP_TITLE', 'Calon Kepala Desa Tampirkulon');
define('NO_URUT', '2');
define('TAGLINE', 'Bersama Membangun Desa yang Asri, Maju & Rukun');
define('SLOGAN_QUOTE', 'Desa kuat karena warganya.');
define('WHATSAPP_NUMBER', '6281234567890');
define('EMAIL_DESA', 'edysusanto@tampirkulon.id');
define('ALAMAT_DESA', 'Jl. Tampir II, Tampirkulon, Kec. Candimulyo, Kab. Magelang');

// Daftar Dusun Resmi Tampirkulon
$DUSUN_LIST = [
    'Dusun Tampir',
    'Dusun Beji',
    'Dusun Ceme',
    'Dusun Dukunan',
    'Dusun Bugel',
    'Dusun Dongkelan'
];

// Daftar Kategori Aspirasi
$KATEGORI_ASPIRASI = [
    'Infrastruktur',
    'Ekonomi',
    'Pendidikan',
    'Lingkungan',
    'Pemuda',
    'Pelayanan',
    'Lainnya'
];

// Inisialisasi Koneksi Database dengan Auto-Recovery / Auto-Schema
try {
    // Coba konek ke database
    $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    // Jika database belum ada, buat otomatis
    try {
        $rootPdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";charset=utf8mb4", DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        $rootPdo->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        
        // Baca dan jalankan database.sql
        $sqlFile = __DIR__ . '/../database.sql';
        if (file_exists($sqlFile)) {
            $sqlContent = file_get_contents($sqlFile);
            $pdo->exec($sqlContent);
        }
    } catch (PDOException $ex) {
        die("Koneksi Database Gagal: " . htmlspecialchars($ex->getMessage()));
    }
}
