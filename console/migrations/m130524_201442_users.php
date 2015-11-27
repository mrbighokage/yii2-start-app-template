<?php

use yii\db\Migration;
use common\modules\users\models\User;

class m130524_201442_users extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(User::tableName(), [
            'id' => $this->primaryKey(),
            'username' => $this->string(32)->notNull()->unique(),
            'email' => $this->string()->notNull()->unique(),

            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),

            'first_name' => $this->string(32),
            'last_name' => $this->string(32),

            'photo' => $this->string(255),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable(User::tableName());
    }
}
