<?php
$isEdit = $category !== null;
$action = $isEdit
    ? base_url('categories/update/' . $category['id'])
    : base_url('categories');
$errors = session()->getFlashdata('errors') ?? [];
?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-12 col-lg-8 col-xl-7">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h3 mb-0"><?= esc($title) ?></h1>
            <a href="<?= base_url('categories') ?>" class="btn btn-sm btn-outline-secondary">Kembali</a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-4">
                <form action="<?= esc($action) ?>" method="post" novalidate>
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control<?= isset($errors['name']) ? ' is-invalid' : '' ?>"
                               id="name"
                               name="name"
                               value="<?= esc(old('name', $category['name'] ?? '')) ?>"
                               maxlength="100"
                               required
                               autofocus>
                        <?php if (isset($errors['name'])): ?>
                            <div class="invalid-feedback"><?= esc($errors['name']) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control<?= isset($errors['description']) ? ' is-invalid' : '' ?>"
                                  id="description"
                                  name="description"
                                  rows="4"><?= esc(old('description', $category['description'] ?? '')) ?></textarea>
                        <?php if (isset($errors['description'])): ?>
                            <div class="invalid-feedback"><?= esc($errors['description']) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <?= $isEdit ? 'Simpan Perubahan' : 'Simpan' ?>
                        </button>
                        <a href="<?= base_url('categories') ?>" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
