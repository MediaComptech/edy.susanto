/**
 * JavaScript Interaktivitas & PWA Terintegrasi
 * Calon Kepala Desa Tampirkulon - Edy Susanto (No. Urut 2)
 */

document.addEventListener('DOMContentLoaded', () => {
  initPWA();
  initCleanTabs();
  initAspirasiInteractions();
  initSearchModal();
});

/* ==========================================================================
   1. Clean Sub-Tabs Switching (Sesuai UI/1.png)
   ========================================================================== */
function initCleanTabs() {
  const tabButtons = document.querySelectorAll('.tab-link-clean');
  const panels = document.querySelectorAll('.tab-pane-content');
  const triggerButtons = document.querySelectorAll('.tab-trigger-btn');

  function activateTab(targetId) {
    // Update button active states
    tabButtons.forEach(btn => {
      if (btn.getAttribute('data-tab-target') === targetId) {
        btn.classList.add('active');
      } else {
        btn.classList.remove('active');
      }
    });

    // Update panel displays
    panels.forEach(panel => {
      if ('#' + panel.id === targetId) {
        panel.style.display = 'block';
      } else {
        panel.style.display = 'none';
      }
    });
  }

  tabButtons.forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.preventDefault();
      const target = this.getAttribute('data-tab-target');
      if (target) {
        activateTab(target);
      }
    });
  });

  triggerButtons.forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.preventDefault();
      const targetId = '#' + this.getAttribute('data-target');
      activateTab(targetId);
      const tabsBar = document.getElementById('sapaNavTabs');
      if (tabsBar) {
        tabsBar.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });
}

/* ==========================================================================
   2. Modul PWA & Notifikasi Terintegrasi
   ========================================================================== */
let deferredPrompt = null;

function initPWA() {
  // Registrasi Service Worker - ONLINE FIRST STRATEGY
  if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
      navigator.serviceWorker.register('./service-worker.js')
        .then((reg) => {
          console.log('Service Worker Tampirkulon terdaftar:', reg.scope);
          // Online First: Selalu cek pembaruan file ke server saat online
          if (navigator.onLine && typeof reg.update === 'function') {
            reg.update();
          }

          // Dengarkan event jika ada update SW baru terinstall
          reg.addEventListener('updatefound', () => {
            const newWorker = reg.installing;
            if (newWorker) {
              newWorker.addEventListener('statechange', () => {
                if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                  console.log('PWA: Versi baru berhasil diperbarui dari server (Online First).');
                }
              });
            }
          });
        })
        .catch((err) => {
          console.log('Registrasi Service Worker gagal:', err);
        });

      // Deteksi ketika perangkat beralih kembali online
      window.addEventListener('online', () => {
        navigator.serviceWorker.ready.then((reg) => {
          if (typeof reg.update === 'function') {
            reg.update();
            console.log('Koneksi online pulih. Sinkronisasi data PWA terbaru...');
          }
        });
      });
    });
  }

  // Tangkap event sebelum instalasi (A2HS)
  window.addEventListener('beforeinstallprompt', (e) => {
    e.preventDefault();
    deferredPrompt = e;
    
    // Jangan munculkan jika user sudah pernah menutup
    const isDismissed = sessionStorage.getItem('pwa_banner_dismissed') || localStorage.getItem('pwa_banner_dismissed');
    if (!isDismissed) {
      const installBanner = document.getElementById('pwaInstallBanner');
      if (installBanner) {
        installBanner.style.display = 'block';
      }
    }
  });

  const btnInstall = document.getElementById('btnPwaInstall');
  if (btnInstall) {
    btnInstall.addEventListener('click', async () => {
      if (deferredPrompt) {
        deferredPrompt.prompt();
        const { outcome } = await deferredPrompt.userChoice;
        console.log(`User respon instalasi: ${outcome}`);
        deferredPrompt = null;
        const installBanner = document.getElementById('pwaInstallBanner');
        if (installBanner) installBanner.style.display = 'none';
        sessionStorage.setItem('pwa_banner_dismissed', '1');
      }
    });
  }

  const btnClosePwa = document.getElementById('btnClosePwa');
  if (btnClosePwa) {
    btnClosePwa.addEventListener('click', (e) => {
      e.stopPropagation();
      const installBanner = document.getElementById('pwaInstallBanner');
      if (installBanner) installBanner.style.display = 'none';
      sessionStorage.setItem('pwa_banner_dismissed', '1');
      localStorage.setItem('pwa_banner_dismissed', '1');
    });
  }

  // Notifikasi Button Trigger
  const btnNotifPrompt = document.getElementById('btnEnableNotif');
  if (btnNotifPrompt) {
    btnNotifPrompt.addEventListener('click', requestNotificationPermission);
  }
}

// Permintaan Izin Notifikasi Web / PWA
async function requestNotificationPermission() {
  if (!('Notification' in window)) {
    alert('Peramban Anda tidak mendukung notifikasi web.');
    return;
  }

  const permission = await Notification.requestPermission();
  if (permission === 'granted') {
    showLocalNotification(
      'Notifikasi Sapa Warga Aktif! 🔔',
      'Terima kasih! Anda akan menerima update langsung terkait perkembangan desa dan tindak lanjut aspirasi.'
    );
    const btn = document.getElementById('btnEnableNotif');
    if (btn) {
      btn.innerHTML = '<i class="bi bi-bell-fill me-1"></i> Notifikasi Aktif';
      btn.classList.replace('btn-outline-danger', 'btn-success');
      btn.disabled = true;
    }
  } else {
    alert('Izin notifikasi tidak diberikan. Anda tetap dapat membaca update di website.');
  }
}

// Tampilkan Notifikasi Lokal / Push
function showLocalNotification(title, body) {
  if (Notification.permission === 'granted') {
    if ('serviceWorker' in navigator && navigator.serviceWorker.controller) {
      navigator.serviceWorker.controller.postMessage({
        type: 'SHOW_NOTIFICATION',
        title: title,
        body: body
      });
    } else {
      new Notification(title, {
        body: body,
        icon: 'assets/images/icons/icon-192.png',
        badge: 'assets/images/icons/icon-192.png'
      });
    }
  }
}

/* ==========================================================================
   3. Interaktivitas Formulir & Feed Aspirasi (Sapa Warga)
   ========================================================================== */
function initAspirasiInteractions() {
  // Preview Upload Foto Aspirasi
  const inputFoto = document.getElementById('uploadFotoAspirasi');
  const previewBox = document.getElementById('previewFotoAspirasi');
  const previewImg = document.getElementById('imgPreviewFoto');

  if (inputFoto && previewBox && previewImg) {
    inputFoto.addEventListener('change', function() {
      const file = this.files[0];
      if (file) {
        if (file.size > 5 * 1024 * 1024) {
          alert('Ukuran file terlalu besar! Maksimal 5 MB.');
          this.value = '';
          previewBox.style.display = 'none';
          return;
        }
        const reader = new FileReader();
        reader.onload = (e) => {
          previewImg.src = e.target.result;
          previewBox.style.display = 'block';
        };
        reader.readAsDataURL(file);
      } else {
        previewBox.style.display = 'none';
      }
    });
  }

  // Filter Dusun & Status pada Feed Aspirasi
  const filterStatus = document.getElementById('filterStatusAspirasi');
  const listItems = document.querySelectorAll('.aspirasi-item-row');

  function applyAspirasiFilter() {
    const selectedStatus = filterStatus ? filterStatus.value.toLowerCase() : 'all';

    listItems.forEach((item) => {
      const status = (item.getAttribute('data-status') || '').toLowerCase();
      const matchStatus = (selectedStatus === 'all' || status === selectedStatus);

      if (matchStatus) {
        item.style.display = 'block';
      } else {
        item.style.display = 'none';
      }
    });
  }

  if (filterStatus) filterStatus.addEventListener('change', applyAspirasiFilter);
}

/* ==========================================================================
   4. Pencarian Cepat Global (Search Modal)
   ========================================================================== */
function initSearchModal() {
  const searchInput = document.getElementById('globalSearchInput');
  const searchResults = document.getElementById('globalSearchResults');

  if (searchInput && searchResults) {
    searchInput.addEventListener('input', function() {
      const query = this.value.trim().toLowerCase();
      if (query.length < 2) {
        searchResults.innerHTML = '<p class="text-muted small">Ketik minimal 2 karakter untuk mencari program, visi-misi, atau aspirasi...</p>';
        return;
      }

      const searchableCards = document.querySelectorAll('[data-search-content]');
      let matches = [];

      searchableCards.forEach((card) => {
        const text = card.getAttribute('data-search-content').toLowerCase();
        const title = card.getAttribute('data-search-title') || 'Informasi';
        const url = card.getAttribute('data-search-url') || '#';

        if (text.includes(query)) {
          matches.push({ title, text, url });
        }
      });

      if (matches.length > 0) {
        let html = '<div class="list-group list-group-flush">';
        matches.slice(0, 5).forEach((m) => {
          html += `
            <a href="${m.url}" class="list-group-item list-group-item-action py-2">
              <div class="fw-bold text-danger">${m.title}</div>
              <div class="small text-muted text-truncate">${m.text.substring(0, 100)}...</div>
            </a>
          `;
        });
        html += '</div>';
        searchResults.innerHTML = html;
      } else {
        searchResults.innerHTML = `<p class="text-muted small">Tidak ditemukan hasil untuk "<strong>${query}</strong>".</p>`;
      }
    });
  }
}
