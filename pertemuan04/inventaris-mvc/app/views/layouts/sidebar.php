<?php
$navUrl = $_GET['url'] ?? '';
$navSegment = is_string($navUrl) ? explode('/', trim($navUrl, '/'))[0] : '';
$navIs = fn (array $names): bool => in_array($navSegment, $names, true);

$navItems = [
    ['label' => 'Dashboard', 'url' => '/',            'icon' => 'bx-grid-alt',   'match' => ['', 'home', 'dashboard']],
    ['label' => 'Barang',    'url' => 'items',        'icon' => 'bx-collection', 'match' => ['items']],
    ['label' => 'Kategori',  'url' => 'categories',   'icon' => 'bx-category',   'match' => ['categories']],
    ['label' => 'Transaksi', 'url' => 'transactions', 'icon' => 'bx-transfer',   'match' => ['transactions']],
];

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
        <?php foreach ($navItems as $item): ?>
        <?php $isActive = $navIs($item['match']); ?>
        <li class="<?= $isActive ? 'active' : '' ?>">
            <a href="<?= base_url($item['url']) ?>"<?= $isActive ? ' aria-current="page"' : '' ?>>
                <i class='bx <?= $item['icon'] ?>'></i>
                <span class="link-name"><?= e($item['label']) ?></span>
            </a>
        </li>
        <?php endforeach; ?>
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
            <button type="submit" class="btn-logout" title="Keluar" aria-label="Keluar"><i class='bx bx-log-out'></i></button>
        </form>
    </div>
</div>