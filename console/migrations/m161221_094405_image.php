<?php

use yii\db\Migration;

class m161221_094405_image extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('image', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'path' => $this->string()->notNull()->unique(),
            'description' => $this->string()->notNull(),
            'status' => $this->integer(),

            'section_id' => $this->integer()->notNull(),
            // created/updated at/by
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('image');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
