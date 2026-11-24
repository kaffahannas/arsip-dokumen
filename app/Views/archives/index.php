<?php
$formatSize = static function ($bytes): string {
    $bytes = (int) $bytes;

    if ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 1) . ' MB';
    }

    return number_format($bytes / 1024, 1) . ' KB';
};
?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-3">
    <h1 class="h3 mb-0">Arsip Dokumen</h1>
    <a href="<?= base_url('archives/create') ?>" class="btn btn-primary">Tambah Arsip</a>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th scope="col">Judul</th>
                    <th scope="col">Kategori</th>
                    <th scope="col">Nama File</th>
                    <th scope="col" class="text-nowrap">Ukuran</th>
                    <th scope="col" class="text-nowrap">Tanggal</th>
                    <th scope="col" class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($archives === []): ?>
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <p class="mb-1 fw-semibold">Belum ada arsip.</p>
                            <p class="text-muted mb-0">Tambahkan arsip pertama dengan mengunggah dokumen PDF atau gambar.</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($archives as $archive): ?>
                        <tr>
                            <td class="fw-semibold"><?= esc($archive['title']) ?></td>
                            <td>
                                <span class="badge text-bg-secondary"><?= esc($archive['category_name']) ?></span>
                            </td>
                            <td class="text-break"><?= esc($archive['original_name']) ?></td>
                            <td class="text-nowrap"><?= esc($formatSize($archive['file_size'])) ?></td>
                            <td class="text-nowrap">
                                <?= esc(date('d/m/Y H:i', strtotime($archive['created_at']))) ?>
                            </td>
                            <td class="text-end text-nowrap">
                                <a href="<?= base_url('archives/edit/' . $archive['id']) ?>"
                                   class="btn btn-sm btn-outline-secondary">Edit</a>

                                <form action="<?= base_url('archives/delete/' . $archive['id']) ?>"
                                      method="post"
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus arsip ini? File dokumen juga akan dihapus.');">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php if ($pager->getPageCount() > 1): ?>
    <div class="mt-3">
        <?= $pager->links() ?>
    </div>
<?php endif; ?>
<?= $this->endSection() ?>
