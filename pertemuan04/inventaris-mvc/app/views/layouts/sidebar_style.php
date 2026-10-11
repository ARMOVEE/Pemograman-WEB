<style>
body { font-family: 'Poppins', sans-serif; }

/* ===== Sidebar ===== */
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    width: 250px;
    background: #11101d;
    z-index: 1030;
    transition: all 0.5s ease;
}
.sidebar ul { margin: 0; padding: 0; }
.sidebar.close { width: 78px; }

.sidebar .logo-details {
    height: 60px;
    width: 100%;
    display: flex;
    align-items: center;
    border-bottom: 1px solid rgba(255, 255, 255, 0.06);
}
.sidebar .logo-details i {
    font-size: 30px;
    color: #fff;
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
    font-size: 17px;
    color: #fff;
    font-weight: 600;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    transition: 0.3s ease;
    transition-delay: 0.1s;
}
.sidebar.close .logo-details .logo-name {
    transition-delay: 0s;
    opacity: 0;
    pointer-events: none;
}

.sidebar .nav-links {
    height: 100%;
    padding: 20px 0 150px 0;
    overflow: auto;
}
.sidebar.close .nav-links { overflow: visible; }
.sidebar .nav-links::-webkit-scrollbar { display: none; }
.sidebar .nav-links li {
    position: relative;
    list-style: none;
    transition: background 0.3s ease;
}
.sidebar .nav-links li:hover,
.sidebar .nav-links li.active { background: #1d1b31; }
.sidebar .nav-links li.active { box-shadow: inset 3px 0 0 #0d6efd; }
.sidebar .nav-links li a {
    display: flex;
    align-items: center;
    text-decoration: none;
}
.sidebar .nav-links li a i {
    height: 50px;
    min-width: 78px;
    text-align: center;
    line-height: 50px;
    color: #fff;
    font-size: 20px;
}
.sidebar .nav-links li a .link-name {
    font-size: 18px;
    font-weight: 400;
    color: #fff;
    white-space: nowrap;
    transition: all 0.4s ease;
}

/* Sidebar tertutup: nama menu muncul sebagai tooltip saat di-hover */
.sidebar.close .nav-links li a .link-name {
    position: absolute;
    left: 100%;
    top: 50%;
    transform: translateY(-50%);
    margin-left: 8px;
    padding: 6px 14px;
    font-size: 15px;
    background: #1d1b31;
    border-radius: 6px;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.25);
    opacity: 0;
    pointer-events: none;
}
.sidebar.close .nav-links li:hover a .link-name { opacity: 1; }

.sidebar .profile-details {
    position: fixed;
    bottom: 0;
    width: 250px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #1d1b31;
    padding: 12px 0;
    transition: all 0.5s ease;
}
.sidebar.close .profile-details { background: none; width: 78px; }
.sidebar .profile-details .name-job { padding-left: 20px; min-width: 0; }
.sidebar.close .profile-details .name-job { display: none; }
.sidebar .profile-details .profile-name,
.sidebar .profile-details .job {
    color: #fff;
    font-size: 16px;
    font-weight: 500;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 130px;
}
.sidebar .profile-details .job {
    font-size: 12px;
    opacity: 0.7;
    text-transform: capitalize;
}
.sidebar .profile-details .btn-logout {
    background: none;
    border: 0;
    padding: 0;
    color: #fff;
    cursor: pointer;
}
.sidebar .profile-details .btn-logout i {
    display: block;
    height: 50px;
    min-width: 78px;
    text-align: center;
    line-height: 50px;
    font-size: 22px;
}

/* ===== Area konten ===== */
.home-section {
    margin-left: 250px;
    min-height: 100vh;
    background: #e4e9f7;
    transition: margin-left 0.5s ease;
}
.sidebar.close ~ .home-section { margin-left: 78px; }

/* Topbar: hanya tombol hamburger, judul halaman cukup dari isi halaman */
.home-section .home-content {
    height: 60px;
    display: flex;
    align-items: center;
    padding: 0 18px;
}
.home-section .home-content .bx-menu {
    color: #11101d;
    font-size: 28px;
    padding: 6px;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.2s ease;
}
.home-section .home-content .bx-menu:hover { background: rgba(17, 16, 29, 0.08); }
/* judul di topbar disembunyikan: judul halaman cukup dari <h1> di isi halaman */
.home-section .home-content .text { display: none; }

/* ===== Kartu & tabel (dashboard, daftar barang, dll.) ===== */
.home-section .card {
    border: 0;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(17, 16, 29, 0.08);
    overflow: hidden;
}
.home-section .card-header {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px 18px;
    background: #fff;
    border-bottom: 1px solid #eceef6;
    font-weight: 600;
    color: #11101d;
}
/* garis aksen di judul kartu; tambahkan class "card-alert" pada kartu untuk aksen merah */
.home-section .card-header::before {
    content: '';
    width: 4px;
    height: 18px;
    border-radius: 4px;
    background: #0d6efd;
}
.home-section .card-alert .card-header::before { background: #dc3545; }

.home-section .table { margin-bottom: 0; }
.home-section .table thead th {
    padding: 11px 12px;
    background: #f6f7fc;
    color: #5d6385;
    font-size: 0.82rem;
    font-weight: 600;
    white-space: nowrap;
    border-bottom: 1px solid #eceef6;
}
.home-section .table td {
    padding: 12px;
    vertical-align: middle;
    border-color: #f0f1f8;
}
.home-section .table th:first-child,
.home-section .table td:first-child { padding-left: 18px; white-space: nowrap; }
.home-section .table th:last-child,
.home-section .table td:last-child { padding-right: 18px; }
.home-section .table > tbody > tr:hover > * { --bs-table-bg-state: #f3f5ff; }
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

/* ===== Responsif: kartu statistik dashboard ===== */
.stat-card .card-body { padding: 1rem; }
.stat-card .stat-label { font-size: 0.78rem; color: #5d6385; margin-bottom: 2px; }
.stat-card .stat-value { font-size: 1.45rem; font-weight: 700; color: #11101d; line-height: 1.3; }
.stat-card .stat-value.text-danger { color: #dc3545 !important; }

@media (max-width: 768px) {
    .home-section,
    .sidebar.close ~ .home-section { margin-left: 0; }
    .sidebar.close { width: 0; overflow: hidden; }
    .sidebar.close .profile-details { display: none; }

    /* Kartu statistik: 2 kolom di mobile, font lebih kecil */
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
</style>