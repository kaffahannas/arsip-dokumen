<?php

namespace App\Models;

use CodeIgniter\Model;

class ArchiveModel extends Model
{
    protected $table            = 'archives';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $allowedFields    = [
        'category_id',
        'title',
        'description',
        'original_name',
        'stored_name',
        'mime_type',
        'file_size',
        'uploaded_by',
    ];

    protected $validationRules = [
        'category_id'   => 'required|is_natural_no_zero|is_not_unique[categories.id]',
        'title'         => 'required|max_length[150]',
        'description'   => 'permit_empty',
        'original_name' => 'required|max_length[255]',
        'stored_name'   => 'required|max_length[255]',
        'mime_type'     => 'required|max_length[100]',
        'file_size'     => 'required|is_natural',
        'uploaded_by'   => 'required|is_natural_no_zero|is_not_unique[users.id]',
    ];
}
