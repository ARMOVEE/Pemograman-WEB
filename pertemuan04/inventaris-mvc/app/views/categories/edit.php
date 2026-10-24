<?php require ROOT_PATH . '/app/views/layouts/header.php'; ?>

<?php if (empty($category) || empty($category['id'])): ?>
    <div class="alert alert-danger">
        Data kategori tidak ditemukan. <a href="<?= base_url('categories') ?>" class="alert-link">Kembali ke daftar kategori</a>
    </div>
<?php require ROOT_PATH . '/app/views/layouts/footer.php'; return; endif; ?>

<h1 class="h3 mb-3">Ubah Kategori</h1>

<div class="card">
    <div class="card-body">
        <form method="post" action="<?= base_url('categories/update/' . (int) ($category['id'] ?? 0)) ?>">
            <?= csrf_field() ?>
            <?php require ROOT_PATH . '/app/views/categories/_form.php'; ?>
            <a href="<?= base_url('categories') ?>" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Perbarui</button>
        </form>
    </div>
</div>

<?php require ROOT_PATH . '/app/views/layouts/footer.php'; ?>
