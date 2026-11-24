<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table            = 'categories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $allowedFields    = ['name', 'description'];

    protected $validationRules = [
        'name'        => 'required|max_length[100]|is_unique[categories.name]',
        'description' => 'permit_empty',
    ];

    protected $validationMessages = [
        'name' => [
            'required'   => 'Nama kategori wajib diisi.',
            'max_length' => 'Nama kategori maksimal 100 karakter.',
            'is_unique'  => 'Nama kategori sudah digunakan.',
        ],
    ];

    /**
     * Returns all categories along with the number of archives in each.
     */
    public function getWithArchiveCount(): array
    {
        return $this->select('categories.*, COUNT(archives.id) AS archive_count')
            ->join('archives', 'archives.category_id = categories.id', 'left')
            ->groupBy('categories.id')
            ->orderBy('categories.name', 'ASC')
            ->findAll();
    }
}
