<?php require ROOT_PATH . '/app/views/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Riwayat Transaksi</h1>
    <a href="<?= base_url('items') ?>" class="btn btn-outline-secondary">Kembali ke Barang</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-striped align-middle mb-0">
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>Barang</th>
                    <th>Tipe</th>
                    <th class="text-end">Jumlah</th>
                    <th>Catatan</th>
                    <th>Oleh</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($transactions)): ?>
                <tr><td colspan="6" class="text-center text-muted">Belum ada transaksi.</td></tr>
            <?php endif; ?>
            <?php foreach ($transactions as $t): ?>
                <tr>
                    <td><?= e($t['created_at']) ?></td>
                    <td><?= e($t['item_code']) ?> - <?= e($t['item_name']) ?></td>
                    <td>
                        <?php if ($t['type'] === 'IN'): ?>
                            <span class="badge text-bg-success">Masuk</span>
                        <?php else: ?>
                            <span class="badge text-bg-danger">Keluar</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-end"><?= (int) $t['quantity'] ?> <?= e($t['unit']) ?></td>
                    <td><?= e($t['notes'] ?? '-') ?></td>
                    <td><?= e($t['user_name'] ?? '-') ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require ROOT_PATH . '/app/views/layouts/footer.php'; ?>
