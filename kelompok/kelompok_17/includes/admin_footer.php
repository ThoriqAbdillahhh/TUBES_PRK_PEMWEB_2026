<?php
// Layout bawah halaman admin (desain baru). Menutup <main>, wrapper, dan dokumen,
// lalu memuat JavaScript untuk sidebar mobile (drawer).
?>
    </main>
</div>

<script>
(function () {
    var sidebar = document.getElementById('admin-sidebar');
    var overlay = document.getElementById('admin-sidebar-overlay');
    var tombolBuka = document.getElementById('admin-sidebar-buka');
    var tombolTutup = document.getElementById('admin-sidebar-tutup');
    if (!sidebar || !overlay || !tombolBuka || !tombolTutup) { return; }

    var layarMd = window.matchMedia('(min-width: 768px)');
    var terbuka = false;

    // Menerapkan keadaan: drawer hanya berlaku di layar kecil. Di md ke atas sidebar selalu tampil.
    function terapkan() {
        var drawerTertutup = !layarMd.matches && !terbuka;
        sidebar.classList.toggle('-translate-x-full', !terbuka);
        overlay.classList.toggle('hidden', !terbuka || layarMd.matches);
        tombolBuka.setAttribute('aria-expanded', terbuka && !layarMd.matches ? 'true' : 'false');
        // Saat drawer tertutup di layar kecil, link di dalamnya tidak boleh bisa difokus keyboard.
        if ('inert' in sidebar) { sidebar.inert = drawerTertutup; }
    }

    function buka() {
        terbuka = true;
        terapkan();
        tombolTutup.focus();
    }

    function tutup(kembalikanFokus) {
        terbuka = false;
        terapkan();
        if (kembalikanFokus) { tombolBuka.focus(); }
    }

    tombolBuka.addEventListener('click', buka);
    tombolTutup.addEventListener('click', function () { tutup(true); });
    overlay.addEventListener('click', function () { tutup(true); });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && terbuka && !layarMd.matches) { tutup(true); }
    });
    // Jika layar diperbesar ke ukuran tablet/desktop, reset keadaan drawer.
    layarMd.addEventListener('change', function () { terbuka = false; terapkan(); });

    terapkan();
})();
</script>
</body>
</html>