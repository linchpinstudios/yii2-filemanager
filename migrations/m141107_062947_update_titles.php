<?php

use yii\db\Schema;
use yii\db\Migration;

class m141107_062947_update_titles extends Migration
{
    public function up()
    {
        alterColumn( '{{%files}}', 'title', Schema::TYPE_STRING . '(555) NULL' );
    }

    public function down()
    {
        alterColumn( '{{%files}}', 'title', Schema::TYPE_STRING . '(45) NULL' );
    }
}
