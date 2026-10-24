<div class="row g-3 mb-3">
    <div class="col-md-4">
        <label for="code" class="form-label">Kode Barang</label>
        <input type="text" id="code" name="code" class="form-control" maxlength="20" required readonly
               value="<?= e($item['code'] ?? '') ?>">
    </div>
    <div class="col-md-8">
        <label for="name" class="form-label">Nama Barang</label>
        <input type="text" id="name" name="name" class="form-control" maxlength="150" required
               value="<?= e($item['name'] ?? '') ?>">
    </div>
    <div class="col-md-6">
        <label for="category_id" class="form-label">Kategori</label>
        <select id="category_id" name="category_id" class="form-select">
            <option value="">- Tanpa kategori -</option>
            <?php foreach ($categories as $c): ?>
                <option value="<?= (int) $c['id'] ?>"
                    <?= ((int) ($item['category_id'] ?? 0) === (int) $c['id']) ? 'selected' : '' ?>>
                    <?= e($c['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-3">
        <label for="quantity" class="form-label">Stok</label>
        <input type="number" id="quantity" name="quantity" class="form-control" min="0" step="1"
               value="<?= (int) ($item['quantity'] ?? 0) ?>">
    </div>
    <div class="col-md-3">
        <label for="unit" class="form-label">Satuan</label>
        <input type="text" id="unit" name="unit" class="form-control" maxlength="20"
               value="<?= e($item['unit'] ?? 'unit') ?>">
    </div>
    <div class="col-md-6">
        <label for="price" class="form-label">Harga (Rp)</label>
        <input type="number" id="price" name="price" class="form-control" min="0" step="0.01"
               value="<?= e($item['price'] ?? 0) ?>">
    </div>
    <div class="col-md-6">
        <label for="entry_date" class="form-label">Tanggal Masuk</label>
        <input type="date" id="entry_date" name="entry_date" class="form-control"
               value="<?= e($item['entry_date'] ?? '') ?>">
    </div>
    <div class="col-12">
        <label for="description" class="form-label">Deskripsi</label>
        <textarea id="description" name="description" class="form-control" rows="3"><?= e($item['description'] ?? '') ?></textarea>
    </div>
    <div class="col-12">
        <label class="form-label">Foto Barang</label>
        <input type="file" name="photo" accept="image/jpeg,image/png,image/webp" class="form-control">
        <small class="text-muted">Format JPG, PNG, atau WEBP. Maksimal 2 MB.</small>
        <?php if (!empty($item['photo'])): ?>
        <div class="d-flex align-items-center gap-3 mt-3">
            <img src="<?= e(asset($item['photo'])) ?>" alt="Foto barang"
                 class="rounded border" style="width: 96px; height: 96px; object-fit: cover;">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remove_photo"
                       value="1" id="remove_photo">
                <label class="form-check-label" for="remove_photo">
                    Hapus foto saat menyimpan
                </label>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
