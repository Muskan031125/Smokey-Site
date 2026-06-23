<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductReviews extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'product_id'  => ['type' => 'INT', 'unsigned' => true],
            'user_id'     => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'email'       => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'rating'      => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 5],
            'title'       => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true],
            'body'        => ['type' => 'TEXT', 'null' => true],
            'is_approved' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('product_id');
        $this->forge->createTable('product_reviews');
    }

    public function down()
    {
        $this->forge->dropTable('product_reviews');
    }
}
