<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateApiKeysTable extends Migration
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
            'key_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'api_key' => [
                'type'       => 'TEXT',
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('api_keys', true);
    }

    public function down()
    {
        $this->forge->dropTable('api_keys', true);
    }
}
