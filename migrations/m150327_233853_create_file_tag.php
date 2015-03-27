<?php

use yii\db\Schema;
use yii\db\Migration;

class m150327_233853_create_file_tag extends Migration
{
    
    public function up()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%file_tag}}', [
            'id'             => Schema::TYPE_PK,
            'name'           => Schema::TYPE_STRING . '(255) NULL',
            'slug'           => Schema::TYPE_STRING . '(255) NULL',
        ], $tableOptions);

    }

    public function down()
    {

        $this->dropTable('{{%file_tag}}');

    }

}
