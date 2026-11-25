<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-3">
    <h1 class="h3 mb-0">Kategori</h1>
    <a href="<?= base_url('categories/create') ?>" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1" aria-hidden="true"></i>Tambah Kategori
    </a>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th scope="col">Nama</th>
                    <th scope="col">Deskripsi</th>
                    <th scope="col" class="text-center">Jumlah Arsip</th>
                    <th scope="col" class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($categories === []): ?>
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <i class="bi bi-tags display-6 text-muted d-block mb-2" aria-hidden="true"></i>
                            <p class="mb-1 fw-semibold">Belum ada kategori.</p>
                            <p class="text-muted mb-0">Tambahkan kategori pertama untuk mulai mengarsipkan dokumen.</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <td class="fw-semibold text-break"><?= esc($category['name']) ?></td>
                            <td class="text-muted text-break">
                                <?= $category['description'] ? esc($category['description']) : '-' ?>
                            </td>
                            <td class="text-center">
                                <span class="badge text-bg-secondary">
                                    <i class="bi bi-folder me-1" aria-hidden="true"></i><?= esc((int) $category['archive_count']) ?>
                                </span>
                            </td>
                            <td class="text-end text-nowrap">
                                <a href="<?= base_url('categories/edit/' . $category['id']) ?>"
                                   class="btn btn-sm btn-outline-secondary"
                                   title="Edit"
                                   aria-label="Edit kategori">
                                    <i class="bi bi-pencil-square" aria-hidden="true"></i>
                                    <span class="d-none d-sm-inline ms-1">Edit</span>
                                </a>

                                <form action="<?= base_url('categories/delete/' . $category['id']) ?>"
                                      method="post"
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                            title="Hapus" aria-label="Hapus kategori">
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
<?= $this->endSection() ?>
