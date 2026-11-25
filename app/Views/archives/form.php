<?php
$isEdit = $archive !== null;
$action = $isEdit
    ? base_url('archives/update/' . $archive['id'])
    : base_url('archives');
$errors = session()->getFlashdata('errors') ?? [];
?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-12 col-lg-9 col-xl-8">
        <div class="d-flex justify-content-between align-items-center gap-2 mb-3">
            <h1 class="h3 mb-0"><?= esc($title) ?></h1>
            <a href="<?= base_url('archives') ?>" class="btn btn-sm btn-outline-secondary text-nowrap">
                <i class="bi bi-arrow-left me-1" aria-hidden="true"></i>Kembali
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-3 p-md-4">
                <form action="<?= esc($action) ?>" method="post" enctype="multipart/form-data" novalidate>
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="title" class="form-label">Judul <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control<?= isset($errors['title']) ? ' is-invalid' : '' ?>"
                               id="title"
                               name="title"
                               value="<?= esc(old('title', $archive['title'] ?? '')) ?>"
                               maxlength="150"
                               required
                               autofocus>
                        <?php if (isset($errors['title'])): ?>
                            <div class="invalid-feedback"><?= esc($errors['title']) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                        <?php $selectedCategory = old('category_id', $archive['category_id'] ?? ''); ?>
                        <select class="form-select<?= isset($errors['category_id']) ? ' is-invalid' : '' ?>"
                                id="category_id"
                                name="category_id"
                                required>
                            <option value="">-- Pilih Kategori --</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= esc($category['id']) ?>"
                                    <?= (string) $selectedCategory === (string) $category['id'] ? 'selected' : '' ?>>
                                    <?= esc($category['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($errors['category_id'])): ?>
                            <div class="invalid-feedback"><?= esc($errors['category_id']) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control<?= isset($errors['description']) ? ' is-invalid' : '' ?>"
                                  id="description"
                                  name="description"
                                  rows="4"><?= esc(old('description', $archive['description'] ?? '')) ?></textarea>
                        <?php if (isset($errors['description'])): ?>
                            <div class="invalid-feedback"><?= esc($errors['description']) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-4">
                        <label for="file" class="form-label">
                            File <span class="text-danger"><?= $isEdit ? '' : '*' ?></span>
                        </label>
                        <input type="file"
                               class="form-control<?= isset($errors['file']) ? ' is-invalid' : '' ?>"
                               id="file"
                               name="file"
                               accept=".pdf,.jpg,.jpeg,.png,application/pdf,image/jpeg,image/png"
                               <?= $isEdit ? '' : 'required' ?>>
                        <?php if (isset($errors['file'])): ?>
                            <div class="invalid-feedback"><?= esc($errors['file']) ?></div>
                        <?php endif; ?>
                        <div class="form-text">
                            Format PDF, JPG, JPEG, atau PNG. Maksimal 5 MB.
                            <?php if ($isEdit): ?>
                                Biarkan kosong jika tidak ingin mengganti file.
                            <?php endif; ?>
                        </div>

                        <?php if ($isEdit): ?>
                            <div class="mt-2 text-muted small">
                                File saat ini: <span class="text-break"><?= esc($archive['original_name']) ?></span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="d-grid gap-2 d-sm-flex">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1" aria-hidden="true"></i><?= $isEdit ? 'Simpan Perubahan' : 'Simpan' ?>
                        </button>
                        <a href="<?= base_url('archives') ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-x-lg me-1" aria-hidden="true"></i>Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
