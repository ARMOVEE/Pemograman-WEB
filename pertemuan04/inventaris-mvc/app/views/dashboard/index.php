<?php require ROOT_PATH . '/app/views/layouts/header.php'; ?>
<h1 class="h3 mb-4">Dashboard</h1>

<div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-3 mb-4">
    <div class="col">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="text-muted small stat-label">Total Barang</div>
                <div class="fs-3 fw-bold stat-value" id="stat-items"><?= number_format((int) $totalItems, 0, ',', '.') ?></div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="text-muted small stat-label">Total Stok</div>
                <div class="fs-3 fw-bold stat-value" id="stat-stock"><?= number_format((int) $totalStock, 0, ',', '.') ?></div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="text-muted small stat-label">Nilai Aset</div>
                <div class="fs-3 fw-bold stat-value" id="stat-asset"><?= rupiah($totalAssetValue) ?></div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="text-muted small stat-label">Stok Menipis</div>
                <div class="fs-3 fw-bold stat-value <?= $lowStockCount > 0 ? 'text-danger' : '' ?>" id="stat-low"><?= number_format((int) $lowStockCount, 0, ',', '.') ?></div>
            </div>
        </div>
    </div>
    <div class="col col-12 col-md-auto col-lg">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="text-muted small stat-label">Transaksi Hari Ini</div>
                <div class="fs-3 fw-bold stat-value" id="stat-today"><?= number_format((int) $todayCount, 0, ',', '.') ?></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header fw-semibold">Stok Menipis (stok &le; <?= (int) $lowStockThreshold ?>)</div>
            <div class="table-responsive">
                <table class="table table-sm table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th class="text-end">Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($lowStockItems)): ?>
                            <tr><td colspan="4" class="text-center text-muted">Tidak ada barang dengan stok menipis.</td></tr>
                        <?php else: ?>
                            <?php foreach ($lowStockItems as $row): ?>
                                <tr>
                                    <td class="low-code"><?= e($row['code']) ?></td>
                                    <td><?= e($row['name']) ?></td>
                                    <td><?= e($row['category_name'] ?? '-') ?></td>
                                    <td class="text-end"><?= (int) $row['quantity'] ?> <?= e($row['unit']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header fw-semibold">Transaksi Terbaru</div>
            <div class="table-responsive">
                <table class="table table-sm table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Waktu</th>
                            <th>Barang</th>
                            <th>Jenis</th>
                            <th class="text-end">Jumlah</th>
                            <th>Oleh</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($recentTransactions)): ?>
                            <tr><td colspan="5" class="text-center text-muted">Belum ada transaksi.</td></tr>
                        <?php else: ?>
                            <?php foreach ($recentTransactions as $t): ?>
                                <tr>
                                    <td><?= e(date('d/m/Y H:i', strtotime($t['created_at']))) ?></td>
                                    <td><span class="recent-code"><?= e($t['item_code']) ?></span> <?= e($t['item_name']) ?></td>
                                    <td><span class="badge bg-<?= $t['type'] === 'IN' ? 'success' : 'danger' ?>"><?= $t['type'] === 'IN' ? 'Masuk' : 'Keluar' ?></span></td>
                                    <td class="text-end"><?= $t['type'] === 'IN' ? '+' : '-' ?><?= (int) $t['quantity'] ?></td>
                                    <td><?= e($t['user_name']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php require ROOT_PATH . '/app/views/layouts/footer.php'; ?>