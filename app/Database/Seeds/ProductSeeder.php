<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'product_name' => 'Product 1',
                'description'  => 'Description of Product 1',
                'price'        => 100.00,
                'stock'        => 50,
            ],
            [
                'product_name' => 'Product 2',
                'description'  => 'Description of Product 2',
                'price'        => 150.00,
                'stock'        => 30,
            ],
        ];

        $this->db->table('products')->insertBatch($data);
    }
}
