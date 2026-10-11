<div class="mb-3">
    <label for="name" class="form-label">Nama Kategori</label>
    <input type="text" id="name" name="name" class="form-control" maxlength="100" required
           value="<?= e($category['name'] ?? '') ?>">
</div>
<div class="mb-3">
    <label for="description" class="form-label">Deskripsi</label>
    <textarea id="description" name="description" class="form-control" rows="3"><?= e($category['description'] ?? '') ?></textarea>
</div>
