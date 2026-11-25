<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Halaman Tidak Ditemukan - Sistem Arsip Dokumen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6">
                <div class="card shadow-sm text-center">
                    <div class="card-body p-4 p-sm-5">
                        <div class="text-primary mb-3">
                            <i class="bi bi-file-earmark-x display-4" aria-hidden="true"></i>
                        </div>

                        <h1 class="display-5 fw-bold mb-2">404</h1>
                        <h2 class="h4 mb-3">Halaman Tidak Ditemukan</h2>

                        <p class="text-muted text-break mb-4">
                            <?php if (ENVIRONMENT !== 'production' && ! empty($message)): ?>
                                <?= nl2br(esc($message)) ?>
                            <?php else: ?>
                                Halaman atau dokumen yang Anda cari tidak tersedia.
                            <?php endif; ?>
                        </p>

                        <div class="d-grid d-sm-flex gap-2 justify-content-sm-center">
                            <a href="<?= base_url('archives') ?>" class="btn btn-primary">
                                <i class="bi bi-folder2-open me-1" aria-hidden="true"></i>Kembali ke Arsip
                            </a>
                            <button type="button" class="btn btn-outline-secondary" onclick="history.back()">
                                <i class="bi bi-arrow-left me-1" aria-hidden="true"></i>Halaman Sebelumnya
                            </button>
                        </div>
                    </div>
                </div>

                <p class="text-center text-muted small mt-4 mb-0">
                    &copy; <?= esc(date('Y')) ?> Sistem Arsip Dokumen
                </p>
            </div>
        </div>
    </main>
</body>
</html>
