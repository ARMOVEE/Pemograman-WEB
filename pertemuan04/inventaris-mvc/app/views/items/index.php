<?php require ROOT_PATH . '/app/views/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Data Barang</h1>
    <div>
        <a href="<?= base_url('transactions') ?>" class="btn btn-outline-secondary">Riwayat Transaksi</a>
        <a href="<?= base_url('items/create') ?>" class="btn btn-primary">Tambah Barang</a>
    </div>
</div>

<form method="get" action="<?= base_url('items') ?>" class="row g-2 mb-3">
    <div class="col-md-4">
        <input type="text" name="search" class="form-control" placeholder="Cari kode, nama, atau kategori"
               value="<?= e($search) ?>">
    </div>
    <div class="col-md-3">
        <select name="category" class="form-select">
            <option value="">Semua kategori</option>
            <?php foreach ($categories as $c): ?>
                <option value="<?= (int) $c['id'] ?>" <?= ((string) $c['id'] === $category) ? 'selected' : '' ?>>
                    <?= e($c['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-2">
        <select name="limit" class="form-select">
            <?php foreach ($limits as $l): ?>
                <option value="<?= (int) $l ?>" <?= ((int) $l === $limit) ? 'selected' : '' ?>><?= (int) $l ?> per halaman</option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-3 d-flex gap-2">
        <button type="submit" class="btn btn-primary">Cari</button>
        <a href="<?= base_url('items') ?>" class="btn btn-outline-secondary">Reset</a>
    </div>
</form>

<div class="card">
    <div class="table-responsive">
        <table class="table table-striped align-middle mb-0">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th class="text-end">Stok</th>
                    <th class="text-end">Harga</th>
                    <th>Tgl Masuk</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($items)): ?>
                <tr><td colspan="7" class="text-center text-muted">Tidak ada barang yang ditemukan.</td></tr>
            <?php endif; ?>
            <?php foreach ($items as $row): ?>
                <tr>
                    <td><?= e($row['code']) ?></td>
                    <td><?= e($row['name']) ?></td>
                    <td><?= e($row['category_name'] ?? '-') ?></td>
                    <td class="text-end">
                        <?= (int) $row['quantity'] ?> <?= e($row['unit']) ?>
                        <?php if ((int) $row['quantity'] <= 5): ?>
                            <span class="badge text-bg-warning">Stok menipis</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-end"><?= rupiah($row['price']) ?></td>
                    <td><?= e($row['entry_date'] ?? '-') ?></td>
                    <td class="text-end text-nowrap">
                        <button type="button" class="btn btn-sm btn-outline-success"
                                data-bs-toggle="modal" data-bs-target="#stockInModal"
                                data-item-id="<?= (int) $row['id'] ?>" data-item-name="<?= e($row['name']) ?>">Masuk</button>
                        <button type="button" class="btn btn-sm btn-outline-warning"
                                data-bs-toggle="modal" data-bs-target="#stockOutModal"
                                data-item-id="<?= (int) $row['id'] ?>" data-item-name="<?= e($row['name']) ?>">Keluar</button>
                        <a href="<?= base_url('items/edit/' . (int) $row['id']) ?>" class="btn btn-sm btn-outline-secondary">Ubah</a>
                        <form method="post" action="<?= base_url('items/delete/' . (int) $row['id']) ?>" class="d-inline"
                              onsubmit="return confirm('Hapus barang ini? Riwayat transaksinya juga ikut terhapus.')">
                            <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php if ($totalData > 0): ?>
<?php
    $baseQuery = array_filter(
        ['search' => $search, 'category' => $category, 'limit' => $limit],
        fn ($v) => $v !== ''
    );
    $pageUrl = fn (int $p) => base_url('items') . '?' . http_build_query($baseQuery + ['page' => $p]);
    $start = max(1, $page - 2);
    $end = min($totalPages, $page + 2);
?>
<div class="d-flex justify-content-between align-items-center mt-3">
    <small class="text-muted">
        <?php if (!empty($items)): ?>
            Menampilkan <?= ($page - 1) * $limit + 1 ?>-<?= ($page - 1) * $limit + count($items) ?> dari <?= (int) $totalData ?> barang
        <?php else: ?>
            Halaman <?= (int) $page ?> di luar jangkauan (total <?= (int) $totalData ?> barang)
        <?php endif; ?>
    </small>
    <?php if ($totalPages > 1): ?>
    <nav aria-label="Navigasi halaman">
        <ul class="pagination pagination-sm mb-0">
            <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= e($pageUrl($page - 1)) ?>">Previous</a>
            </li>
            <?php for ($p = $start; $p <= $end; $p++): ?>
                <li class="page-item <?= $p === $page ? 'active' : '' ?>">
                    <a class="page-link" href="<?= e($pageUrl($p)) ?>"><?= $p ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= e($pageUrl($page + 1)) ?>">Next</a>
            </li>
        </ul>
    </nav>
    <?php endif; ?>
</div>
<?php endif; ?>

<div class="modal fade" id="stockInModal" tabindex="-1" aria-labelledby="stockInLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" action="<?= base_url('transactions/stockIn') ?>" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="stockInLabel">Barang Masuk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="item_id" value="">
                <p class="mb-3">Barang: <strong class="item-name"></strong></p>
                <div class="mb-3">
                    <label for="in_quantity" class="form-label">Jumlah</label>
                    <input type="number" id="in_quantity" name="quantity" class="form-control" min="1" step="1" required>
                </div>
                <div class="mb-3">
                    <label for="in_notes" class="form-label">Catatan</label>
                    <input type="text" id="in_notes" name="notes" class="form-control" maxlength="255">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="stockOutModal" tabindex="-1" aria-labelledby="stockOutLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" action="<?= base_url('transactions/stockOut') ?>" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="stockOutLabel">Barang Keluar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="item_id" value="">
                <p class="mb-3">Barang: <strong class="item-name"></strong></p>
                <div class="mb-3">
                    <label for="out_quantity" class="form-label">Jumlah</label>
                    <input type="number" id="out_quantity" name="quantity" class="form-control" min="1" step="1" required>
                </div>
                <div class="mb-3">
                    <label for="out_notes" class="form-label">Catatan</label>
                    <input type="text" id="out_notes" name="notes" class="form-control" maxlength="255">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-warning">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
document.querySelectorAll('#stockInModal, #stockOutModal').forEach(function (modal) {
    modal.addEventListener('show.bs.modal', function (event) {
        var btn = event.relatedTarget;
        modal.querySelector('input[name="item_id"]').value = btn.getAttribute('data-item-id');
        modal.querySelector('.item-name').textContent = btn.getAttribute('data-item-name');
        modal.querySelector('input[name="quantity"]').value = '';
        modal.querySelector('input[name="notes"]').value = '';
    });
});
</script>

<?php require ROOT_PATH . '/app/views/layouts/footer.php'; ?>
