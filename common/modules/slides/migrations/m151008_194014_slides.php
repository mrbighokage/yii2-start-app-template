<?php

use yii\db\Migration;
use common\modules\Slides\models\Slide;

class m151008_194014_slides extends Migration
{
    public function up()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(Slide::tableName(), [
            'id' => $this->primaryKey(),
            'type' => $this->smallInteger(2),
            'url' => $this->string(1024)->notNull(),
            'status' => $this->smallInteger(2),
            'order' => $this->integer(10),
            'title' => $this->string(255),
            'comment' => $this->string(1024),
            'image' => $this->string(255)->notNull(),
            'created_at' => $this->integer(10),
            'updated_at' => $this->integer(10),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable(Slide::tableName());
    }

}
