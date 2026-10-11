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
?>
<div class="sidebar">
    <div class="logo-details">
        <i class='bx bx-package'></i>
        <span class="logo-name" title="<?= e(APP_NAME) ?>"><?= e(APP_NAME) ?></span>
    </div>
    <ul class="nav-links">
        <?php foreach ($navItems as $item): ?>
        <li class="<?= $navIs($item['match']) ? 'active' : '' ?>">
            <a href="<?= base_url($item['url']) ?>">
                <i class='bx <?= $item['icon'] ?>'></i>
                <span class="link-name"><?= e($item['label']) ?></span>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
    <div class="profile-details">
        <div class="name-job">
            <div class="profile-name"><?= e($_SESSION['user']['full_name']) ?></div>
            <div class="job"><?= e($_SESSION['user']['role']) ?></div>
        </div>
        <form method="post" action="<?= base_url('auth/logout') ?>" class="m-0">
            <button type="submit" class="btn-logout" title="Keluar" aria-label="Keluar"><i class='bx bx-log-out'></i></button>
        </form>
    </div>
</div>