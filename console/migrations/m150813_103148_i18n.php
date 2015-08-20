<?php

use yii\db\Schema;
use yii\db\Migration;

class m150813_103148_i18n extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable("{{%source_message}}", [
            'id' => $this->primaryKey(),
            'category' => $this->string(32)->notNull(),
            'message' => $this->text()->notNull(),
        ], $tableOptions);

        $this->createTable("{{%message}}", [
            'id' => $this->integer()->notNull(),
            'language' => $this->string(16)->notNull(),
            'translation' => $this->text(),
            'PRIMARY KEY (`id`, `language`)',
        ], $tableOptions);

        $this->addForeignKey('fk_message_source_message', '{{%message}}', 'id',
            '{{%source_message}}', 'id', 'CASCADE', 'RESTRICT');

    }

    public function down()
    {
        $this->dropTable("{{%source_message}}");
        $this->dropTable("{{%message}}");
    }
}
