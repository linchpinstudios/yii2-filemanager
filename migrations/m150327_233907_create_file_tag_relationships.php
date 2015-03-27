<?php

use yii\db\Schema;
use yii\db\Migration;

class m150327_233907_create_file_tag_relationships extends Migration
{

    public function up()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%file_tag_relationships}}', [
            'id'      => Schema::TYPE_PK,
            'file_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'tag_id'  => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

    }

    public function down()
    {

        $this->dropTable('{{%file_tag_relationships}}');

    }

}
