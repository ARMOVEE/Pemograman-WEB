<?php require ROOT_PATH . '/app/views/layouts/header.php'; ?>

<h1 class="h3 mb-3">Ubah Kategori</h1>

<div class="card">
    <div class="card-body">
        <form method="post" action="<?= base_url('categories/update/' . (int) $category['id']) ?>">
            <?php require ROOT_PATH . '/app/views/categories/_form.php'; ?>
            <a href="<?= base_url('categories') ?>" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Perbarui</button>
        </form>
    </div>
</div>

<?php require ROOT_PATH . '/app/views/layouts/footer.php'; ?>
