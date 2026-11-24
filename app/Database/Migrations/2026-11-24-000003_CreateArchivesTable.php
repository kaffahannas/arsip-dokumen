<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateArchivesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'category_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'original_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'stored_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'mime_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'file_size' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'uploaded_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('category_id');
        $this->forge->addKey('title');
        $this->forge->addKey('uploaded_by');

        $this->forge->addForeignKey('category_id', 'categories', 'id', 'CASCADE', 'RESTRICT', 'archives_category_id_foreign');
        $this->forge->addForeignKey('uploaded_by', 'users', 'id', 'CASCADE', 'RESTRICT', 'archives_uploaded_by_foreign');

        $this->forge->createTable('archives', true);
    }

    public function down()
    {
        $this->forge->dropTable('archives', true);
    }
}
