<?php

namespace App\Controllers;

use App\Models\ArchiveModel;
use App\Models\CategoryModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;
use Throwable;

class Categories extends BaseController
{
    public function index(): string
    {
        $categoryModel = model(CategoryModel::class);

        return view('categories/index', [
            'title'      => 'Kategori',
            'categories' => $categoryModel->getWithArchiveCount(),
        ]);
    }

    public function create(): string
    {
        return view('categories/form', [
            'title'    => 'Tambah Kategori',
            'category' => null,
        ]);
    }

    public function store(): RedirectResponse
    {
        $categoryModel = model(CategoryModel::class);

        if (! $categoryModel->insert($this->categoryData())) {
            return redirect()->to(base_url('categories/create'))
                ->withInput()
                ->with('errors', $categoryModel->errors());
        }

        return redirect()->to(base_url('categories'))
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(int $id): string
    {
        $category = $this->findCategory($id);

        return view('categories/form', [
            'title'    => 'Edit Kategori',
            'category' => $category,
        ]);
    }

    public function update(int $id): RedirectResponse
    {
        $categoryModel = model(CategoryModel::class);

        $this->findCategory($id);

        $categoryModel->setValidationRule(
            'name',
            'required|max_length[100]|is_unique[categories.name,id,' . $id . ']'
        );

        if (! $categoryModel->update($id, $this->categoryData())) {
            return redirect()->to(base_url('categories/edit/' . $id))
                ->withInput()
                ->with('errors', $categoryModel->errors());
        }

        return redirect()->to(base_url('categories'))
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function delete(int $id): RedirectResponse
    {
        $categoryModel = model(CategoryModel::class);
        $archiveModel  = model(ArchiveModel::class);

        $this->findCategory($id);

        $archiveCount = $archiveModel->where('category_id', $id)->countAllResults();

        if ($archiveCount > 0) {
            return redirect()->to(base_url('categories'))
                ->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh '
                    . $archiveCount . ' arsip.');
        }

        try {
            $categoryModel->delete($id);
        } catch (Throwable $e) {
            log_message('error', 'Gagal menghapus kategori: {message}', ['message' => $e->getMessage()]);

            return redirect()->to(base_url('categories'))
                ->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh arsip.');
        }

        return redirect()->to(base_url('categories'))
            ->with('success', 'Kategori berhasil dihapus.');
    }

    private function findCategory(int $id): array
    {
        $category = model(CategoryModel::class)->find($id);

        if ($category === null) {
            throw PageNotFoundException::forPageNotFound('Kategori tidak ditemukan.');
        }

        return $category;
    }

    private function categoryData(): array
    {
        $description = trim((string) $this->request->getPost('description'));

        return [
            'name'        => trim((string) $this->request->getPost('name')),
            'description' => $description === '' ? null : $description,
        ];
    }
}
