<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBlogAndBanners extends Migration
{
    public function up()
    {
        // Blog posts
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'slug'         => ['type' => 'VARCHAR', 'constraint' => 255],
            'title'        => ['type' => 'VARCHAR', 'constraint' => 255],
            'excerpt'      => ['type' => 'TEXT', 'null' => true],
            'body'         => ['type' => 'LONGTEXT', 'null' => true],
            'cover_image'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'author'       => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'is_published' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'published_at' => ['type' => 'DATETIME', 'null' => true],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('blog_posts');

        // Homepage banners (hero slider)
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'title'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'subtitle'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'image'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'link'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'btn_text'   => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'sort_order' => ['type' => 'INT', 'default' => 0],
            'is_active'  => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('homepage_banners');

        // Promo codes display (not functional payment - just display on product page)
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'code'       => ['type' => 'VARCHAR', 'constraint' => 50],
            'label'      => ['type' => 'VARCHAR', 'constraint' => 200],
            'is_active'  => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'sort_order' => ['type' => 'INT', 'default' => 0],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('promo_codes');

        // Press / "Featured In" entries
        $this->forge->addField([
            'id'        => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'name'      => ['type' => 'VARCHAR', 'constraint' => 150],
            'logo'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'link'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'sort_order'=> ['type' => 'INT', 'default' => 0],
            'is_active' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('press_mentions');
    }

    public function down()
    {
        $this->forge->dropTable('blog_posts');
        $this->forge->dropTable('homepage_banners');
        $this->forge->dropTable('promo_codes');
        $this->forge->dropTable('press_mentions');
    }
}
