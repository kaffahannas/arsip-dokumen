<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $categories = [
            [
                'name'        => 'Keuangan',
                'description' => 'Dokumen terkait laporan dan administrasi keuangan.',
            ],
            [
                'name'        => 'Kepegawaian',
                'description' => 'Dokumen terkait data dan administrasi pegawai.',
            ],
            [
                'name'        => 'Surat Masuk',
                'description' => 'Dokumen surat masuk dari pihak eksternal.',
            ],
        ];

        foreach ($categories as $category) {
            $exists = $this->db->table('categories')
                ->where('name', $category['name'])
                ->countAllResults();

            if ($exists > 0) {
                continue;
            }

            $this->db->table('categories')->insert([
                'name'        => $category['name'],
                'description' => $category['description'],
                'created_at'  => $now,
                'updated_at'  => $now,
            ]);
        }
    }
}
