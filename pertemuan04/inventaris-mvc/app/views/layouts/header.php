<?php $flash = take_flash(); $loggedIn = !empty($_SESSION['user']); ?>
<!DOCTYPE html>
<html lang="id"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= isset($title) ? e($title) . ' - ' : '' ?><?= APP_NAME ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<?php if ($loggedIn): ?>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
<?php require ROOT_PATH . '/app/views/layouts/sidebar_style.php'; ?>
<?php endif; ?>
</head><body class="bg-light">
<?php if ($loggedIn): ?>
<?php require ROOT_PATH . '/app/views/layouts/sidebar.php'; ?>
<section class="home-section">
<div class="home-content">
<i class='bx bx-menu' title="Buka atau tutup menu"></i>
<span class="text"><?= e($title ?? APP_NAME) ?></span>
</div>
<main class="container-fluid px-4 pb-4">
<?php else: ?>
<main class="container py-4">
<?php endif; ?>
<?php if ($flash): ?>
<div class="alert alert-<?= e($flash['type']) ?>"><?= e($flash['message']) ?></div>
<?php endif; ?>