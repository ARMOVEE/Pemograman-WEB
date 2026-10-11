<?php $flash = take_flash(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Masuk - <?= e(APP_NAME) ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
<style>
body { font-family: 'Poppins', sans-serif; background: #e4e9f7; }

.login-wrap {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 24px;
}
.login-shell {
    display: flex;
    width: 100%;
    max-width: 880px;
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(17, 16, 29, 0.12);
}

/* Panel kiri: warna sama dengan sidebar aplikasi */
.login-brand {
    flex: 0 0 42%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    gap: 48px;
    padding: 36px;
    background: #11101d;
    color: #fff;
}
.brand-logo { display: flex; align-items: center; gap: 10px; font-size: 17px; font-weight: 600; }
.brand-logo i { font-size: 30px; }
.login-brand h2 { font-size: 1.5rem; font-weight: 600; line-height: 1.4; margin: 0 0 22px; }
.login-brand ul { list-style: none; margin: 0; padding: 0; display: grid; gap: 12px; }
.login-brand li { display: flex; align-items: center; gap: 12px; font-size: 0.9rem; color: rgba(255, 255, 255, 0.75); }
.login-brand li i {
    width: 34px;
    height: 34px;
    display: grid;
    place-items: center;
    border-radius: 8px;
    background: #1d1b31;
    color: #6ea8fe;
    font-size: 18px;
}

/* Panel kanan: form */
.login-form { flex: 1; padding: 44px 40px; display: flex; flex-direction: column; justify-content: center; }
.login-form h1 { font-size: 1.6rem; font-weight: 600; color: #11101d; margin-bottom: 4px; }
.login-form .sub { color: #6b7194; font-size: 0.9rem; margin-bottom: 26px; }
.login-form .form-label { font-size: 0.85rem; font-weight: 500; color: #11101d; }

.login-form .input-group-text { background: #f6f7fc; color: #5d6385; font-size: 18px; }
.login-form .form-control { padding: 0.6rem 0.75rem; }
.login-form .form-control:focus { box-shadow: none; }
.login-form .input-group:focus-within {
    border-radius: 0.375rem;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.18);
}
.login-form .input-group:focus-within > * { border-color: #86b7fe; }
#password { border-right: 0; }
.btn-eye {
    background: #fff;
    border: 1px solid var(--bs-border-color);
    border-left: 0;
    color: #5d6385;
    font-size: 18px;
}
.btn-eye:hover { color: #11101d; background: #fff; }
.login-form .btn-submit { padding: 0.65rem; font-weight: 500; }
.login-form .hint { margin-top: 22px; text-align: center; font-size: 0.82rem; color: #6b7194; }

@media (max-width: 767.98px) {
    .login-brand { display: none; }
    .login-shell { max-width: 420px; }
    .login-form { padding: 32px 24px; }
}
</style>
</head>
<body>
<main class="login-wrap">
    <div class="login-shell">
        <aside class="login-brand">
            <div class="brand-logo"><i class='bx bx-package'></i><span><?= e(APP_NAME) ?></span></div>
            <div>
                <h2>Stok barang kantor, tercatat rapi.</h2>
                <ul>
                    <li><i class='bx bx-collection'></i>Data barang dan kategori</li>
                    <li><i class='bx bx-transfer'></i>Riwayat barang masuk dan keluar</li>
                    <li><i class='bx bx-bell'></i>Peringatan saat stok menipis</li>
                </ul>
            </div>
        </aside>

        <section class="login-form">
            <div class="brand-logo d-md-none mb-4 text-dark"><i class='bx bx-package'></i><span><?= e(APP_NAME) ?></span></div>
            <h1>Masuk</h1>
            <p class="sub">Gunakan akun yang diberikan administrator.</p>

            <?php if ($flash): ?>
            <div class="alert alert-<?= e($flash['type']) ?> py-2" role="alert"><?= e($flash['message']) ?></div>
            <?php endif; ?>

            <form method="post" action="<?= base_url('auth/authenticate') ?>">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class='bx bx-user'></i></span>
                        <input type="text" id="username" name="username" class="form-control" autocomplete="username" required autofocus>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class='bx bx-lock-alt'></i></span>
                        <input type="password" id="password" name="password" class="form-control" autocomplete="current-password" required>
                        <button type="button" id="togglePassword" class="btn btn-eye" aria-label="Tampilkan password"><i class='bx bx-show'></i></button>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-submit w-100">Masuk</button>
            </form>

            <p class="hint">Lupa password? Hubungi administrator.</p>
        </section>
    </div>
</main>

<script>
document.getElementById('togglePassword').addEventListener('click', function () {
    var input = document.getElementById('password');
    var show = input.type === 'password';
    input.type = show ? 'text' : 'password';
    this.setAttribute('aria-label', show ? 'Sembunyikan password' : 'Tampilkan password');
    this.querySelector('i').className = show ? 'bx bx-hide' : 'bx bx-show';
});
</script>
</body>
</html>