<?php

namespace App\Controllers;

use App\Models\ArchiveModel;
use App\Models\CategoryModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\Files\UploadedFile;
use Throwable;

class Archives extends BaseController
{
    public function index(): string
    {
        $archiveModel = model(ArchiveModel::class);

        return view('archives/index', [
            'title'    => 'Arsip Dokumen',
            'archives' => $archiveModel->getWithCategoryPaginated(10),
            'pager'    => $archiveModel->pager,
        ]);
    }

    public function create(): string
    {
        return view('archives/form', [
            'title'      => 'Tambah Arsip',
            'archive'    => null,
            'categories' => $this->categories(),
        ]);
    }

    public function store(): RedirectResponse
    {
        $archiveModel = model(ArchiveModel::class);

        $rules         = $this->metadataRules();
        $rules['file'] = 'uploaded[file]|max_size[file,5120]|ext_in[file,pdf,jpg,jpeg,png]|mime_in[file,application/pdf,image/jpeg,image/png]';

        if (! $this->validate($rules, $this->validationMessages())) {
            return redirect()->to(base_url('archives/create'))
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('file');

        if ($file === null || ! $file->isValid()) {
            return redirect()->to(base_url('archives/create'))
                ->withInput()
                ->with('error', 'File gagal diunggah. Silakan pilih file lain.');
        }

        $storedName = $file->getRandomName();

        try {
            $file->move($this->uploadPath(), $storedName);
        } catch (Throwable $e) {
            log_message('error', 'Gagal memindahkan file upload: {message}', ['message' => $e->getMessage()]);

            return redirect()->to(base_url('archives/create'))
                ->withInput()
                ->with('error', 'File gagal diunggah. Silakan coba lagi.');
        }

        $data = array_merge($this->metadata(), $this->fileData($file, $storedName));

        try {
            if (! $archiveModel->insert($data)) {
                $this->removeFile($storedName);

                return redirect()->to(base_url('archives/create'))
                    ->withInput()
                    ->with('errors', $archiveModel->errors());
            }
        } catch (Throwable $e) {
            $this->removeFile($storedName);
            log_message('error', 'Gagal menyimpan arsip: {message}', ['message' => $e->getMessage()]);

            return redirect()->to(base_url('archives/create'))
                ->withInput()
                ->with('error', 'Arsip gagal disimpan. Silakan coba lagi.');
        }

        return redirect()->to(base_url('archives'))
            ->with('success', 'Arsip berhasil ditambahkan.');
    }

    public function edit(int $id): string
    {
        return view('archives/form', [
            'title'      => 'Edit Arsip',
            'archive'    => $this->findArchive($id),
            'categories' => $this->categories(),
        ]);
    }

    public function update(int $id): RedirectResponse
    {
        $archive      = $this->findArchive($id);
        $archiveModel = model(ArchiveModel::class);

        $rules = $this->metadataRules();
        $file  = $this->request->getFile('file');
        $hasNewFile = $file !== null && $file->getError() !== UPLOAD_ERR_NO_FILE;

        if ($hasNewFile) {
            $rules['file'] = 'uploaded[file]|max_size[file,5120]|ext_in[file,pdf,jpg,jpeg,png]|mime_in[file,application/pdf,image/jpeg,image/png]';
        }

        if (! $this->validate($rules, $this->validationMessages())) {
            return redirect()->to(base_url('archives/edit/' . $id))
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data      = $this->metadata();
        $newStored = null;

        if ($hasNewFile) {
            if (! $file->isValid()) {
                return redirect()->to(base_url('archives/edit/' . $id))
                    ->withInput()
                    ->with('error', 'File gagal diunggah. Silakan pilih file lain.');
            }

            $newStored = $file->getRandomName();

            try {
                $file->move($this->uploadPath(), $newStored);
            } catch (Throwable $e) {
                log_message('error', 'Gagal memindahkan file upload: {message}', ['message' => $e->getMessage()]);

                return redirect()->to(base_url('archives/edit/' . $id))
                    ->withInput()
                    ->with('error', 'File gagal diunggah. Silakan coba lagi.');
            }

            $data = array_merge($data, $this->fileData($file, $newStored));
        }

        try {
            if (! $archiveModel->update($id, $data)) {
                if ($newStored !== null) {
                    $this->removeFile($newStored);
                }

                return redirect()->to(base_url('archives/edit/' . $id))
                    ->withInput()
                    ->with('errors', $archiveModel->errors());
            }
        } catch (Throwable $e) {
            if ($newStored !== null) {
                $this->removeFile($newStored);
            }
            log_message('error', 'Gagal memperbarui arsip: {message}', ['message' => $e->getMessage()]);

            return redirect()->to(base_url('archives/edit/' . $id))
                ->withInput()
                ->with('error', 'Arsip gagal diperbarui. Silakan coba lagi.');
        }

        if ($newStored !== null && $newStored !== $archive['stored_name']) {
            $this->removeFile($archive['stored_name']);
        }

        return redirect()->to(base_url('archives'))
            ->with('success', 'Arsip berhasil diperbarui.');
    }

    public function delete(int $id): RedirectResponse
    {
        $archive      = $this->findArchive($id);
        $archiveModel = model(ArchiveModel::class);

        try {
            if (! $archiveModel->delete($id)) {
                return redirect()->to(base_url('archives'))
                    ->with('error', 'Arsip gagal dihapus. Silakan coba lagi.');
            }
        } catch (Throwable $e) {
            log_message('error', 'Gagal menghapus arsip: {message}', ['message' => $e->getMessage()]);

            return redirect()->to(base_url('archives'))
                ->with('error', 'Arsip gagal dihapus. Silakan coba lagi.');
        }

        $this->removeFile($archive['stored_name']);

        return redirect()->to(base_url('archives'))
            ->with('success', 'Arsip berhasil dihapus.');
    }

    private function findArchive(int $id): array
    {
        $archive = model(ArchiveModel::class)->find($id);

        if ($archive === null) {
            throw PageNotFoundException::forPageNotFound('Arsip tidak ditemukan.');
        }

        return $archive;
    }

    private function categories(): array
    {
        return model(CategoryModel::class)->orderBy('name', 'ASC')->findAll();
    }

    private function metadataRules(): array
    {
        return [
            'title'       => 'required|max_length[150]',
            'category_id' => 'required|is_natural_no_zero|is_not_unique[categories.id]',
            'description' => 'permit_empty',
        ];
    }

    private function validationMessages(): array
    {
        return [
            'title' => [
                'required'   => 'Judul wajib diisi.',
                'max_length' => 'Judul maksimal 150 karakter.',
            ],
            'category_id' => [
                'required'              => 'Kategori wajib dipilih.',
                'is_natural_no_zero'    => 'Kategori wajib dipilih.',
                'is_not_unique'         => 'Kategori yang dipilih tidak valid.',
            ],
            'file' => [
                'uploaded'  => 'File wajib diunggah.',
                'max_size'  => 'Ukuran file maksimal 5 MB.',
                'ext_in'    => 'Ekstensi file harus PDF, JPG, JPEG, atau PNG.',
                'mime_in'   => 'Tipe file harus PDF, JPG, JPEG, atau PNG.',
            ],
        ];
    }

    private function metadata(): array
    {
        $description = trim((string) $this->request->getPost('description'));

        return [
            'category_id' => (int) $this->request->getPost('category_id'),
            'title'       => trim((string) $this->request->getPost('title')),
            'description' => $description === '' ? null : $description,
        ];
    }

    private function fileData(UploadedFile $file, string $storedName): array
    {
        return [
            'original_name' => $file->getClientName(),
            'stored_name'   => $storedName,
            'mime_type'     => $file->getClientMimeType(),
            'file_size'     => $file->getSize(),
            'uploaded_by'   => (int) session('user_id'),
        ];
    }

    private function uploadPath(): string
    {
        return WRITEPATH . 'uploads';
    }

    private function removeFile(string $storedName): void
    {
        $path = $this->uploadPath() . DIRECTORY_SEPARATOR . $storedName;

        if (is_file($path)) {
            @unlink($path);
        }
    }
}
