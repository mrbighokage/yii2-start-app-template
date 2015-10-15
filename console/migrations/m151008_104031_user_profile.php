<?php

use yii\db\Migration;
use common\modules\users\models\User;
use common\modules\users\models\UserProfile;

class m151008_104031_user_profile extends Migration
{
    public function up()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(UserProfile::tableName(), [
            'user_id' => $this->primaryKey(),
            'phone' => $this->string(10),
            'site' => $this->string(255),
            'description' => $this->string(2048),
            'birthday' => $this->date()
        ], $tableOptions);

        $this->addForeignKey('fk_profile_user',
            UserProfile::tableName(), 'user_id',
            User::tableName(), 'id',
            'CASCADE', 'RESTRICT'
        );
    }

    public function down()
    {
        $this->dropTable(UserProfile::tableName());
    }
}
