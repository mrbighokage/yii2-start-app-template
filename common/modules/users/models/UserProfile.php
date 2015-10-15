<?php

namespace common\modules\users\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property integer $user_id
 *
 * @property User    $user
 */
class UserProfile extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_profile}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['phone', 'site', 'description'], 'string'],
            ['description', 'string', 'length' => [6, 2048]],
            ['phone', 'match', 'pattern' => '/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/', 'message' => Yii::t('users', 'Неправильный формат телефона')],
            ['site', 'url', 'defaultScheme' => 'http'],
            ['birthday', 'date'],
            [
                ['user_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::className(),
                'targetAttribute' => ['user_id' => 'id']
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app', 'ID'),
        ];
    }

}
