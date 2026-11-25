<?php
$isPdf   = $archive['mime_type'] === 'application/pdf';
$isImage = in_array($archive['mime_type'], ['image/jpeg', 'image/png'], true);
?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-start gap-2 mb-3">
    <div>
        <h1 class="h3 mb-1 text-break"><?= esc($archive['title']) ?></h1>
        <span class="badge text-bg-secondary">
            <i class="bi bi-tag me-1" aria-hidden="true"></i><?= esc($archive['category_name']) ?>
        </span>
    </div>
    <div class="d-grid gap-2 d-sm-flex flex-sm-wrap">
        <a href="<?= base_url('archives/download/' . $archive['id']) ?>" class="btn btn-primary">
            <i class="bi bi-download me-1" aria-hidden="true"></i>Download
        </a>
        <a href="<?= base_url('archives/edit/' . $archive['id']) ?>" class="btn btn-outline-secondary">
            <i class="bi bi-pencil-square me-1" aria-hidden="true"></i>Edit
        </a>
        <a href="<?= base_url('archives') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1" aria-hidden="true"></i>Kembali
        </a>
    </div>
</div>

<div class="row g-3">
    <div class="col-12 col-lg-7">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white fw-semibold">Pratinjau Dokumen</div>
            <div class="card-body">
                <?php if ($isPdf): ?>
                    <iframe src="<?= base_url('archives/file/' . $archive['id']) ?>"
                            title="Pratinjau <?= esc($archive['original_name']) ?>"
                            class="w-100 border rounded"
                            style="height: 75vh; min-height: 420px;"
                            loading="lazy"></iframe>
                <?php elseif ($isImage): ?>
                    <img src="<?= base_url('archives/file/' . $archive['id']) ?>"
                         alt="Pratinjau <?= esc($archive['original_name']) ?>"
                         class="img-fluid rounded border d-block mx-auto"
                         style="max-height: 75vh;">
                <?php else: ?>
                    <p class="text-muted mb-0">Pratinjau tidak tersedia untuk tipe file ini.</p>
                <?php endif; ?>
            </div>
            <div class="card-footer bg-white">
                <a href="<?= base_url('archives/file/' . $archive['id']) ?>"
                   target="_blank"
                   rel="noopener"
                   class="small">Buka file di tab baru</a>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-5">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-semibold">Metadata</div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-5 col-sm-4">Nama File</dt>
                    <dd class="col-7 col-sm-8 text-break"><?= esc($archive['original_name']) ?></dd>

                    <dt class="col-5 col-sm-4">Tipe File</dt>
                    <dd class="col-7 col-sm-8 text-break"><?= esc($archive['mime_type']) ?></dd>

                    <dt class="col-5 col-sm-4">Ukuran</dt>
                    <dd class="col-7 col-sm-8"><?= esc(format_file_size($archive['file_size'])) ?></dd>

                    <dt class="col-5 col-sm-4">Diunggah</dt>
                    <dd class="col-7 col-sm-8">
                        <?= esc(format_datetime($archive['created_at'])) ?>
                    </dd>

                    <dt class="col-5 col-sm-4">Diperbarui</dt>
                    <dd class="col-7 col-sm-8">
                        <?= esc(format_datetime($archive['updated_at'])) ?>
                    </dd>

                    <dt class="col-12 mt-3">Deskripsi</dt>
                    <dd class="col-12 mb-0">
                        <?= $archive['description']
                            ? nl2br(esc($archive['description']))
                            : '<span class="text-muted">Tidak ada deskripsi.</span>' ?>
                    </dd>
                </dl>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
