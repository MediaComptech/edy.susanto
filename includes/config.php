<?php
/**
 * Konfigurasi Sistem Website & Sapa Warga
 * Calon Kepala Desa Tampirkulon - Edy Susanto (No. Urut 2)
 */

// Mulai output buffering global untuk mencegah error "headers already sent"
if (ob_get_level() === 0) {
    ob_start();
}

// Mulai sesi aman jika belum aktif
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_samesite', 'Lax');
    session_start();
}

// Deteksi Lingkungan Host (Localhost vs Live Hosting edysusanto.info)
$httpHost = $_SERVER['HTTP_HOST'] ?? '';
$hostName = explode(':', $httpHost)[0];
$isLocalhost = in_array($hostName, ['localhost', '127.0.0.1']) || (php_sapi_name() === 'cli' && empty($httpHost));

if ($isLocalhost) {
    // Pengaturan Database XAMPP Lokal
    define('DB_HOST', '127.0.0.1');
    define('DB_PORT', '3306');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'edy_susanto');
} else {
    // Pengaturan Database Live Hosting (cPanel / edysusanto.info)
    // Sesuaikan dengan data database yang dibuat di cPanel MySQL Databases
    define('DB_HOST', 'localhost');
    define('DB_PORT', '3306');
    define('DB_USER', getenv('DB_USER') ?: 'medh1179_edysusanto');
    define('DB_PASS', getenv('DB_PASS') ?: 'GithubDeploy2026!');
    define('DB_NAME', getenv('DB_NAME') ?: 'medh1179_edy_susanto');
}

// Base URL & Protokol Dinamis Otomatis sesuai domain
$isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') 
        || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)
        || (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
$protocol = $isHttps ? 'https://' : 'http://';
$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
$baseDir = ($scriptDir === '/' || $scriptDir === '.') ? '' : rtrim($scriptDir, '/');
if (substr($baseDir, -6) === '/admin') {
    $baseDir = substr($baseDir, 0, -6);
}
define('BASE_URL', $protocol . ($httpHost ?: 'edysusanto.info') . $baseDir);

// Konstanta Aplikasi & Kampanye
define('APP_NAME', 'EDY SUSANTO');
define('APP_TITLE', 'Calon Kepala Desa Tampirkulon');
define('NO_URUT', '2');
define('TAGLINE', 'Bersama Membangun Desa yang Asri, Maju & Rukun');
define('SLOGAN_QUOTE', 'Desa kuat karena warganya.');
define('WHATSAPP_NUMBER', '6281234567890');
define('EMAIL_DESA', 'mail@edysusanto.info');
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
    // Jika di localhost dan database belum ada, coba buat otomatis
    if ($isLocalhost) {
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
    } else {
        // Panduan jika koneksi database di hosting belum siap
        die("<div style='font-family:Segoe UI,Roboto,sans-serif;padding:30px;max-width:640px;margin:50px auto;border:1px solid #e0e0e0;border-radius:16px;background:#fff;box-shadow:0 10px 30px rgba(0,0,0,0.08);'>
            <div style='color:#dc3545;font-size:1.5rem;font-weight:bold;margin-bottom:12px;'>⚠️ Pengaturan Database Hosting</div>
            <p style='color:#555;line-height:1.6;'>Aplikasi belum dapat terhubung ke database MySQL hosting: <br><strong style='color:#dc3545;'>" . htmlspecialchars($e->getMessage()) . "</strong></p>
            <div style='background:#f8f9fa;padding:16px;border-radius:10px;border-left:4px solid #dc3545;margin-bottom:16px;'>
                <div style='font-weight:600;margin-bottom:8px;color:#333;'>Langkah Mudah Pengaturan di cPanel:</div>
                <ol style='margin:0;padding-left:20px;color:#555;font-size:0.95rem;line-height:1.7;'>
                    <li>Buka <strong>cPanel &rarr; MySQL&reg; Databases</strong>.</li>
                    <li>Buat database baru (misal: <code>medh1179_edysusanto</code>).</li>
                    <li>Buat user database baru dan atur password.</li>
                    <li>Tambahkan user tersebut ke database dengan hak akses <strong>ALL PRIVILEGES</strong>.</li>
                    <li>Buka File Manager, edit <code>includes/config.php</code> dan sesuaikan <code>DB_NAME</code>, <code>DB_USER</code>, dan <code>DB_PASS</code>.</li>
                    <li>Buka <strong>phpMyAdmin</strong> dan impor file <code>database.sql</code>.</li>
                </ol>
            </div>
            <div style='color:#888;font-size:0.85rem;'>Domain aktif: <code>" . htmlspecialchars($httpHost) . "</code></div>
        </div>");
    }
}

