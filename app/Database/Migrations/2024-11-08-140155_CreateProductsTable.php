<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'product_name' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
            'description' => [
                'type'           => 'TEXT',
            ],
            'price'       => [
                'type'           => 'DECIMAL',
                'constraint'     => '10,2',
            ],
            'stock'       => [
                'type'           => 'INT',
                'constraint'     => '5',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('products');
    }

    public function down()
    {
        $this->forge->dropTable('products');
    }
}
