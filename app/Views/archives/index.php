<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-3">
    <h1 class="h3 mb-0">Arsip Dokumen</h1>
</div>

<div class="card shadow-sm">
    <div class="card-body text-center py-5">
        <p class="mb-1 fw-semibold">Belum ada arsip yang ditampilkan.</p>
        <p class="text-muted mb-0">Halaman daftar arsip akan tersedia pada fase berikutnya.</p>
    </div>
</div>
<?= $this->endSection() ?>
