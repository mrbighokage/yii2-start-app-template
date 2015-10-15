<?php


use yii\db\Migration;
use yii\i18n\DbMessageSource;

class m150813_103148_i18n extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $dbm = new DbMessageSource();
        $this->createTable($dbm->sourceMessageTable, [
            'id' => $this->primaryKey(),
            'category' => $this->string(32)->notNull(),
            'message' => $this->text()->notNull(),
        ], $tableOptions);

        $this->createTable($dbm->messageTable, [
            'id' => $this->integer()->notNull(),
            'language' => $this->string(16)->notNull(),
            'translation' => $this->text(),
            'PRIMARY KEY (`id`, `language`)',
        ], $tableOptions);

        $this->addForeignKey('fk_message_source_message', $dbm->messageTable, 'id', $dbm->sourceMessageTable, 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $dbm = new DbMessageSource();
        $this->dropTable($dbm->sourceMessageTable);
        $this->dropTable($dbm->messageTable);
    }
}
