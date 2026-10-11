<?php require ROOT_PATH . '/app/views/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Data Kategori</h1>
    <a href="<?= base_url('categories/create') ?>" class="btn btn-primary">Tambah Kategori</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th class="text-center">Jumlah Barang</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($categories)): ?>
                <tr><td colspan="5" class="text-center text-muted">Belum ada kategori.</td></tr>
            <?php endif; ?>
            <?php foreach ($categories as $i => $c): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= e($c['name']) ?></td>
                    <td><?= e($c['description']) ?></td>
                    <td class="text-center"><?= (int) $c['item_count'] ?></td>
                    <td class="text-end">
                        <a href="<?= base_url('categories/edit/' . (int) $c['id']) ?>" class="btn btn-sm btn-outline-secondary">Ubah</a>
                        <form method="post" action="<?= base_url('categories/delete/' . (int) $c['id']) ?>" class="d-inline"
                              onsubmit="return confirm('Hapus kategori ini? Barang di dalamnya tidak ikut terhapus, tetapi menjadi tanpa kategori.')">
                            <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require ROOT_PATH . '/app/views/layouts/footer.php'; ?>
