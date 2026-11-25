<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-3">
    <h1 class="h3 mb-0">Arsip Dokumen</h1>
    <a href="<?= base_url('archives/create') ?>" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1" aria-hidden="true"></i>Tambah Arsip
    </a>
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
                            <i class="bi bi-inbox display-6 text-muted d-block mb-2" aria-hidden="true"></i>
                            <p class="mb-1 fw-semibold">Belum ada arsip.</p>
                            <p class="text-muted mb-0">Tambahkan arsip pertama dengan mengunggah dokumen PDF atau gambar.</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($archives as $archive): ?>
                        <tr>
                            <td class="fw-semibold text-break"><?= esc($archive['title']) ?></td>
                            <td>
                                <span class="badge text-bg-secondary">
                                    <i class="bi bi-tag me-1" aria-hidden="true"></i><?= esc($archive['category_name']) ?>
                                </span>
                            </td>
                            <td class="text-break"><?= esc($archive['original_name']) ?></td>
                            <td class="text-nowrap"><?= esc(format_file_size($archive['file_size'])) ?></td>
                            <td class="text-nowrap">
                                <?= esc(format_datetime($archive['created_at'])) ?>
                            </td>
                            <td class="text-end text-nowrap">
                                <a href="<?= base_url('archives/' . $archive['id']) ?>"
                                   class="btn btn-sm btn-outline-primary"
                                   title="Detail"
                                   aria-label="Detail arsip">
                                    <i class="bi bi-eye" aria-hidden="true"></i>
                                    <span class="d-none d-sm-inline ms-1">Detail</span>
                                </a>

                                <a href="<?= base_url('archives/edit/' . $archive['id']) ?>"
                                   class="btn btn-sm btn-outline-secondary"
                                   title="Edit"
                                   aria-label="Edit arsip">
                                    <i class="bi bi-pencil-square" aria-hidden="true"></i>
                                    <span class="d-none d-sm-inline ms-1">Edit</span>
                                </a>

                                <form action="<?= base_url('archives/delete/' . $archive['id']) ?>"
                                      method="post"
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus arsip ini? File dokumen juga akan dihapus.');">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                            title="Hapus" aria-label="Hapus arsip">
                                        <i class="bi bi-trash" aria-hidden="true"></i>
                                        <span class="d-none d-sm-inline ms-1">Hapus</span>
                                    </button>
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
        <?= $pager->links('default', 'bootstrap') ?>
    </div>
<?php endif; ?>
<?= $this->endSection() ?>
