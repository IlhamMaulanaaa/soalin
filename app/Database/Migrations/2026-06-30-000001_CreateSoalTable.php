<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSoalTable extends Migration
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
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'mapel' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'jenjang' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'jumlah_soal' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'kesulitan' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'tipe_soal' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'soal_text' => [
                'type' => 'LONGTEXT',
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
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('soal');
    }

    public function down()
    {
        $this->forge->dropTable('soal');
    }
}
