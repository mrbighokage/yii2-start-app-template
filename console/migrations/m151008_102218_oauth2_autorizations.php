<?php

use yii\db\Migration;
use common\modules\users\models\User;
use frontend\modules\users\models\UserAuth;

class m151008_102218_oauth2_autorizations extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(UserAuth::tableName(), [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'source' => $this->string(255)->notNull(),
            'source_id' => $this->string(255)->notNull(),
        ], $tableOptions);

        $this->addForeignKey('fk-auth-user_id-user-id',
            UserAuth::tableName(), 'user_id',
            User::tableName(), 'id',
            'CASCADE', 'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable(UserAuth::tableName());
    }
}
