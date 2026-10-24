<?php
/**
 * Uji otomatis sederhana tanpa framework.
 * Jalankan: php tests/run.php
 */
require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/core/helpers.php';
require_once __DIR__ . '/../app/core/Security.php';
require_once __DIR__ . '/../app/core/Middleware.php';
require_once __DIR__ . '/../app/core/Csv.php';

// Session harus dimulai sebelum output (CLI juga).
Security::startSession();

$passed = 0;
$failed = 0;

function check(string $label, bool $condition): void
{
    global $passed, $failed;
    if ($condition) {
        $passed++;
        echo " PASS {$label}\n";
    } else {
        $failed++;
        echo " FAIL {$label}\n";
    }
}

echo "RBAC — matriks izin\n";
check('admin boleh semua izin', Middleware::roleCan('admin', 'logs.view'));
check('manager boleh membuat barang', Middleware::roleCan('manager', 'items.create'));
check('manager tidak boleh memulihkan sampah', !Middleware::roleCan('manager', 'items.restore'));
check('staff tidak boleh membuat barang', !Middleware::roleCan('staff', 'items.create'));
check('staff boleh mencatat transaksi', Middleware::roleCan('staff', 'transactions.create'));
check('role tidak dikenal ditolak', !Middleware::roleCan('guest', 'items.view'));

echo "\nCSV — proteksi formula injection\n";
check('formula = dinetralkan', Csv::safe('=1+1') === "'=1+1");
check('formula + dinetralkan', Csv::safe('+cmd') === "'+cmd");
check('formula @ dinetralkan', Csv::safe('@SUM(A1)') === "'@SUM(A1)");
check('teks biasa tidak diubah', Csv::safe('Laptop Lenovo') === 'Laptop Lenovo');
check('angka tidak diubah', Csv::safe(12500000) === '12500000');
check('teks kosong tetap kosong', Csv::safe('') === '');

echo "\nCSRF — token konstan-waktu\n";
$token = Security::csrfToken();
check('token dibuat', strlen($token) === 64);
check('token benar diterima', Security::verifyCsrf($token));
check('token salah ditolak', !Security::verifyCsrf('token-palsu'));
check('token kosong ditolak', !Security::verifyCsrf(''));
check('token null ditolak', !Security::verifyCsrf(null));

echo "\nInput — query & form\n";
$_GET['array_test'] = ['a' => 1];
$_GET['trim_test'] = ' abc ';
check('query array ditolak', query_param('array_test', 'default') === 'default');
check('query string di-trim', query_param('trim_test') === 'abc');
$_POST = ['nama' => ' Budi '];
$post = post_input();
check('post string di-trim', $post['nama'] === 'Budi');

echo "\nKonfigurasi\n";
check('batas unggahan > 0', UPLOAD_MAX_BYTES > 0);
check('timeout sesi > 0', SESSION_IDLE_TIMEOUT > 0);

echo "\n----------------------------------------\n";
echo "Lulus: {$passed} | Gagal: {$failed}\n";
exit($failed === 0 ? 0 : 1);
