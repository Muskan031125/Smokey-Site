<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrders extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'order_number'    => ['type' => 'VARCHAR', 'constraint' => 30],
            'user_id'         => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'customer_name'   => ['type' => 'VARCHAR', 'constraint' => 120],
            'customer_email'  => ['type' => 'VARCHAR', 'constraint' => 150],
            'customer_phone'  => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'address_line1'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'address_line2'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'city'            => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'state'           => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'pincode'         => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'subtotal'        => ['type' => 'DECIMAL', 'constraint' => '12,2', 'default' => 0],
            'total'           => ['type' => 'DECIMAL', 'constraint' => '12,2', 'default' => 0],
            'status'          => ['type' => 'ENUM', 'constraint' => ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'], 'default' => 'pending'],
            'notes'           => ['type' => 'TEXT', 'null' => true],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('order_number');
        $this->forge->addKey('user_id');
        $this->forge->createTable('orders');

        // Order items table
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'order_id'   => ['type' => 'INT', 'unsigned' => true],
            'product_id' => ['type' => 'INT', 'unsigned' => true],
            'title'      => ['type' => 'VARCHAR', 'constraint' => 255],
            'sku'        => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'price'      => ['type' => 'DECIMAL', 'constraint' => '12,2'],
            'quantity'   => ['type' => 'INT', 'default' => 1],
            'subtotal'   => ['type' => 'DECIMAL', 'constraint' => '12,2'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('order_id');
        $this->forge->createTable('order_items');
    }

    public function down()
    {
        $this->forge->dropTable('order_items');
        $this->forge->dropTable('orders');
    }
}
