<?php

namespace frontend\modules\users\models;

use Yii;
use yii\db\ActiveRecord;

use common\modules\users\models\User;

/**
 * @property integer $id
 * @property integer $user_id
 * @property string  $source
 * @property string  $source_id
 *
 * @property User    $user
 */
class UserAuth extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_auth}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'source', 'source_id'], 'required'],
            [['user_id'], 'integer'],
            [['source', 'source_id'], 'string', 'max' => 255],
            [
                ['user_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => User::className(),
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
            'id'        => Yii::t('app', 'ID'),
            'user_id'   => Yii::t('app', 'User ID'),
            'source'    => Yii::t('app', 'Source'),
            'source_id' => Yii::t('app', 'Source ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
