<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

require_admin_auth();

// Handle POST updates (Diproses sebelum render HTML)
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['action'])) {
    if (verify_csrf()) {
        if ($_POST['action'] === 'ganti_foto_hero') {
            if (!empty($_FILES['foto_hero_baru']['name'])) {
                $upload = handle_file_upload($_FILES['foto_hero_baru'], 'uploads', 5);
                if ($upload['status']) {
                    set_pengaturan($pdo, 'foto_hero', $upload['relative_path'], 'Foto utama kandidat di Hero Section Beranda');
                    set_flash('success', 'Foto Hero Beranda berhasil diperbarui dan diterapkan ke website utama!');
                } else {
                    set_flash('danger', $upload['error']);
                }
            } else {
                set_flash('warning', 'Pilih berkas foto terlebih dahulu.');
            }
            safe_redirect("pengaturan.php");
        } elseif ($_POST['action'] === 'reset_foto_hero') {
            set_pengaturan($pdo, 'foto_hero', 'assets/images/banner/edy_susanto_hero_clean.jpg', 'Foto bawaan kandidat');
            set_flash('success', 'Foto Hero berhasil dikembalikan ke foto bawaan (default).');
            safe_redirect("pengaturan.php");
        } elseif ($_POST['action'] === 'ganti_bg_hero') {
            if (!empty($_FILES['bg_hero_baru']['name'])) {
                $upload = handle_file_upload($_FILES['bg_hero_baru'], 'uploads', 10);
                if ($upload['status']) {
                    set_pengaturan($pdo, 'bg_hero', $upload['relative_path'], 'Background landscape Hero Section Beranda');
                    set_flash('success', 'Background Hero berhasil diperbarui!');
                } else {
                    set_flash('danger', $upload['error']);
                }
            } else {
                set_flash('warning', 'Pilih berkas gambar background terlebih dahulu.');
            }
            safe_redirect("pengaturan.php");
        } elseif ($_POST['action'] === 'reset_bg_hero') {
            set_pengaturan($pdo, 'bg_hero', 'assets/images/banner/hero_bg_pure_landscape.jpg', 'Background landscape bawaan');
            set_flash('success', 'Background Hero dikembalikan ke landscape bawaan.');
            safe_redirect("pengaturan.php");
        } elseif ($_POST['action'] === 'simpan_teks_kampanye') {
            $nama = sanitize($_POST['nama_calon'] ?? 'EDY SUSANTO');
            $noUrut = sanitize($_POST['no_urut'] ?? '2');
            $tagline = sanitize($_POST['tagline'] ?? '');
            $quote = sanitize($_POST['slogan_quote'] ?? '');

            set_pengaturan($pdo, 'nama_calon', $nama);
            set_pengaturan($pdo, 'no_urut', $noUrut);
            set_pengaturan($pdo, 'tagline', $tagline);
            set_pengaturan($pdo, 'slogan_quote', $quote);

            set_flash('success', 'Teks dan informasi kampanye berhasil disimpan.');
            safe_redirect("pengaturan.php");
        } elseif ($_POST['action'] === 'ganti_foto_profil') {
            if (!empty($_FILES['foto_profil_baru']['name'])) {
                $upload = handle_file_upload($_FILES['foto_profil_baru'], 'uploads', 5);
                if ($upload['status']) {
                    set_pengaturan($pdo, 'foto_profil', $upload['relative_path'], 'Foto profil calon di Halaman Profil');
                    set_flash('success', 'Foto profil calon berhasil diperbarui!');
                } else {
                    set_flash('danger', $upload['error']);
                }
            } else {
                set_flash('warning', 'Pilih berkas foto profil terlebih dahulu.');
            }
            safe_redirect("pengaturan.php");
        } elseif ($_POST['action'] === 'reset_foto_profil') {
            set_pengaturan($pdo, 'foto_profil', 'assets/images/banner/edy_susanto_hero.jpg', 'Foto profil bawaan');
            set_flash('success', 'Foto profil dikembalikan ke foto bawaan.');
            safe_redirect("pengaturan.php");
        } elseif ($_POST['action'] === 'simpan_konten_profil') {
            $status   = sanitize($_POST['profil_status'] ?? 'Purnawirawan TNI AD');
            $asal     = sanitize($_POST['profil_asal'] ?? 'Putra Asli Tampirkulon');
            $judul    = sanitize($_POST['profil_judul_dedikasi'] ?? 'Integritas & Kedisiplinan Prajurit, Mengabdi Sepenuh Hati untuk Warga');
            $bio1     = sanitize($_POST['profil_biodata_1'] ?? '');
            $bio2     = sanitize($_POST['profil_biodata_2'] ?? '');
            $nilai    = sanitize($_POST['profil_nilai_kepemimpinan'] ?? '');
            $komitmen = sanitize($_POST['profil_komitmen_pengabdian'] ?? '');

            $pilar1Judul = sanitize($_POST['profil_pilar1_judul'] ?? 'Disiplin Tinggi & Integritas');
            $pilar1Sub   = sanitize($_POST['profil_pilar1_sub'] ?? '');
            $pilar2Judul = sanitize($_POST['profil_pilar2_judul'] ?? 'Tata Kelola Keuangan Akuntabel');
            $pilar2Sub   = sanitize($_POST['profil_pilar2_sub'] ?? '');
            $pilar3Judul = sanitize($_POST['profil_pilar3_judul'] ?? 'Distribusi Kebutuhan Presisi');
            $pilar3Sub   = sanitize($_POST['profil_pilar3_sub'] ?? '');

            set_pengaturan($pdo, 'profil_status', $status);
            set_pengaturan($pdo, 'profil_asal', $asal);
            set_pengaturan($pdo, 'profil_judul_dedikasi', $judul);
            set_pengaturan($pdo, 'profil_biodata_1', $bio1);
            set_pengaturan($pdo, 'profil_biodata_2', $bio2);
            set_pengaturan($pdo, 'profil_nilai_kepemimpinan', $nilai);
            set_pengaturan($pdo, 'profil_komitmen_pengabdian', $komitmen);

            set_pengaturan($pdo, 'profil_pilar1_judul', $pilar1Judul);
            set_pengaturan($pdo, 'profil_pilar1_sub', $pilar1Sub);
            set_pengaturan($pdo, 'profil_pilar2_judul', $pilar2Judul);
            set_pengaturan($pdo, 'profil_pilar2_sub', $pilar2Sub);
            set_pengaturan($pdo, 'profil_pilar3_judul', $pilar3Judul);
            set_pengaturan($pdo, 'profil_pilar3_sub', $pilar3Sub);

            set_flash('success', 'Konten data diri, biodata & 3 pilar keahlian Halaman Profil berhasil disimpan!');
            safe_redirect("pengaturan.php");
        } elseif ($_POST['action'] === 'ganti_foto_sapa_warga') {
            if (!empty($_FILES['foto_sapa_baru']['name'])) {
                $upload = handle_file_upload($_FILES['foto_sapa_baru'], 'uploads', 5);
                if ($upload['status']) {
                    set_pengaturan($pdo, 'foto_sapa_warga', $upload['relative_path'], 'Foto thumbnail kutipan hero Sapa Warga');
                    set_flash('success', 'Foto Sapa Warga berhasil diperbarui!');
                } else {
                    set_flash('danger', $upload['error']);
                }
            } else {
                set_flash('warning', 'Pilih berkas foto terlebih dahulu.');
            }
            safe_redirect("pengaturan.php");
        } elseif ($_POST['action'] === 'reset_foto_sapa_warga') {
            set_pengaturan($pdo, 'foto_sapa_warga', 'assets/images/banner/dialog_warga.jpg', 'Foto bawaan dialog warga');
            set_flash('success', 'Foto Sapa Warga dikembalikan ke foto bawaan.');
            safe_redirect("pengaturan.php");
        } elseif ($_POST['action'] === 'simpan_quote_sapa_warga') {
            $quote = sanitize($_POST['quote_sapa_warga'] ?? '');
            set_pengaturan($pdo, 'quote_sapa_warga', $quote, 'Teks kutipan di kartu hero Sapa Warga');
            set_flash('success', 'Kutipan Sapa Warga berhasil disimpan!');
            safe_redirect("pengaturan.php");
        } elseif ($_POST['action'] === 'simpan_dusun') {
            // Proses daftar dusun yang dikirim
            $dusunRaw = $_POST['dusun'] ?? [];
            $dusunBersih = [];
            foreach ($dusunRaw as $d) {
                $d = trim(sanitize($d));
                if ($d !== '') {
                    $dusunBersih[] = $d;
                }
            }
            if (count($dusunBersih) < 1) {
                set_flash('warning', 'Minimal harus ada 1 nama dusun.');
            } else {
                set_pengaturan($pdo, 'dusun_list', json_encode($dusunBersih, JSON_UNESCAPED_UNICODE), 'Daftar nama dusun resmi Tampirkulon');
                set_flash('success', 'Daftar nama dusun berhasil diperbarui (' . count($dusunBersih) . ' dusun).');
            }
            safe_redirect("pengaturan.php");
        } elseif ($_POST['action'] === 'ganti_foto_hero_potensi') {
            if (!empty($_FILES['foto_hero_potensi_baru']['name'])) {
                $upload = handle_file_upload($_FILES['foto_hero_potensi_baru'], 'uploads', 10);
                if ($upload['status']) {
                    set_pengaturan($pdo, 'foto_hero_potensi', $upload['relative_path'], 'Foto background Hero Halaman Potensi Desa');
                    set_flash('success', 'Foto Hero Potensi Desa berhasil diperbarui!');
                } else {
                    set_flash('danger', $upload['error']);
                }
            } else {
                set_flash('warning', 'Pilih berkas foto terlebih dahulu.');
            }
            safe_redirect("pengaturan.php");
        } elseif ($_POST['action'] === 'reset_foto_hero_potensi') {
            set_pengaturan($pdo, 'foto_hero_potensi', 'assets/images/potensi/kolam_ngudal_tuk_putri.jpg', 'Foto bawaan Kolam Ngudal Tuk Putri');
            set_flash('success', 'Foto Hero Potensi dikembalikan ke foto bawaan.');
            safe_redirect("pengaturan.php");
        } elseif ($_POST['action'] === 'ganti_foto_spot_potensi') {
            if (!empty($_FILES['foto_spot_potensi_baru']['name'])) {
                $upload = handle_file_upload($_FILES['foto_spot_potensi_baru'], 'uploads', 10);
                if ($upload['status']) {
                    set_pengaturan($pdo, 'foto_spot_potensi', $upload['relative_path'], 'Foto Spot Unggulan di Halaman Potensi Desa');
                    set_flash('success', 'Foto Spot Unggulan Potensi berhasil diperbarui!');
                } else {
                    set_flash('danger', $upload['error']);
                }
            } else {
                set_flash('warning', 'Pilih berkas foto terlebih dahulu.');
            }
            safe_redirect("pengaturan.php");
        } elseif ($_POST['action'] === 'reset_foto_spot_potensi') {
            set_pengaturan($pdo, 'foto_spot_potensi', 'assets/images/potensi/kolam_ngudal_tuk_putri.jpg', 'Foto bawaan Spot Tuk Putri');
            set_flash('success', 'Foto Spot Potensi dikembalikan ke foto bawaan.');
            safe_redirect("pengaturan.php");
        } elseif ($_POST['action'] === 'simpan_konten_potensi') {
            $judul    = sanitize($_POST['spot_potensi_judul'] ?? 'Kolam Ngudal Tuk Putri');
            $desc     = sanitize($_POST['spot_potensi_desc'] ?? '');
            $jarak    = sanitize($_POST['spot_potensi_jarak'] ?? '± 0,34 km dari Balai Desa Tampirkulon');
            $lokasi   = sanitize($_POST['spot_potensi_lokasi'] ?? 'Tampirkulon, Candimulyo, Magelang');
            $heroJudul = sanitize($_POST['hero_potensi_judul'] ?? 'Kekayaan Desa,<br>Kekuatan Bersama');
            $heroSub  = sanitize($_POST['hero_potensi_sub'] ?? '');

            set_pengaturan($pdo, 'spot_potensi_judul',  $judul,    'Judul Spot Unggulan Halaman Potensi');
            set_pengaturan($pdo, 'spot_potensi_desc',   $desc,     'Deskripsi Spot Unggulan Halaman Potensi');
            set_pengaturan($pdo, 'spot_potensi_jarak',  $jarak,    'Jarak Spot Unggulan dari Balai Desa');
            set_pengaturan($pdo, 'spot_potensi_lokasi', $lokasi,   'Lokasi Spot Unggulan Halaman Potensi');
            set_pengaturan($pdo, 'hero_potensi_judul',  $heroJudul,'Judul Hero Halaman Potensi Desa');
            set_pengaturan($pdo, 'hero_potensi_sub',    $heroSub,  'Subtitle Hero Halaman Potensi Desa');

            set_flash('success', 'Konten teks Halaman Potensi Desa berhasil disimpan!');
            safe_redirect("pengaturan.php");
        } elseif ($_POST['action'] === 'ganti_foto_potensi_beranda') {
            if (!empty($_FILES['foto_potensi_beranda_baru']['name'])) {
                $upload = handle_file_upload($_FILES['foto_potensi_beranda_baru'], 'uploads', 10);
                if ($upload['status']) {
                    set_pengaturan($pdo, 'foto_potensi_beranda', $upload['relative_path'], 'Foto kartu sorotan potensi di Beranda');
                    set_flash('success', 'Foto kartu sorotan potensi di Beranda berhasil diperbarui!');
                } else {
                    set_flash('danger', $upload['error']);
                }
            } else {
                set_flash('warning', 'Pilih berkas foto terlebih dahulu.');
            }
            safe_redirect("pengaturan.php");
        } elseif ($_POST['action'] === 'sinkron_foto_potensi_beranda') {
            $sumber = sanitize($_POST['sumber_foto'] ?? 'spot');
            if ($sumber === 'hero') {
                $fotoSumber = get_pengaturan($pdo, 'foto_hero_potensi', 'assets/images/potensi/kolam_ngudal_tuk_putri.jpg');
                set_pengaturan($pdo, 'foto_potensi_beranda', $fotoSumber, 'Foto kartu sorotan potensi di Beranda (diselaraskan dari Hero Potensi)');
                set_flash('success', 'Foto kartu beranda berhasil diselaraskan dengan Foto Hero Halaman Potensi!');
            } else {
                $fotoSumber = get_pengaturan($pdo, 'foto_spot_potensi', 'assets/images/potensi/kolam_ngudal_tuk_putri.jpg');
                set_pengaturan($pdo, 'foto_potensi_beranda', $fotoSumber, 'Foto kartu sorotan potensi di Beranda (diselaraskan dari Spot Tuk Putri)');
                set_flash('success', 'Foto kartu beranda berhasil diselaraskan dengan Foto Spot Tuk Putri Halaman Potensi!');
            }
            safe_redirect("pengaturan.php");
        } elseif ($_POST['action'] === 'reset_foto_potensi_beranda') {
            set_pengaturan($pdo, 'foto_potensi_beranda', 'assets/images/galeri/wisata_tubing.jpg', 'Foto bawaan kartu potensi beranda');
            set_flash('success', 'Foto kartu potensi beranda dikembalikan ke foto bawaan (Wisata Tubing).');
            safe_redirect("pengaturan.php");
        } elseif ($_POST['action'] === 'simpan_teks_potensi_beranda') {
            $judul = sanitize($_POST['judul_potensi_beranda'] ?? 'Wisata Tubing Tampirkulon');
            $sub   = sanitize($_POST['sub_potensi_beranda'] ?? 'Salah satu potensi unggulan desa');
            $link  = sanitize($_POST['link_potensi_beranda'] ?? 'index.php?page=potensi');

            set_pengaturan($pdo, 'judul_potensi_beranda', $judul, 'Judul kartu sorotan potensi di Beranda');
            set_pengaturan($pdo, 'sub_potensi_beranda',   $sub,   'Subtitle kartu sorotan potensi di Beranda');
            set_pengaturan($pdo, 'link_potensi_beranda',  $link,  'Link kartu sorotan potensi di Beranda');

            set_flash('success', 'Teks dan tautan kartu sorotan potensi di Beranda berhasil disimpan!');
            safe_redirect("pengaturan.php");
        }
    } else {
        set_flash('danger', 'Validasi sesi CSRF gagal.');
    }
}

// Ambil data pengaturan saat ini
$fotoHero   = get_pengaturan($pdo, 'foto_hero', 'assets/images/banner/edy_susanto_hero_clean.jpg');
$bgHero     = get_pengaturan($pdo, 'bg_hero', 'assets/images/banner/hero_bg_pure_landscape.jpg');
$namaCalon  = get_pengaturan($pdo, 'nama_calon', APP_NAME);
$noUrut     = get_pengaturan($pdo, 'no_urut', NO_URUT);
$tagline    = get_pengaturan($pdo, 'tagline', TAGLINE);
$sloganQuote = get_pengaturan($pdo, 'slogan_quote', SLOGAN_QUOTE);

// Ambil data halaman profil calon
$fotoProfil         = get_pengaturan($pdo, 'foto_profil', 'assets/images/banner/edy_susanto_hero.jpg');
$profilRawAsal      = get_pengaturan($pdo, 'profil_asal', 'Putra Asli Tampirkulon');
if (strpos($profilRawAsal, '•') !== false) {
    $parts = explode('•', $profilRawAsal, 2);
    $profilStatus = trim($parts[0]);
    $profilAsal   = trim($parts[1]);
} else {
    $profilStatus = get_pengaturan($pdo, 'profil_status', 'Purnawirawan TNI AD');
    $profilAsal   = $profilRawAsal;
}
$judulDedikasi      = get_pengaturan($pdo, 'profil_judul_dedikasi', 'Integritas & Kedisiplinan Prajurit, Mengabdi Sepenuh Hati untuk Warga');
$biodata1           = get_pengaturan($pdo, 'profil_biodata_1', 'Sebagai putra asli Tampirkulon dan Purnawirawan TNI AD, ' . $namaCalon . ' dibentuk oleh kedisiplinan tinggi, loyalitas tanpa pamrih kepada masyarakat, serta ketegasan sikap yang senantiasa mengayomi. Beliau memahami secara mendalam denyut kehidupan warga, potensi agraris yang melimpah, serta harapan besar pemuda dan keluarga di setiap dusun.');
$biodata2           = get_pengaturan($pdo, 'profil_biodata_2', 'Berbekal pengalaman kepemimpinan kedinasan, keahlian tata kelola administrasi keuangan yang akuntabel, serta manajemen rantai pasok dan distribusi kebutuhan personil secara presisi, beliau hadir membawa tekad mengabdi seutuhnya demi terciptanya pemerintahan desa yang bersih, transparan, anti-bocor, dan melayani.');
$nilaiKepemimpinan  = get_pengaturan($pdo, 'profil_nilai_kepemimpinan', 'Disiplin prajurit yang humanis, transparansi anggaran 100% tanpa celah kebocoran, dan keteladanan nyata melayani seluruh warga.');
$komitmenPengabdian = get_pengaturan($pdo, 'profil_komitmen_pengabdian', 'Distribusi bantuan dan sarana tani tepat sasaran, pelayanan kantor desa cepat & bebas pungli, serta siap hadir 24/7 untuk masyarakat.');

// Pengaturan 3 Pilar Keunggulan Kompetensi
$pilar1Judul = get_pengaturan($pdo, 'profil_pilar1_judul', 'Disiplin Tinggi & Integritas');
$pilar1Sub   = get_pengaturan($pdo, 'profil_pilar1_sub', 'Etos kerja tepat waktu, konsisten, dan kepemimpinan teladan yang mengayomi seluruh lapisan masyarakat tanpa membeda-bedakan.');

$pilar2Judul = get_pengaturan($pdo, 'profil_pilar2_judul', 'Tata Kelola Keuangan Akuntabel');
$pilar2Sub   = get_pengaturan($pdo, 'profil_pilar2_sub', 'Berpengalaman mengelola anggaran kedinasan secara tertib dan ketat. Menjamin Dana Desa (APBDes) dikelola transparan dan bebas kebocoran.');

$pilar3Judul = get_pengaturan($pdo, 'profil_pilar3_judul', 'Distribusi Kebutuhan Presisi');
$pilar3Sub   = get_pengaturan($pdo, 'profil_pilar3_sub', 'Teruji dalam manajemen logistik dan penyaluran kebutuhan personil. Memastikan pupuk subsidi, bansos, dan sarana tani terdistribusi adil & tepat sasaran.');

// Ambil data hero Sapa Warga
$fotoSapaWarga  = get_pengaturan($pdo, 'foto_sapa_warga', 'assets/images/banner/dialog_warga.jpg');
$quoteSapaWarga = get_pengaturan($pdo, 'quote_sapa_warga', 'Setiap masukan dari warga adalah langkah menuju desa yang lebih baik.');

// Ambil daftar dusun dari database, fallback ke config.php
$dusunJson = get_pengaturan($pdo, 'dusun_list', '');
$dusunList = [];
if (!empty($dusunJson)) {
    $dusunList = json_decode($dusunJson, true) ?: $DUSUN_LIST;
} else {
    $dusunList = $DUSUN_LIST;
}

// Ambil data pengaturan Halaman Potensi Desa
$fotoHeroPotensiAdmin  = get_pengaturan($pdo, 'foto_hero_potensi', 'assets/images/potensi/kolam_ngudal_tuk_putri.jpg');
$fotoSpotPotensiAdmin  = get_pengaturan($pdo, 'foto_spot_potensi', 'assets/images/potensi/kolam_ngudal_tuk_putri.jpg');
$heroPotensiJudulAdmin = get_pengaturan($pdo, 'hero_potensi_judul', 'Kekayaan Desa,<br>Kekuatan Bersama');
$heroPotensiSubAdmin   = get_pengaturan($pdo, 'hero_potensi_sub', 'Alam yang lestari, budaya yang hidup, masyarakat yang kreatif — inilah potensi Desa Tampirkulon yang terus tumbuh untuk masa depan yang lebih baik.');
$spotPotensiJudulAdmin = get_pengaturan($pdo, 'spot_potensi_judul', 'Kolam Ngudal Tuk Putri');
$spotPotensiDescAdmin  = get_pengaturan($pdo, 'spot_potensi_desc', 'Sumber mata air yang menjadi bagian dari potensi alam Desa Tampirkulon.');
$spotPotensiJarakAdmin = get_pengaturan($pdo, 'spot_potensi_jarak', '± 0,34 km dari Balai Desa Tampirkulon');
$spotPotensiLokasiAdmin= get_pengaturan($pdo, 'spot_potensi_lokasi', 'Tampirkulon, Candimulyo, Magelang');

// Ambil data kartu sorotan potensi di Beranda (Kolom 4 "Tampirkulon yang Kita Kenal")
$fotoPotensiBerandaAdmin  = get_pengaturan($pdo, 'foto_potensi_beranda', 'assets/images/galeri/wisata_tubing.jpg');
$judulPotensiBerandaAdmin = get_pengaturan($pdo, 'judul_potensi_beranda', 'Wisata Tubing Tampirkulon');
$subPotensiBerandaAdmin   = get_pengaturan($pdo, 'sub_potensi_beranda', 'Salah satu potensi unggulan desa');
$linkPotensiBerandaAdmin  = get_pengaturan($pdo, 'link_potensi_beranda', 'index.php?page=potensi');

// Render Template Admin Header & Navigasi
require_once __DIR__ . '/header_admin.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h3 class="fw-bold mb-1">Pengaturan &amp; Foto Hero</h3>
    <p class="text-muted mb-0">Kelola foto utama bagian Hero dan teks identitas kampanye secara dinamis.</p>
  </div>
  <a href="../index.php?page=beranda" target="_blank" class="btn btn-outline-danger btn-sm rounded-pill px-3">
    <i class="bi bi-box-arrow-up-right me-1"></i> Pratinjau di Beranda
  </a>
</div>

<div class="row g-4">
  <!-- 0. KARTU: GANTI BACKGROUND LANDSCAPE HERO -->
  <div class="col-12">
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
      <div class="d-flex align-items-center gap-2 mb-3">
        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: #e8f5e9;">
          <i class="bi bi-image-fill" style="color: #2e7d32; font-size: 1.1rem;"></i>
        </div>
        <div>
          <h5 class="fw-bold mb-0">Background Landscape Hero</h5>
          <small class="text-muted">Gambar pemandangan/landscape yang menjadi latar belakang Hero Section Beranda</small>
        </div>
      </div>

      <div class="row g-4 align-items-start">
        <!-- Preview Background Aktif -->
        <div class="col-md-5">
          <div class="p-2 bg-light rounded-4 border text-center">
            <div class="small fw-semibold text-muted mb-2">Background Aktif:</div>
            <img src="../<?= e($bgHero) ?>" alt="Background Hero" id="currentBgPreview"
              class="img-fluid rounded-3 shadow-sm border w-100"
              style="max-height: 160px; object-fit: cover;">
            <div class="text-muted small mt-1">
              <code><?= e(basename($bgHero)) ?></code>
            </div>
          </div>
        </div>

        <!-- Form Upload & Reset -->
        <div class="col-md-7">
          <form action="pengaturan.php" method="POST" enctype="multipart/form-data" class="mb-2">
            <?= csrf_field() ?>
            <input type="hidden" name="action" value="ganti_bg_hero">
            <div class="mb-3">
              <label for="inputBgHero" class="form-label small fw-semibold">Upload Gambar Background Baru</label>
              <input type="file" class="form-control rounded-3" id="inputBgHero" name="bg_hero_baru"
                accept="image/jpeg,image/png,image/webp" required>
              <div class="form-text small text-muted">Format: JPG, PNG, WEBP. Maks 10 MB. Disarankan landscape 16:9 minimal 1400px lebar.</div>
            </div>
            <!-- Live Preview -->
            <div id="bgLivePreviewContainer" class="mb-3 text-center p-2 border rounded-3 bg-white" style="display:none;">
              <div class="small fw-bold text-success mb-1"><i class="bi bi-eye-fill me-1"></i>Preview:</div>
              <img id="imgBgLivePreview" src="" alt="Preview" class="img-fluid rounded-3" style="max-height: 120px; object-fit: cover; width: 100%;">
            </div>
            <button type="submit" class="btn w-100 fw-bold rounded-3 py-2" style="background:#2e7d32; color:#fff;">
              <i class="bi bi-cloud-arrow-up-fill me-1"></i> Simpan Background Baru
            </button>
          </form>
          <form action="pengaturan.php" method="POST" onsubmit="return confirm('Kembalikan background ke landscape bawaan?');">
            <?= csrf_field() ?>
            <input type="hidden" name="action" value="reset_bg_hero">
            <button type="submit" class="btn btn-outline-secondary btn-sm w-100 rounded-3">
              <i class="bi bi-arrow-counterclockwise me-1"></i> Reset ke Background Bawaan (Kota Hijau)
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- 1. KARTU UTAMA: GANTI FOTO HERO BERANDA -->
  <div class="col-lg-7">
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
      <div class="d-flex align-items-center gap-2 mb-3">
        <div class="rounded-circle bg-danger-subtle text-danger d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
          <i class="bi bi-image fs-5"></i>
        </div>
        <div>
          <h5 class="fw-bold mb-0">Ganti Foto Hero Beranda</h5>
          <small class="text-muted">Foto ini ditampilkan di sisi kanan Hero Section Beranda publik</small>
        </div>
      </div>

      <!-- Pratinjau Foto Saat Ini -->
      <div class="mb-4 text-center p-3 bg-light rounded-4 border">
        <div class="small fw-semibold text-muted mb-2">Foto Hero Aktif Saat Ini:</div>
        <img src="../<?= e($fotoHero) ?>" alt="Foto Hero Aktif" id="currentHeroPreview" class="img-fluid rounded-4 shadow-sm border" style="max-height: 260px; object-fit: cover;">
        <div class="text-muted small mt-2">
          File path: <code><?= e($fotoHero) ?></code>
        </div>
      </div>

      <!-- Form Unggah Foto Baru -->
      <form action="pengaturan.php" method="POST" enctype="multipart/form-data" class="mb-3">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="ganti_foto_hero">

        <div class="mb-3">
          <label for="inputFotoHero" class="form-label small fw-semibold">Pilih Berkas Foto Baru</label>
          <input type="file" class="form-control rounded-3" id="inputFotoHero" name="foto_hero_baru" accept="image/jpeg,image/png,image/webp" required>
          <div class="form-text small text-muted">Format yang didukung: JPG, PNG, WEBP (Maksimal 5 MB). Disarankan rasio proporsional.</div>
        </div>

        <!-- Pratinjau Live Sebelum Simpan -->
        <div id="livePreviewContainer" class="mb-3 text-center p-3 border border-dashed rounded-4 bg-white" style="display: none;">
          <div class="small fw-bold text-success mb-2"><i class="bi bi-eye-fill me-1"></i> Pratinjau Foto Baru yang Dipilih:</div>
          <img id="imgLivePreview" src="" alt="Live Preview" class="img-fluid rounded-4 shadow-sm" style="max-height: 220px; object-fit: cover;">
        </div>

        <button type="submit" class="btn btn-danger w-100 rounded-3 fw-bold py-2 shadow-sm">
          <i class="bi bi-cloud-arrow-up-fill me-1"></i> Simpan &amp; Terapkan Foto Hero Baru
        </button>
      </form>

      <!-- Tombol Reset ke Default -->
      <form action="pengaturan.php" method="POST" onsubmit="return confirm('Kembalikan foto hero ke foto bawaan (clean default)?');">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="reset_foto_hero">
        <button type="submit" class="btn btn-outline-secondary btn-sm w-100 rounded-3">
          <i class="bi bi-arrow-counterclockwise me-1"></i> Kembalikan ke Foto Hero Bawaan
        </button>
      </form>
    </div>
  </div>

  <!-- 2. KARTU INFORMASI TEKS KAMPANYE -->
  <div class="col-lg-5">
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
      <div class="d-flex align-items-center gap-2 mb-3">
        <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
          <i class="bi bi-pencil-square fs-5"></i>
        </div>
        <div>
          <h5 class="fw-bold mb-0">Teks Identitas Hero</h5>
          <small class="text-muted">Ubah nama, nomor urut, dan slogan</small>
        </div>
      </div>

      <form action="pengaturan.php" method="POST">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="simpan_teks_kampanye">

        <div class="mb-3">
          <label class="form-label small fw-semibold">Nama Calon</label>
          <input type="text" class="form-control rounded-3" name="nama_calon" value="<?= e($namaCalon) ?>" required>
        </div>

        <div class="mb-3">
          <label class="form-label small fw-semibold">Nomor Urut</label>
          <input type="text" class="form-control rounded-3" name="no_urut" value="<?= e($noUrut) ?>" required>
        </div>

        <div class="mb-3">
          <label class="form-label small fw-semibold">Slogan / Tagline Hero</label>
          <textarea class="form-control rounded-3" name="tagline" rows="2" required><?= e($tagline) ?></textarea>
        </div>

        <div class="mb-4">
          <label class="form-label small fw-semibold">Kutipan / Quote Hero (Tampil di atas foto hero — Kotak Ungu)</label>
          <input type="text" class="form-control rounded-3" name="slogan_quote" value="<?= e($sloganQuote) ?>" required>
          <div class="form-text small text-muted">Tulisan di sudut kanan atas foto hero (kotak ungu pada beranda). Contoh: <code>Desa kuat karena warganya.</code></div>
        </div>

        <button type="submit" class="btn btn-primary w-100 rounded-3 fw-bold py-2 shadow-sm">
          <i class="bi bi-save-fill me-1"></i> Simpan Teks Kampanye
        </button>
      </form>
    </div>
  </div>
</div>


<!-- 2.5 KARTU KELOLA HALAMAN PROFIL (FOTO PROFIL & KONTEN DATA DIRI) -->
<div class="row g-4 mt-1">
  <div class="col-12">
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center gap-2">
          <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #fce4ec;">
            <i class="bi bi-person-lines-fill" style="color: #c2185b; font-size: 1.1rem;"></i>
          </div>
          <div>
            <h5 class="fw-bold mb-0">Pengaturan Halaman Profil Calon</h5>
            <small class="text-muted">Kelola foto profil dan isi biodata/narasi dedikasi pada menu Profil</small>
          </div>
        </div>
        <a href="../index.php?page=profil" target="_blank" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
          <i class="bi bi-box-arrow-up-right me-1"></i> Buka Halaman Profil
        </a>
      </div>

      <div class="row g-4">
        <!-- Kolom Kiri: Foto Profil Calon -->
        <div class="col-lg-4 border-end-lg">
          <h6 class="fw-bold text-dark mb-3"><i class="bi bi-camera-fill me-1 text-danger"></i> Foto Profil Calon</h6>
          
          <div class="p-3 bg-light rounded-4 border text-center mb-3">
            <div class="small fw-semibold text-muted mb-2">Foto Profil Aktif:</div>
            <img src="../<?= e($fotoProfil) ?>" alt="Foto Profil Calon" id="currentProfilPreview"
              class="img-fluid rounded-3 shadow-sm border" style="max-height: 240px; object-fit: cover;">
            <div class="text-muted small mt-2">
              <code><?= e(basename($fotoProfil)) ?></code>
            </div>
          </div>

          <form action="pengaturan.php" method="POST" enctype="multipart/form-data" class="mb-2">
            <?= csrf_field() ?>
            <input type="hidden" name="action" value="ganti_foto_profil">
            
            <div class="mb-3">
              <label for="inputFotoProfil" class="form-label small fw-semibold">Upload Foto Profil Baru</label>
              <input type="file" class="form-control rounded-3" id="inputFotoProfil" name="foto_profil_baru"
                accept="image/jpeg,image/png,image/webp" required>
              <div class="form-text small text-muted">Format: JPG, PNG, WEBP. Maksimal 5 MB.</div>
            </div>

            <!-- Live Preview -->
            <div id="profilLivePreviewContainer" class="mb-3 text-center p-2 border rounded-3 bg-white" style="display:none;">
              <div class="small fw-bold text-danger mb-1"><i class="bi bi-eye-fill me-1"></i>Preview Foto:</div>
              <img id="imgProfilLivePreview" src="" alt="Preview Profil" class="img-fluid rounded-3" style="max-height: 180px; object-fit: cover;">
            </div>

            <button type="submit" class="btn btn-danger w-100 fw-bold rounded-3 py-2 shadow-sm">
              <i class="bi bi-cloud-arrow-up-fill me-1"></i> Simpan Foto Profil
            </button>
          </form>

          <form action="pengaturan.php" method="POST" onsubmit="return confirm('Kembalikan foto profil ke foto bawaan?');">
            <?= csrf_field() ?>
            <input type="hidden" name="action" value="reset_foto_profil">
            <button type="submit" class="btn btn-outline-secondary btn-sm w-100 rounded-3">
              <i class="bi bi-arrow-counterclockwise me-1"></i> Reset ke Foto Bawaan
            </button>
          </form>
        </div>

        <!-- Kolom Kanan: Isi Konten Data Diri & Narasi -->
        <div class="col-lg-8">
          <h6 class="fw-bold text-dark mb-3"><i class="bi bi-file-earmark-person-fill me-1 text-primary"></i> Konten Data Diri &amp; Narasi Dedikasi</h6>
          
          <form action="pengaturan.php" method="POST">
            <?= csrf_field() ?>
            <input type="hidden" name="action" value="simpan_konten_profil">

            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <label class="form-label small fw-semibold"><i class="bi bi-shield-fill-check text-danger me-1"></i>Status / Kehormatan</label>
                <input type="text" class="form-control rounded-3" name="profil_status" value="<?= e($profilStatus) ?>" required placeholder="Contoh: Purnawirawan TNI AD">
                <div class="form-text small text-muted">Baris 1 di bawah nama pada kartu foto profil.</div>
              </div>
              <div class="col-md-6">
                <label class="form-label small fw-semibold"><i class="bi bi-geo-alt-fill text-danger me-1"></i>Asal / Domisili</label>
                <input type="text" class="form-control rounded-3" name="profil_asal" value="<?= e($profilAsal) ?>" required placeholder="Contoh: Putra Asli Tampirkulon">
                <div class="form-text small text-muted">Baris 2 di bawah nama pada kartu foto profil.</div>
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label small fw-semibold">Judul Narasi Dedikasi</label>
              <input type="text" class="form-control rounded-3" name="profil_judul_dedikasi" value="<?= e($judulDedikasi) ?>" required placeholder="Judul besar di samping foto profil">
            </div>

            <div class="mb-3">
              <label class="form-label small fw-semibold">Paragraf Biodata 1 (Latar Belakang &amp; Kedekatan Warga)</label>
              <textarea class="form-control rounded-3" name="profil_biodata_1" rows="3" required><?= e($biodata1) ?></textarea>
            </div>

            <div class="mb-3">
              <label class="form-label small fw-semibold">Paragraf Biodata 2 (Pengalaman &amp; Tekad Pengabdian)</label>
              <textarea class="form-control rounded-3" name="profil_biodata_2" rows="3" required><?= e($biodata2) ?></textarea>
            </div>

            <div class="row g-3 mb-4">
              <div class="col-md-6">
                <label class="form-label small fw-semibold"><i class="bi bi-award-fill text-danger me-1"></i> Nilai Kepemimpinan</label>
                <textarea class="form-control rounded-3" name="profil_nilai_kepemimpinan" rows="3" required><?= e($nilaiKepemimpinan) ?></textarea>
              </div>
              <div class="col-md-6">
                <label class="form-label small fw-semibold"><i class="bi bi-heart-fill text-danger me-1"></i> Komitmen Pengabdian</label>
                <textarea class="form-control rounded-3" name="profil_komitmen_pengabdian" rows="3" required><?= e($komitmenPengabdian) ?></textarea>
              </div>
            </div>

            <hr class="my-4">
            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-shield-check text-danger me-1"></i> 3 Pilar Keunggulan Kompetensi (Rekam Jejak Purnawirawan TNI AD)</h6>
            
            <div class="row g-3 mb-4">
              <div class="col-md-4">
                <div class="p-3 border rounded-3 bg-light h-100">
                  <label class="form-label small fw-bold text-danger"><i class="bi bi-shield-shaded me-1"></i> Pilar 1: Karakter Prajurit</label>
                  <input type="text" class="form-control rounded-3 mb-2" name="profil_pilar1_judul" value="<?= e($pilar1Judul) ?>" required placeholder="Judul Pilar 1">
                  <textarea class="form-control rounded-3 small" name="profil_pilar1_sub" rows="3" required placeholder="Deskripsi Pilar 1"><?= e($pilar1Sub) ?></textarea>
                </div>
              </div>
              <div class="col-md-4">
                <div class="p-3 border rounded-3 bg-light h-100">
                  <label class="form-label small fw-bold text-success"><i class="bi bi-cash-stack me-1"></i> Pilar 2: Pengelolaan Keuangan</label>
                  <input type="text" class="form-control rounded-3 mb-2" name="profil_pilar2_judul" value="<?= e($pilar2Judul) ?>" required placeholder="Judul Pilar 2">
                  <textarea class="form-control rounded-3 small" name="profil_pilar2_sub" rows="3" required placeholder="Deskripsi Pilar 2"><?= e($pilar2Sub) ?></textarea>
                </div>
              </div>
              <div class="col-md-4">
                <div class="p-3 border rounded-3 bg-light h-100">
                  <label class="form-label small fw-bold text-primary"><i class="bi bi-boxes me-1"></i> Pilar 3: Distribusi Logistik</label>
                  <input type="text" class="form-control rounded-3 mb-2" name="profil_pilar3_judul" value="<?= e($pilar3Judul) ?>" required placeholder="Judul Pilar 3">
                  <textarea class="form-control rounded-3 small" name="profil_pilar3_sub" rows="3" required placeholder="Deskripsi Pilar 3"><?= e($pilar3Sub) ?></textarea>
                </div>
              </div>
            </div>

            <button type="submit" class="btn btn-primary rounded-3 fw-bold px-4 py-2 shadow-sm">
              <i class="bi bi-save-fill me-1"></i> Simpan Konten Data Diri &amp; Keahlian Profil
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- 2.7 KARTU KELOLA HERO SAPA WARGA (FOTO & KUTIPAN) -->
<div class="row g-4 mt-1">
  <div class="col-12">
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center gap-2">
          <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #e8f5e9;">
            <i class="bi bi-chat-heart-fill" style="color: #2e7d32; font-size: 1.1rem;"></i>
          </div>
          <div>
            <h5 class="fw-bold mb-0">Pengaturan Hero Sapa Warga &amp; Banner CTA Program</h5>
            <small class="text-muted">Kelola foto dialog warga pada banner Sapa Warga dan Banner CTA di Halaman Program Kerja</small>
          </div>
        </div>
        <a href="../index.php?page=sapa-warga" target="_blank" class="btn btn-outline-success btn-sm rounded-pill px-3">
          <i class="bi bi-box-arrow-up-right me-1"></i> Buka Sapa Warga
        </a>
      </div>

      <div class="row g-4">
        <!-- Kolom Kiri: Foto Thumbnail Dialog Warga -->
        <div class="col-lg-5 border-end-lg">
          <h6 class="fw-bold text-dark mb-2"><i class="bi bi-camera-fill me-1 text-success"></i> Foto Thumbnail Dialog Warga</h6>
          <div class="alert alert-light border small text-muted py-2 mb-3">
            <i class="bi bi-info-circle me-1 text-primary"></i>
            <strong>Ukuran Ideal:</strong> Rasio <strong>4:3</strong> (landscape), resolusi rekomendasi <strong>600 &times; 400 px</strong> atau <strong>400 &times; 300 px</strong>. Maksimal 5 MB.
          </div>

          <div class="p-3 bg-light rounded-4 border text-center mb-3">
            <div class="small fw-semibold text-muted mb-2">Foto Saat Ini:</div>
            <img src="../<?= e($fotoSapaWarga) ?>" alt="Foto Sapa Warga" id="currentSapaPreview"
              class="img-fluid rounded-3 shadow-sm border" style="max-height: 140px; object-fit: cover; width: 180px;">
            <div class="text-muted small mt-2">
              <code><?= e(basename($fotoSapaWarga)) ?></code>
            </div>
          </div>

          <form action="pengaturan.php" method="POST" enctype="multipart/form-data" class="mb-2">
            <?= csrf_field() ?>
            <input type="hidden" name="action" value="ganti_foto_sapa_warga">
            
            <div class="mb-3">
              <label for="inputFotoSapa" class="form-label small fw-semibold">Upload Foto Baru</label>
              <input type="file" class="form-control rounded-3" id="inputFotoSapa" name="foto_sapa_baru"
                accept="image/jpeg,image/png,image/webp" required>
              <div class="form-text small text-muted">Format: JPG, PNG, WEBP. Subjek di tengah/center.</div>
            </div>

            <!-- Live Preview -->
            <div id="sapaLivePreviewContainer" class="mb-3 text-center p-2 border rounded-3 bg-white" style="display:none;">
              <div class="small fw-bold text-success mb-1"><i class="bi bi-eye-fill me-1"></i>Preview Foto:</div>
              <img id="imgSapaLivePreview" src="" alt="Preview Sapa" class="img-fluid rounded-3" style="max-height: 120px; object-fit: cover;">
            </div>

            <button type="submit" class="btn btn-success w-100 fw-bold rounded-3 py-2 shadow-sm">
              <i class="bi bi-cloud-arrow-up-fill me-1"></i> Simpan Foto Sapa Warga
            </button>
          </form>

          <form action="pengaturan.php" method="POST" onsubmit="return confirm('Kembalikan foto ke dialog warga bawaan?');">
            <?= csrf_field() ?>
            <input type="hidden" name="action" value="reset_foto_sapa_warga">
            <button type="submit" class="btn btn-outline-secondary btn-sm w-100 rounded-3">
              <i class="bi bi-arrow-counterclockwise me-1"></i> Reset ke Foto Bawaan
            </button>
          </form>
        </div>

        <!-- Kolom Kanan: Teks Kutipan / Quote Hero Sapa Warga -->
        <div class="col-lg-7">
          <h6 class="fw-bold text-dark mb-2"><i class="bi bi-quote me-1 text-danger"></i> Teks Kutipan Kartu Hero</h6>
          <p class="text-muted small mb-3">Teks kutipan yang tampil di samping foto di dalam kartu putih pada banner hijau.</p>

          <form action="pengaturan.php" method="POST">
            <?= csrf_field() ?>
            <input type="hidden" name="action" value="simpan_quote_sapa_warga">

            <div class="mb-4">
              <label class="form-label small fw-semibold">Isi Kutipan Hero Sapa Warga</label>
              <textarea class="form-control rounded-3 font-handwriting fs-5" name="quote_sapa_warga" rows="3" required><?= e($quoteSapaWarga) ?></textarea>
              <div class="form-text small text-muted">Akan ditampilkan dengan tulisan tangan khas (*font-handwriting*) dan ditutup otomatis dengan nama calon: <code>- <?= e($namaCalon) ?></code>.</div>
            </div>

            <button type="submit" class="btn btn-primary rounded-3 fw-bold px-4 py-2 shadow-sm">
              <i class="bi bi-save-fill me-1"></i> Simpan Kutipan Sapa Warga
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>



<!-- 2.8 KARTU KELOLA HALAMAN POTENSI DESA -->
<div class="row g-4 mt-1">
  <div class="col-12">
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
      <div class="d-flex align-items-center gap-2 mb-4">
        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #e8f5e9;">
          <i class="fa-solid fa-wheat-awn" style="color: #2e7d32; font-size: 1.1rem;"></i>
        </div>
        <div>
          <h5 class="fw-bold mb-0">Pengaturan Halaman Potensi Desa</h5>
          <small class="text-muted">Kelola foto hero, foto spot unggulan, dan teks konten halaman potensi desa</small>
        </div>
      </div>

      <div class="row g-4">
        <!-- Kolom Kiri: Upload Foto Hero Potensi -->
        <div class="col-md-6">
          <div class="border rounded-3 p-3 h-100">
            <h6 class="fw-bold mb-3"><i class="bi bi-image-fill text-success me-1"></i>Foto Background Hero Potensi</h6>
            <div class="mb-3 text-center">
              <img id="currentHeroPotensiPreview" src="../<?= e($fotoHeroPotensiAdmin) ?>"
                   alt="Hero Potensi" class="img-fluid rounded-3 shadow-sm"
                   style="max-height: 160px; object-fit: cover; width: 100%;">
              <small class="d-block text-muted mt-1" style="font-size:0.7rem;"><?= e($fotoHeroPotensiAdmin) ?></small>
            </div>
            <form action="pengaturan.php" method="POST" enctype="multipart/form-data">
              <?= csrf_field() ?>
              <input type="hidden" name="action" value="ganti_foto_hero_potensi">
              <div id="heroPotensiLivePreviewContainer" class="mb-2 text-center" style="display:none;">
                <img id="imgHeroPotensiLivePreview" src="" class="img-fluid rounded-3 shadow-sm mb-1" style="max-height:100px; object-fit:cover; width:100%;">
                <small class="text-success small fw-semibold">Preview Foto Baru</small>
              </div>
              <div class="input-group input-group-sm mb-2">
                <input type="file" class="form-control rounded-3" id="inputFotoHeroPotensi"
                       name="foto_hero_potensi_baru" accept="image/*">
              </div>
              <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success btn-sm rounded-3 flex-grow-1">
                  <i class="bi bi-upload me-1"></i> Simpan Foto Hero
                </button>
              </div>
            </form>
            <form action="pengaturan.php" method="POST" class="mt-2" onsubmit="return confirm('Reset foto hero potensi ke bawaan?');">
              <?= csrf_field() ?>
              <input type="hidden" name="action" value="reset_foto_hero_potensi">
              <button type="submit" class="btn btn-outline-secondary btn-sm rounded-3 w-100">
                <i class="bi bi-arrow-counterclockwise me-1"></i> Reset ke Bawaan
              </button>
            </form>
          </div>
        </div>

        <!-- Kolom Kanan: Upload Foto Spot Unggulan Potensi -->
        <div class="col-md-6">
          <div class="border rounded-3 p-3 h-100">
            <h6 class="fw-bold mb-3"><i class="bi bi-droplet-fill text-info me-1"></i>Foto Spot Unggulan (Tuk Putri)</h6>
            <div class="mb-3 text-center">
              <img id="currentSpotPotensiPreview" src="../<?= e($fotoSpotPotensiAdmin) ?>"
                   alt="Spot Potensi" class="img-fluid rounded-3 shadow-sm"
                   style="max-height: 160px; object-fit: cover; width: 100%;">
              <small class="d-block text-muted mt-1" style="font-size:0.7rem;"><?= e($fotoSpotPotensiAdmin) ?></small>
            </div>
            <form action="pengaturan.php" method="POST" enctype="multipart/form-data">
              <?= csrf_field() ?>
              <input type="hidden" name="action" value="ganti_foto_spot_potensi">
              <div id="spotPotensiLivePreviewContainer" class="mb-2 text-center" style="display:none;">
                <img id="imgSpotPotensiLivePreview" src="" class="img-fluid rounded-3 shadow-sm mb-1" style="max-height:100px; object-fit:cover; width:100%;">
                <small class="text-success small fw-semibold">Preview Foto Baru</small>
              </div>
              <div class="input-group input-group-sm mb-2">
                <input type="file" class="form-control rounded-3" id="inputFotoSpotPotensi"
                       name="foto_spot_potensi_baru" accept="image/*">
              </div>
              <div class="d-flex gap-2">
                <button type="submit" class="btn btn-info btn-sm rounded-3 flex-grow-1 text-white">
                  <i class="bi bi-upload me-1"></i> Simpan Foto Spot
                </button>
              </div>
            </form>
            <form action="pengaturan.php" method="POST" class="mt-2" onsubmit="return confirm('Reset foto spot potensi ke bawaan?');">
              <?= csrf_field() ?>
              <input type="hidden" name="action" value="reset_foto_spot_potensi">
              <button type="submit" class="btn btn-outline-secondary btn-sm rounded-3 w-100">
                <i class="bi bi-arrow-counterclockwise me-1"></i> Reset ke Bawaan
              </button>
            </form>
          </div>
        </div>
      </div>

      <!-- Edit Teks Konten Potensi -->
      <div class="mt-4 border rounded-3 p-3">
        <h6 class="fw-bold mb-3"><i class="bi bi-pencil-square text-warning me-1"></i>Edit Teks Konten Potensi Desa</h6>
        <form action="pengaturan.php" method="POST">
          <?= csrf_field() ?>
          <input type="hidden" name="action" value="simpan_konten_potensi">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label small fw-semibold">Judul Hero (HTML diizinkan, contoh: Kekayaan Desa,&lt;br&gt;Kekuatan Bersama)</label>
              <input type="text" class="form-control form-control-sm rounded-3" name="hero_potensi_judul"
                     value="<?= e($heroPotensiJudulAdmin) ?>">
            </div>
            <div class="col-md-6">
              <label class="form-label small fw-semibold">Judul Spot Unggulan</label>
              <input type="text" class="form-control form-control-sm rounded-3" name="spot_potensi_judul"
                     value="<?= e($spotPotensiJudulAdmin) ?>">
            </div>
            <div class="col-12">
              <label class="form-label small fw-semibold">Subtitle Hero Potensi</label>
              <textarea class="form-control form-control-sm rounded-3" name="hero_potensi_sub" rows="2"><?= e($heroPotensiSubAdmin) ?></textarea>
            </div>
            <div class="col-12">
              <label class="form-label small fw-semibold">Deskripsi Spot Unggulan</label>
              <textarea class="form-control form-control-sm rounded-3" name="spot_potensi_desc" rows="3"><?= e($spotPotensiDescAdmin) ?></textarea>
            </div>
            <div class="col-md-6">
              <label class="form-label small fw-semibold">Jarak Spot dari Balai Desa</label>
              <input type="text" class="form-control form-control-sm rounded-3" name="spot_potensi_jarak"
                     value="<?= e($spotPotensiJarakAdmin) ?>">
            </div>
            <div class="col-md-6">
              <label class="form-label small fw-semibold">Lokasi Spot Unggulan</label>
              <input type="text" class="form-control form-control-sm rounded-3" name="spot_potensi_lokasi"
                     value="<?= e($spotPotensiLokasiAdmin) ?>">
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-primary rounded-3 fw-bold px-4 py-2 shadow-sm">
                <i class="bi bi-save-fill me-1"></i> Simpan Konten Potensi Desa
              </button>
            </div>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>

<!-- 2.9 KARTU SOROTAN POTENSI DI BERANDA (KOLOM 4 / WISATA TUBING) -->
<div class="row g-4 mt-1">
  <div class="col-12">
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
      <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
          <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #ffebee;">
            <i class="bi bi-card-image" style="color: #c62828; font-size: 1.1rem;"></i>
          </div>
          <div>
            <h5 class="fw-bold mb-0">Kartu Sorotan Potensi di Beranda (Kolom Sorotan)</h5>
            <small class="text-muted">Kelola foto dan teks kartu potensi yang tampil di section "Tampirkulon yang Kita Kenal" di Beranda</small>
          </div>
        </div>
        <a href="../index.php#tampirkulon-kenal" target="_blank" class="btn btn-outline-danger btn-sm rounded-pill px-3">
          <i class="bi bi-box-arrow-up-right me-1"></i> Lihat di Beranda
        </a>
      </div>

      <div class="row g-4">
        <!-- Kolom Kiri: Pratinjau Kartu Beranda Aktif -->
        <div class="col-md-5">
          <div class="border rounded-3 p-3 text-center h-100 bg-light">
            <h6 class="fw-bold mb-3 text-start"><i class="bi bi-eye-fill text-danger me-1"></i>Pratinjau Kartu di Beranda:</h6>
            <div class="position-relative rounded-4 overflow-hidden shadow-sm mx-auto" style="max-width: 320px; aspect-ratio: 4/3; background: #000;">
              <img id="currentPotensiBerandaPreview" src="../<?= e($fotoPotensiBerandaAdmin) ?>"
                   alt="Kartu Potensi Beranda" class="w-100 h-100" style="object-fit: cover;">
              <div class="position-absolute bottom-0 start-0 end-0 p-3 text-start text-white"
                   style="background: linear-gradient(180deg, transparent 0%, rgba(0,0,0,0.88) 100%);">
                <div class="d-flex align-items-center justify-content-between">
                  <div>
                    <h6 class="fw-bold mb-0 text-white" id="previewTextJudulBeranda"><?= e($judulPotensiBerandaAdmin) ?></h6>
                    <small class="text-white-50" style="font-size: 0.75rem;" id="previewTextSubBeranda"><?= e($subPotensiBerandaAdmin) ?></small>
                  </div>
                  <div class="bg-white text-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; flex-shrink: 0;">
                    <i class="bi bi-arrow-right" style="font-size: 0.8rem;"></i>
                  </div>
                </div>
              </div>
            </div>
            <small class="d-block text-muted mt-2" style="font-size:0.75rem;">Berkas aktif: <code><?= e($fotoPotensiBerandaAdmin) ?></code></small>
          </div>
        </div>

        <!-- Kolom Kanan: Pilihan Penggantian Foto -->
        <div class="col-md-7">
          <div class="border rounded-3 p-3 h-100">
            <!-- 1. Upload Foto Sendiri -->
            <h6 class="fw-bold mb-2"><i class="bi bi-upload text-primary me-1"></i>Opsi 1: Upload Foto Baru</h6>
            <form action="pengaturan.php" method="POST" enctype="multipart/form-data" class="mb-3">
              <?= csrf_field() ?>
              <input type="hidden" name="action" value="ganti_foto_potensi_beranda">
              <div id="potensiBerandaLivePreviewContainer" class="mb-2 text-center" style="display:none;">
                <img id="imgPotensiBerandaLivePreview" src="" class="img-fluid rounded-3 shadow-sm mb-1" style="max-height:100px; object-fit:cover; width:100%;">
                <small class="text-success small fw-semibold">Pratinjau Foto Baru</small>
              </div>
              <div class="input-group input-group-sm mb-2">
                <input type="file" class="form-control rounded-3" id="inputFotoPotensiBeranda"
                       name="foto_potensi_beranda_baru" accept="image/*" required>
              </div>
              <button type="submit" class="btn btn-primary btn-sm rounded-3 w-100 fw-semibold">
                <i class="bi bi-cloud-arrow-up-fill me-1"></i> Upload &amp; Terapkan ke Beranda
              </button>
            </form>

            <hr class="my-3">

            <!-- 2. Seleraskan dengan Halaman Potensi -->
            <h6 class="fw-bold mb-2"><i class="bi bi-arrow-repeat text-success me-1"></i>Opsi 2: Seleraskan dengan Halaman Potensi</h6>
            <p class="text-muted small mb-2">Gunakan foto yang sudah ada di Halaman Potensi secara otomatis agar visual selaras:</p>
            <form action="pengaturan.php" method="POST" class="mb-3">
              <?= csrf_field() ?>
              <input type="hidden" name="action" value="sinkron_foto_potensi_beranda">
              <div class="d-flex gap-2 mb-2">
                <div class="form-check flex-fill p-2 border rounded-3 bg-white">
                  <input class="form-check-input ms-1" type="radio" name="sumber_foto" id="srcSpot" value="spot" checked>
                  <label class="form-check-label small ms-1 fw-semibold" for="srcSpot">
                    Spot Tuk Putri
                    <small class="d-block text-muted" style="font-size:0.7rem;">(Foto Kolam Ngudal)</small>
                  </label>
                </div>
                <div class="form-check flex-fill p-2 border rounded-3 bg-white">
                  <input class="form-check-input ms-1" type="radio" name="sumber_foto" id="srcHero" value="hero">
                  <label class="form-check-label small ms-1 fw-semibold" for="srcHero">
                    Hero Potensi
                    <small class="d-block text-muted" style="font-size:0.7rem;">(Foto Latar Halaman Potensi)</small>
                  </label>
                </div>
              </div>
              <button type="submit" class="btn btn-success btn-sm rounded-3 w-100 fw-semibold">
                <i class="bi bi-check2-circle me-1"></i> Gunakan Gambar Halaman Potensi
              </button>
            </form>

            <hr class="my-3">

            <!-- 3. Reset ke Bawaan -->
            <form action="pengaturan.php" method="POST" onsubmit="return confirm('Kembalikan foto kartu potensi beranda ke bawaan (Wisata Tubing)?');">
              <?= csrf_field() ?>
              <input type="hidden" name="action" value="reset_foto_potensi_beranda">
              <button type="submit" class="btn btn-outline-secondary btn-sm rounded-3 w-100">
                <i class="bi bi-arrow-counterclockwise me-1"></i> Reset ke Foto Bawaan (Wisata Tubing)
              </button>
            </form>
          </div>
        </div>
      </div>

      <!-- Edit Teks & Link Kartu Sorotan Beranda -->
      <div class="mt-4 border rounded-3 p-3">
        <h6 class="fw-bold mb-3"><i class="bi bi-pencil-square text-danger me-1"></i>Edit Teks &amp; Tautan Kartu Sorotan Beranda</h6>
        <form action="pengaturan.php" method="POST">
          <?= csrf_field() ?>
          <input type="hidden" name="action" value="simpan_teks_potensi_beranda">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label small fw-semibold">Judul Kartu</label>
              <input type="text" class="form-control form-control-sm rounded-3" id="inputJudulBeranda" name="judul_potensi_beranda"
                     value="<?= e($judulPotensiBerandaAdmin) ?>" required>
            </div>
            <div class="col-md-6">
              <label class="form-label small fw-semibold">Subtitle Kartu</label>
              <input type="text" class="form-control form-control-sm rounded-3" id="inputSubBeranda" name="sub_potensi_beranda"
                     value="<?= e($subPotensiBerandaAdmin) ?>" required>
            </div>
            <div class="col-12">
              <label class="form-label small fw-semibold">Tautan / Link Kartu</label>
              <input type="text" class="form-control form-control-sm rounded-3" name="link_potensi_beranda"
                     value="<?= e($linkPotensiBerandaAdmin) ?>" required>
              <div class="form-text small text-muted">Secara default mengarah ke <code>index.php?page=potensi</code>.</div>
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-danger rounded-3 fw-bold px-4 py-2 shadow-sm">
                <i class="bi bi-save-fill me-1"></i> Simpan Teks Kartu Beranda
              </button>
            </div>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>

<!-- 3. KARTU EDIT DAFTAR DUSUN -->
<div class="row g-4 mt-1">
  <div class="col-12">
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
      <div class="d-flex align-items-center gap-2 mb-3">
        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #e8f5e9;">
          <i class="bi bi-house-fill" style="color: #2e7d32; font-size: 1.1rem;"></i>
        </div>
        <div>
          <h5 class="fw-bold mb-0">Daftar Dusun Tampirkulon</h5>
          <small class="text-muted">Kelola nama-nama dusun resmi yang tampil di formulir Sapa Warga dan halaman lainnya</small>
        </div>
      </div>

      <form action="pengaturan.php" method="POST" id="formEditDusun">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="simpan_dusun">

        <div id="dusunContainer" class="mb-3">
          <?php foreach ($dusunList as $idx => $dusunNama): ?>
          <div class="dusun-item d-flex align-items-center gap-2 mb-2" id="dusunItem<?= $idx ?>">
            <span class="text-muted small fw-semibold" style="width:28px; text-align:right;"><?= $idx + 1 ?>.</span>
            <input
              type="text"
              class="form-control form-control-sm rounded-3"
              name="dusun[]"
              value="<?= e($dusunNama) ?>"
              placeholder="Nama dusun..."
              required
              style="max-width: 360px;"
            >
            <button type="button" class="btn btn-sm btn-outline-danger rounded-3 btn-hapus-dusun" title="Hapus dusun ini">
              <i class="bi bi-trash3"></i>
            </button>
          </div>
          <?php endforeach; ?>
        </div>

        <div class="d-flex gap-2 mb-4 flex-wrap">
          <button type="button" id="btnTambahDusun" class="btn btn-sm btn-outline-success rounded-3">
            <i class="bi bi-plus-circle me-1"></i> Tambah Dusun
          </button>
          <span class="text-muted small d-flex align-items-center">
            <i class="bi bi-info-circle me-1"></i>
            Total: <strong id="totalDusun" class="ms-1"><?= count($dusunList) ?></strong> dusun
          </span>
        </div>

        <div class="alert alert-info alert-sm small rounded-3 py-2 mb-3" role="alert">
          <i class="bi bi-lightbulb me-1"></i>
          <strong>Tips:</strong> Nama dusun ini akan muncul di dropdown pilihan lokasi pada formulir <strong>Sapa Warga</strong>.
          Pastikan penulisan nama sesuai nama resmi dusun.
        </div>

        <button type="submit" class="btn btn-success rounded-3 fw-bold px-4 py-2 shadow-sm">
          <i class="bi bi-save-fill me-1"></i> Simpan Daftar Dusun
        </button>
      </form>
    </div>
  </div>
</div>

<script>
// Script Live Preview Foto Baru
document.addEventListener('DOMContentLoaded', function() {
  const input = document.getElementById('inputFotoHero');
  const container = document.getElementById('livePreviewContainer');
  const img = document.getElementById('imgLivePreview');

  if (input && container && img) {
    input.addEventListener('change', function() {
      const file = this.files[0];
      if (file) {
        if (file.size > 5 * 1024 * 1024) {
          alert('Ukuran file maksimal 5 MB!');
          this.value = '';
          container.style.display = 'none';
          return;
        }
        const reader = new FileReader();
        reader.onload = function(e) {
          img.src = e.target.result;
          container.style.display = 'block';
        };
        reader.readAsDataURL(file);
      } else {
        container.style.display = 'none';
      }
    });
  }

  // ===== Live Preview Background Hero =====
  const bgInput = document.getElementById('inputBgHero');
  const bgContainer = document.getElementById('bgLivePreviewContainer');
  const bgImg = document.getElementById('imgBgLivePreview');
  const bgCurrentPreview = document.getElementById('currentBgPreview');

  if (bgInput && bgContainer && bgImg) {
    bgInput.addEventListener('change', function() {
      const file = this.files[0];
      if (file) {
        if (file.size > 10 * 1024 * 1024) {
          alert('Ukuran file background maksimal 10 MB!');
          this.value = '';
          bgContainer.style.display = 'none';
          return;
        }
        const reader = new FileReader();
        reader.onload = function(e) {
          bgImg.src = e.target.result;
          bgContainer.style.display = 'block';
          // Update preview aktif juga
          if (bgCurrentPreview) bgCurrentPreview.src = e.target.result;
        };
        reader.readAsDataURL(file);
      } else {
        bgContainer.style.display = 'none';
      }
    });
  }

  // ===== Manajemen Dusun =====
  const dusunContainer = document.getElementById('dusunContainer');
  const btnTambah = document.getElementById('btnTambahDusun');
  const totalDusun = document.getElementById('totalDusun');

  function updateNomor() {
    const items = dusunContainer.querySelectorAll('.dusun-item');
    items.forEach((item, idx) => {
      const nomor = item.querySelector('span');
      if (nomor) nomor.textContent = (idx + 1) + '.';
    });
    if (totalDusun) totalDusun.textContent = items.length;
  }

  function buatItemDusun(nama = '') {
    const div = document.createElement('div');
    div.className = 'dusun-item d-flex align-items-center gap-2 mb-2';
    div.innerHTML = `
      <span class="text-muted small fw-semibold" style="width:28px; text-align:right;">0.</span>
      <input type="text" class="form-control form-control-sm rounded-3"
        name="dusun[]" value="${nama}" placeholder="Nama dusun..."
        required style="max-width: 360px;">
      <button type="button" class="btn btn-sm btn-outline-danger rounded-3 btn-hapus-dusun" title="Hapus">
        <i class="bi bi-trash3"></i>
      </button>
    `;
    return div;
  }

  if (btnTambah) {
    btnTambah.addEventListener('click', function() {
      const item = buatItemDusun('');
      dusunContainer.appendChild(item);
      updateNomor();
      item.querySelector('input').focus();
    });
  }

  if (dusunContainer) {
    dusunContainer.addEventListener('click', function(e) {
      const btn = e.target.closest('.btn-hapus-dusun');
      if (btn) {
        const items = dusunContainer.querySelectorAll('.dusun-item');
        if (items.length <= 1) {
          alert('Minimal harus ada 1 dusun.');
          return;
        }
        btn.closest('.dusun-item').remove();
        updateNomor();
      }
    });
  }

  // ===== Live Preview Foto Profil =====
  const profilInput = document.getElementById('inputFotoProfil');
  const profilContainer = document.getElementById('profilLivePreviewContainer');
  const profilImg = document.getElementById('imgProfilLivePreview');
  const profilCurrentPreview = document.getElementById('currentProfilPreview');

  if (profilInput && profilContainer && profilImg) {
    profilInput.addEventListener('change', function() {
      const file = this.files[0];
      if (file) {
        if (file.size > 5 * 1024 * 1024) {
          alert('Ukuran foto profil maksimal 5 MB!');
          this.value = '';
          profilContainer.style.display = 'none';
          return;
        }
        const reader = new FileReader();
        reader.onload = function(e) {
          profilImg.src = e.target.result;
          profilContainer.style.display = 'block';
          if (profilCurrentPreview) profilCurrentPreview.src = e.target.result;
        };
        reader.readAsDataURL(file);
      } else {
        profilContainer.style.display = 'none';
      }
    });
  }

  // ===== Live Preview Foto Sapa Warga =====
  const sapaInput = document.getElementById('inputFotoSapa');
  const sapaContainer = document.getElementById('sapaLivePreviewContainer');
  const sapaImg = document.getElementById('imgSapaLivePreview');
  const sapaCurrentPreview = document.getElementById('currentSapaPreview');

  if (sapaInput && sapaContainer && sapaImg) {
    sapaInput.addEventListener('change', function() {
      const file = this.files[0];
      if (file) {
        if (file.size > 5 * 1024 * 1024) {
          alert('Ukuran foto maksimal 5 MB!');
          this.value = '';
          sapaContainer.style.display = 'none';
          return;
        }
        const reader = new FileReader();
        reader.onload = function(e) {
          sapaImg.src = e.target.result;
          sapaContainer.style.display = 'block';
          if (sapaCurrentPreview) sapaCurrentPreview.src = e.target.result;
        };
        reader.readAsDataURL(file);
      } else {
        sapaContainer.style.display = 'none';
      }
    });
  }

  // ===== Live Preview Foto Hero Potensi =====
  const heroPotensiInput = document.getElementById('inputFotoHeroPotensi');
  const heroPotensiContainer = document.getElementById('heroPotensiLivePreviewContainer');
  const heroPotensiImg = document.getElementById('imgHeroPotensiLivePreview');
  const heroPotensiCurrentPreview = document.getElementById('currentHeroPotensiPreview');

  if (heroPotensiInput && heroPotensiContainer && heroPotensiImg) {
    heroPotensiInput.addEventListener('change', function() {
      const file = this.files[0];
      if (file) {
        if (file.size > 10 * 1024 * 1024) {
          alert('Ukuran foto maksimal 10 MB!');
          this.value = '';
          heroPotensiContainer.style.display = 'none';
          return;
        }
        const reader = new FileReader();
        reader.onload = function(e) {
          heroPotensiImg.src = e.target.result;
          heroPotensiContainer.style.display = 'block';
          if (heroPotensiCurrentPreview) heroPotensiCurrentPreview.src = e.target.result;
        };
        reader.readAsDataURL(file);
      } else {
        heroPotensiContainer.style.display = 'none';
      }
    });
  }

  // ===== Live Preview Foto Spot Unggulan Potensi =====
  const spotPotensiInput = document.getElementById('inputFotoSpotPotensi');
  const spotPotensiContainer = document.getElementById('spotPotensiLivePreviewContainer');
  const spotPotensiImg = document.getElementById('imgSpotPotensiLivePreview');
  const spotPotensiCurrentPreview = document.getElementById('currentSpotPotensiPreview');

  if (spotPotensiInput && spotPotensiContainer && spotPotensiImg) {
    spotPotensiInput.addEventListener('change', function() {
      const file = this.files[0];
      if (file) {
        if (file.size > 10 * 1024 * 1024) {
          alert('Ukuran foto maksimal 10 MB!');
          this.value = '';
          spotPotensiContainer.style.display = 'none';
          return;
        }
        const reader = new FileReader();
        reader.onload = function(e) {
          spotPotensiImg.src = e.target.result;
          spotPotensiContainer.style.display = 'block';
          if (spotPotensiCurrentPreview) spotPotensiCurrentPreview.src = e.target.result;
        };
        reader.readAsDataURL(file);
      } else {
        spotPotensiContainer.style.display = 'none';
      }
    });
  }

  // ===== Live Preview Foto Kartu Potensi Beranda =====
  const potensiBerandaInput = document.getElementById('inputFotoPotensiBeranda');
  const potensiBerandaContainer = document.getElementById('potensiBerandaLivePreviewContainer');
  const potensiBerandaImg = document.getElementById('imgPotensiBerandaLivePreview');
  const potensiBerandaCurrentPreview = document.getElementById('currentPotensiBerandaPreview');

  if (potensiBerandaInput && potensiBerandaContainer && potensiBerandaImg) {
    potensiBerandaInput.addEventListener('change', function() {
      const file = this.files[0];
      if (file) {
        if (file.size > 10 * 1024 * 1024) {
          alert('Ukuran foto maksimal 10 MB!');
          this.value = '';
          potensiBerandaContainer.style.display = 'none';
          return;
        }
        const reader = new FileReader();
        reader.onload = function(e) {
          potensiBerandaImg.src = e.target.result;
          potensiBerandaContainer.style.display = 'block';
          if (potensiBerandaCurrentPreview) potensiBerandaCurrentPreview.src = e.target.result;
        };
        reader.readAsDataURL(file);
      } else {
        potensiBerandaContainer.style.display = 'none';
      }
    });
  }

  // Live text update for Beranda Card Preview
  const inJudulBeranda = document.getElementById('inputJudulBeranda');
  const inSubBeranda = document.getElementById('inputSubBeranda');
  const outJudulBeranda = document.getElementById('previewTextJudulBeranda');
  const outSubBeranda = document.getElementById('previewTextSubBeranda');

  if (inJudulBeranda && outJudulBeranda) {
    inJudulBeranda.addEventListener('input', function() {
      outJudulBeranda.textContent = this.value || 'Wisata Tubing Tampirkulon';
    });
  }
  if (inSubBeranda && outSubBeranda) {
    inSubBeranda.addEventListener('input', function() {
      outSubBeranda.textContent = this.value || 'Salah satu potensi unggulan desa';
    });
  }
});
</script>

<?php require_once __DIR__ . '/footer_admin.php'; ?>
