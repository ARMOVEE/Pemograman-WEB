<?php require ROOT_PATH . '/app/views/layouts/header.php'; ?>

<h1 class="h3 mb-3">Ubah Barang</h1>

<div class="card">
    <div class="card-body">
        <form method="post" action="<?= base_url('items/update/' . (int) $item['id']) ?>">
            <?php require ROOT_PATH . '/app/views/items/_form.php'; ?>
            <a href="<?= base_url('items') ?>" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Perbarui</button>
        </form>
    </div>
</div>

<?php require ROOT_PATH . '/app/views/layouts/footer.php'; ?>
