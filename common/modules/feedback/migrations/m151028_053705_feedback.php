<?php

use yii\db\Migration;
use common\modules\feedback\models\Feedback;

class m151028_053705_feedback extends Migration
{
    public function up()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(Feedback::tableName(), [
            'id' => $this->primaryKey(),
            'status' => $this->smallInteger(2),
            'username' => $this->string(255),
            'email' => $this->string(255),
            'title' => $this->string(255),
            'message' => $this->string(2024),
            'created_at' => $this->integer(10),
        ], $tableOptions);


    }

    public function down()
    {
        $this->dropTable(Feedback::tableName());
        return false;
    }
}
