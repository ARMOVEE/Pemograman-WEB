#!/usr/bin/env php
<?php
if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit("Skrip ini hanya boleh dijalankan dari CLI.\n");
}

require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/core/helpers.php';

spl_autoload_register(function ($class) {
    foreach (['core', 'controllers', 'models'] as $dir) {
        $file = ROOT_PATH . '/app/' . $dir . '/' . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

$username = $argv[1] ?? '';
$name     = $argv[2] ?? 'cli';

if ($username === '') {
    fwrite(STDERR, "Pemakaian: php bin/make-api-token.php <username> [nama-token]\n");
    exit(1);
}

$user = (new User())->findByUsername($username);
if (!$user) {
    fwrite(STDERR, "Pengguna aktif '{$username}' tidak ditemukan.\n");
    exit(1);
}

$token = (new ApiToken())->issue((int) $user['id'], $name);
echo "Token API untuk {$user['username']} ({$user['role']}) berhasil dibuat.\n";
echo "Simpan sekarang — token tidak dapat ditampilkan lagi:\n\n";
echo $token . "\n";
