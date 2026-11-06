-- ============================================================
-- Migrasi Snapshot Transaksi & Proteksi Riwayat Data
-- ============================================================
USE db_inventory;

-- 1. Tambah kolom snapshot di tabel transactions jika belum ada
ALTER TABLE transactions
  ADD COLUMN IF NOT EXISTS item_code VARCHAR(20)  NULL AFTER item_id,
  ADD COLUMN IF NOT EXISTS item_name VARCHAR(150) NULL AFTER item_code,
  ADD COLUMN IF NOT EXISTS item_unit VARCHAR(20)  NULL AFTER item_name;

-- 2. Isi data snapshot untuk transaksi lama yang kolom snapshotnya masih NULL
UPDATE transactions t
JOIN items i ON t.item_id = i.id
SET t.item_code = COALESCE(t.item_code, i.code),
    t.item_name = COALESCE(t.item_name, i.name),
    t.item_unit = COALESCE(t.item_unit, i.unit)
WHERE t.item_name IS NULL OR t.item_code IS NULL;

-- 3. Ubah foreign key item_id agar ON DELETE SET NULL
--    sehingga riwayat transaksi TIDAK AKAN HILANG jika data barang dihapus
ALTER TABLE transactions DROP FOREIGN KEY IF EXISTS fk_transactions_item;

ALTER TABLE transactions
  MODIFY COLUMN item_id INT NULL,
  ADD CONSTRAINT fk_transactions_item FOREIGN KEY (item_id)
    REFERENCES items(id) ON DELETE SET NULL ON UPDATE CASCADE;
