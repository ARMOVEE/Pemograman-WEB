<?php /* partial */ ?>
<style>
:root {
    --accent: #1d4ed8;
    --accent-hover: #1e40af;
    --accent-soft: #eff4ff;
    --ink: #111827;
    --muted: #6b7280;
    --line: #e5e7eb;
    --bg: #f4f6f9;
    --speed: 0.25s;
    --ease: cubic-bezier(0.4, 0, 0.2, 1);
}

body { font-family: 'Poppins', sans-serif; }

/* Samakan warna tombol utama dengan halaman login */
body .btn-primary {
    --bs-btn-bg: var(--accent);
    --bs-btn-border-color: var(--accent);
    --bs-btn-hover-bg: var(--accent-hover);
    --bs-btn-hover-border-color: var(--accent-hover);
    --bs-btn-active-bg: #1e3a8a;
    --bs-btn-active-border-color: #1e3a8a;
    --bs-btn-disabled-bg: var(--accent);
    --bs-btn-disabled-border-color: var(--accent);
}
body .btn-outline-primary {
    --bs-btn-color: var(--accent);
    --bs-btn-border-color: var(--accent);
    --bs-btn-hover-bg: var(--accent);
    --bs-btn-hover-border-color: var(--accent);
    --bs-btn-active-bg: var(--accent);
    --bs-btn-active-border-color: var(--accent);
    --bs-btn-disabled-color: var(--accent);
    --bs-btn-disabled-border-color: var(--accent);
}

/* ===== Sidebar ===== */
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    width: 250px;
    background: #fff;
    border-right: 1px solid var(--line);
    z-index: 1030;
    overflow: hidden;
    transition: width var(--speed) var(--ease), box-shadow var(--speed) var(--ease);
}
.sidebar ul { margin: 0; padding: 0; }
.sidebar.close { width: 78px; }

.sidebar .logo-details {
    height: 60px;
    width: 100%;
    display: flex;
    align-items: center;
    border-bottom: 1px solid var(--line);
}
.sidebar .logo-details i {
    font-size: 28px;
    color: var(--accent);
    height: 50px;
    min-width: 78px;
    text-align: center;
    line-height: 50px;
}
/* flex:1 + min-width:0 + ellipsis => teks tidak pernah keluar dari sidebar */
.sidebar .logo-details .logo-name {
    flex: 1;
    min-width: 0;
    padding-right: 14px;
    font-size: 16px;
    color: var(--ink);
    font-weight: 600;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    transition: opacity 0.2s ease;
    transition-delay: 0.08s;
}
.sidebar.close .logo-details .logo-name {
    transition-delay: 0s;
    opacity: 0;
    pointer-events: none;
}

.sidebar .nav-links {
    height: 100%;
    padding: 16px 0 150px 0;
    overflow: auto;
}
.sidebar.close .nav-links { overflow: visible; }
.sidebar .nav-links::-webkit-scrollbar { display: none; }

.sidebar .nav-links li {
    position: relative;
    list-style: none;
    margin: 2px 12px;
    border-radius: 8px;
    transition: background 0.2s ease;
}
.sidebar .nav-links li.nav-label {
    margin: 6px 12px;
    padding-left: 17px;
    font-size: 0.7rem;
    font-weight: 600;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: #9ca3af;
    white-space: nowrap;
    overflow: hidden;
    transition: opacity 0.2s ease;
}
.sidebar.close .nav-links li.nav-label { opacity: 0; }
.sidebar .nav-links li:not(.active):not(.nav-label):hover { background: #f3f4f6; }
.sidebar .nav-links li.active { background: var(--accent-soft); }

.sidebar .nav-links li a {
    display: flex;
    align-items: center;
    height: 44px;
    text-decoration: none;
    color: #4b5563;
}
.sidebar .nav-links li:hover a { color: var(--ink); }
.sidebar .nav-links li.active a { color: var(--accent); }
.sidebar .nav-links li a i {
    min-width: 54px;
    text-align: center;
    font-size: 20px;
    color: inherit;
}
.sidebar .nav-links li a .link-name {
    font-size: 14.5px;
    font-weight: 500;
    color: inherit;
    white-space: nowrap;
    transition: opacity 0.2s ease;
}
.sidebar .nav-links li.active a .link-name { font-weight: 600; }

/* Sidebar tertutup (rail ikon): label disembunyikan, muncul saat sidebar melebar */
.sidebar.close .nav-links li a .link-name { opacity: 0; pointer-events: none; }

/* Profil pengguna di bawah sidebar */
.sidebar .profile-details {
    position: absolute;
    left: 0;
    right: 0;
    bottom: 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    padding: 12px 12px 12px 16px;
    background: #fff;
    border-top: 1px solid var(--line);
}
.sidebar.close .profile-details {
    justify-content: center;
    padding: 12px 0;
}
.sidebar .profile-details .profile-info {
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: 0;
}
.sidebar.close .profile-details .profile-info { display: none; }
.sidebar .profile-details .avatar {
    flex: 0 0 36px;
    width: 36px;
    height: 36px;
    display: grid;
    place-items: center;
    border-radius: 50%;
    background: var(--accent-soft);
    color: var(--accent);
    font-size: 14px;
    font-weight: 600;
}
.sidebar .profile-details .name-job { min-width: 0; }
.sidebar .profile-details .profile-name,
.sidebar .profile-details .job {
    max-width: 120px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.sidebar .profile-details .profile-name {
    color: var(--ink);
    font-size: 14px;
    font-weight: 600;
    line-height: 1.3;
}
.sidebar .profile-details .job {
    color: var(--muted);
    font-size: 12px;
    text-transform: capitalize;
}
.sidebar .profile-details .btn-logout {
    flex: 0 0 auto;
    width: 36px;
    height: 36px;
    display: grid;
    place-items: center;
    padding: 0;
    background: none;
    border: 0;
    border-radius: 8px;
    color: var(--muted);
    cursor: pointer;
    transition: background 0.2s ease, color 0.2s ease;
}
.sidebar .profile-details .btn-logout:hover { background: #fef2f2; color: #dc3545; }
.sidebar .profile-details .btn-logout i { font-size: 20px; }

/* ===== Sidebar tertutup: melebar otomatis saat kursor menyentuhnya =====
   Melebar di atas konten (konten tidak bergeser). Tombol tiga garis
   tetap berfungsi untuk membuka sidebar secara permanen. */
@media (min-width: 769px) and (hover: hover) {
    .sidebar.close:hover {
        width: 250px;
        box-shadow: 4px 0 24px rgba(17, 24, 39, 0.08);
        transition-delay: 0.08s;
    }
    .sidebar.close:hover .logo-details .logo-name {
        opacity: 1;
        pointer-events: auto;
        transition-delay: 0.08s;
    }
    .sidebar.close:hover .nav-links li.nav-label { opacity: 1; }
    .sidebar.close:hover .nav-links li a .link-name {
        opacity: 1;
        pointer-events: auto;
        transition-delay: 0.1s;
    }
    .sidebar.close:hover .profile-details {
        justify-content: space-between;
        padding: 12px 12px 12px 16px;
    }
    .sidebar.close:hover .profile-details .profile-info {
        display: flex;
        animation: navFadeIn 0.25s ease;
    }
}
@keyframes navFadeIn { from { opacity: 0; } to { opacity: 1; } }

/* ===== Area konten ===== */
.home-section {
    margin-left: 250px;
    min-height: 100vh;
    background: var(--bg);
    transition: margin-left var(--speed) var(--ease);
}
.sidebar.close ~ .home-section { margin-left: 78px; }

/* Topbar: putih, tinggi sama dengan logo sidebar agar garisnya sejajar */
.home-section .home-content {
    height: 60px;
    display: flex;
    align-items: center;
    padding: 0 18px;
    background: #fff;
    border-bottom: 1px solid var(--line);
}
.home-section .home-content .bx-menu {
    color: #4b5563;
    font-size: 24px;
    padding: 6px;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.2s ease, transform 0.15s ease;
}
.home-section .home-content .bx-menu:hover { background: #f3f4f6; }
.home-section .home-content .bx-menu:active { transform: scale(0.9); }
/* Di desktop sidebar melebar sendiri saat di-hover, jadi tombol tiga garis disembunyikan.
   Di mobile/layar sentuh tombol ini tetap tampil karena itu satu-satunya cara membuka menu. */
@media (min-width: 769px) and (hover: hover) {
    .home-section .home-content .bx-menu { display: none; }
}
/* judul di topbar disembunyikan: judul halaman cukup dari <h1> di isi halaman */
.home-section .home-content .text { display: none; }

/* ===== Kartu & tabel (dashboard, daftar barang, dll.) ===== */
.home-section .card {
    border: 1px solid var(--line);
    border-radius: 10px;
    box-shadow: 0 1px 2px rgba(17, 24, 39, 0.04);
    overflow: hidden;
}
.home-section .card-header {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 14px 18px;
    background: #fff;
    border-bottom: 1px solid var(--line);
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--ink);
}
/* tambahkan class "card-alert" pada kartu untuk titik merah di judulnya */
.home-section .card-alert .card-header::before {
    content: '';
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #dc3545;
}

.home-section .table { margin-bottom: 0; }
.home-section .table thead th {
    padding: 10px 12px;
    background: #f9fafb;
    color: var(--muted);
    font-size: 0.74rem;
    font-weight: 600;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    white-space: nowrap;
    border-bottom: 1px solid var(--line);
}
.home-section .table td {
    padding: 12px;
    vertical-align: middle;
    font-size: 0.9rem;
    border-color: #f1f3f5;
}
.home-section .table th:first-child,
.home-section .table td:first-child { padding-left: 18px; white-space: nowrap; }
.home-section .table th:last-child,
.home-section .table td:last-child { padding-right: 18px; }
.home-section .table > tbody > tr:hover > * { --bs-table-bg-state: #f9fafb; }
.home-section .table td.text-end {
    font-weight: 600;
    font-variant-numeric: tabular-nums;
    white-space: nowrap;
}

.home-section .badge {
    padding: 0.45em 0.85em;
    border-radius: 999px;
    font-size: 0.74rem;
    font-weight: 600;
    white-space: nowrap;
}

/* ===== Kartu statistik dashboard ===== */
.stat-card .card-body { padding: 1rem; }
.stat-card .stat-label { font-size: 0.78rem; color: var(--muted); margin-bottom: 2px; }
.stat-card .stat-value { font-size: 1.45rem; font-weight: 600; color: var(--ink); line-height: 1.3; }
.stat-card .stat-value.text-danger { color: #dc3545 !important; }

/* ===== Responsif ===== */
@media (max-width: 768px) {
    .sidebar { box-shadow: 0 0 30px rgba(17, 24, 39, 0.15); }
    .home-section,
    .sidebar.close ~ .home-section { margin-left: 0; }
    .sidebar.close { width: 0; overflow: hidden; border-right: 0; box-shadow: none; }
    .sidebar.close .profile-details { display: none; }

    /* Kartu statistik: font lebih kecil */
    .stat-card .stat-value { font-size: 1.15rem; }
    .stat-card .card-body { padding: 0.75rem; }

    /* Tabel: padding dikurangi */
    .home-section .table td,
    .home-section .table thead th { padding: 8px 6px; font-size: 0.8rem; }
    .home-section .table th:first-child,
    .home-section .table td:first-child { padding-left: 10px; }
    .home-section .table th:last-child,
    .home-section .table td:last-child { padding-right: 10px; }
}

@media (max-width: 480px) {
    .stat-card .stat-value { font-size: 1rem; }
    .stat-card .stat-label { font-size: 0.72rem; }
    .home-section .home-content { padding: 0 10px; }
}

/* Hormati pengaturan "kurangi gerakan" di perangkat pengguna */
@media (prefers-reduced-motion: reduce) {
    .sidebar,
    .sidebar *,
    .home-section,
    .home-section .home-content .bx-menu { transition: none !important; animation: none !important; }
}
</style>