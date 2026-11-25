<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'Sistem Arsip Dokumen') ?> - Sistem Arsip Dokumen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url('archives') ?>">
                <i class="bi bi-archive me-1" aria-hidden="true"></i>Sistem Arsip Dokumen
            </a>
            <button class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#mainNavbar"
                    aria-controls="mainNavbar"
                    aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link<?= url_is('archives*') ? ' active' : '' ?>"
                           href="<?= base_url('archives') ?>">
                            <i class="bi bi-folder2-open me-1" aria-hidden="true"></i>Arsip
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?= url_is('categories*') ? ' active' : '' ?>"
                           href="<?= base_url('categories') ?>">
                            <i class="bi bi-tags me-1" aria-hidden="true"></i>Kategori
                        </a>
                    </li>
                </ul>

                <div class="d-flex flex-column flex-lg-row align-items-lg-center gap-2">
                    <?php if (session()->get('user_name')): ?>
                        <span class="navbar-text text-white-50">
                            <i class="bi bi-person-circle me-1" aria-hidden="true"></i><?= esc(session()->get('user_name')) ?>
                        </span>
                    <?php endif; ?>

                    <form action="<?= base_url('logout') ?>" method="post" class="d-grid d-lg-block">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-outline-light btn-sm">
                            <i class="bi bi-box-arrow-right me-1" aria-hidden="true"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="container py-4 flex-grow-1">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show text-break" role="alert">
                <?= esc(session()->getFlashdata('success')) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show text-break" role="alert">
                <?= esc(session()->getFlashdata('error')) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>
    </main>

    <footer class="bg-white border-top py-3">
        <div class="container">
            <p class="text-center text-muted small mb-0">
                &copy; <?= esc(date('Y')) ?> Sistem Arsip Dokumen
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
