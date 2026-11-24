<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'Sistem Arsip Dokumen') ?> - Sistem Arsip Dokumen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-7 col-lg-5">
                <div class="text-center mb-4">
                    <h1 class="h3 mb-1">Sistem Arsip Dokumen</h1>
                    <p class="text-muted mb-0">Masuk untuk mengelola arsip Anda</p>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger" role="alert">
                                <?= esc(session()->getFlashdata('error')) ?>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success" role="alert">
                                <?= esc(session()->getFlashdata('success')) ?>
                            </div>
                        <?php endif; ?>

                        <?php $errors = session()->getFlashdata('errors') ?? []; ?>

                        <form action="<?= base_url('login') ?>" method="post" novalidate>
                            <?= csrf_field() ?>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email"
                                       class="form-control<?= isset($errors['email']) ? ' is-invalid' : '' ?>"
                                       id="email"
                                       name="email"
                                       value="<?= esc(old('email')) ?>"
                                       autocomplete="email"
                                       required
                                       autofocus>
                                <?php if (isset($errors['email'])): ?>
                                    <div class="invalid-feedback"><?= esc($errors['email']) ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <input type="password"
                                       class="form-control<?= isset($errors['password']) ? ' is-invalid' : '' ?>"
                                       id="password"
                                       name="password"
                                       autocomplete="current-password"
                                       required>
                                <?php if (isset($errors['password'])): ?>
                                    <div class="invalid-feedback"><?= esc($errors['password']) ?></div>
                                <?php endif; ?>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>
                    </div>
                </div>

                <p class="text-center text-muted small mt-4 mb-0">
                    &copy; <?= esc(date('Y')) ?> Sistem Arsip Dokumen
                </p>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
