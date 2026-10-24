<?php
$navUrl = $_GET['url'] ?? '';
$navSegment = is_string($navUrl) ? explode('/', trim($navUrl, '/'))[0] : '';
$navIs = fn (array $names): bool => in_array($navSegment, $names, true);

$navItems = [
    ['label' => 'Dashboard', 'url' => '/',            'icon' => 'bx-grid-alt',         'match' => ['', 'home', 'dashboard']],
    ['label' => 'Barang',    'url' => 'items',        'icon' => 'bx-collection',       'match' => ['items'], 'permission' => 'items.view'],
    ['label' => 'Kategori',  'url' => 'categories',   'icon' => 'bx-category',         'match' => ['categories'], 'permission' => 'categories.view'],
    ['label' => 'Transaksi', 'url' => 'transactions', 'icon' => 'bx-transfer',         'match' => ['transactions'], 'permission' => 'transactions.view'],
    ['label' => 'Laporan',   'url' => 'reports',      'icon' => 'bx-bar-chart-alt-2',  'match' => ['reports'], 'permission' => 'reports.view'],
    ['label' => 'Pengguna',  'url' => 'users',        'icon' => 'bx-user',             'match' => ['users'], 'permission' => 'users.view'],
    ['label' => 'Log',       'url' => 'logs',         'icon' => 'bx-notepad',          'match' => ['logs'], 'permission' => 'logs.view'],
];

$navItems = array_filter(
    $navItems,
    static fn(array $nav): bool => !isset($nav['permission']) || Middleware::can($nav['permission'])
);

$navName = (string) ($_SESSION['user']['full_name'] ?? '');
$navInitial = function_exists('mb_substr')
    ? mb_strtoupper(mb_substr($navName, 0, 1))
    : strtoupper(substr($navName, 0, 1));
?>
<div class="sidebar close">
    <div class="logo-details">
        <i class='bx bx-package'></i>
        <span class="logo-name" title="<?= e(APP_NAME) ?>"><?= e(APP_NAME) ?></span>
    </div>
    <ul class="nav-links">
        <li class="nav-label">Menu</li>
        <?php foreach ($navItems as $navItem): ?>
        <?php $isActive = $navIs($navItem['match']); ?>
        <li class="<?= $isActive ? 'active' : '' ?>">
            <a href="<?= base_url($navItem['url']) ?>"<?= $isActive ? ' aria-current="page"' : '' ?>>
                <i class='bx <?= $navItem['icon'] ?>'></i>
                <span class="link-name"><?= e($navItem['label']) ?></span>
            </a>
        </li>
        <?php endforeach; ?>
        <?php unset($navItem, $isActive); ?>
    </ul>
    <div class="profile-details">
        <div class="profile-info">
            <div class="avatar" aria-hidden="true"><?= e($navInitial) ?></div>
            <div class="name-job">
                <div class="profile-name"><?= e($navName) ?></div>
                <div class="job"><?= e($_SESSION['user']['role']) ?></div>
            </div>
        </div>
        <form method="post" action="<?= base_url('auth/logout') ?>" class="m-0">
            <?= csrf_field() ?>
            <button type="submit" class="btn-logout" title="Keluar" aria-label="Keluar"><i class='bx bx-log-out'></i></button>
        </form>
    </div>
</div>