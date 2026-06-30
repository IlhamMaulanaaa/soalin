<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNamaToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'nama');
    }
}
