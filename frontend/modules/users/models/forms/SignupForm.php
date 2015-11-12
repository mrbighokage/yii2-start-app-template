<?php
namespace frontend\modules\users\models\forms;

use Yii;
use yii\base\Model;

use common\modules\users\models\User;
use common\modules\users\models\UserProfile;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $repeat_password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username',  'email', 'password', 'repeat_password'], 'required'],

            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\modules\users\models\User', 'message' => Yii::t('users', 'Этот логин уже зханят')],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\modules\users\models\User', 'message' => Yii::t('users', 'Этот E-Mail уже есть в системе')],

            [['password', 'repeat_password'], 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();

            // start transaction
            $transaction = $user->getDb()->beginTransaction();
            if ($user->save()) {

                // create empty profile
                $profile = new UserProfile([
                    'user_id' => $user->getId()
                ]);
                $profile->save();

                // assign disable user role ROLE_DISABLE
                $authManager = Yii::$app->authManager;
                $authManager->assign($authManager->getRole(User::ROLE_DISABLE), $user->getId());

                // end transaction
                $transaction->commit();

                return $user;
            }
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username'   => Yii::t('users', 'Логин'),
            'email'    => Yii::t('users', 'E-Mail'),
            'password' => Yii::t('users', 'Пароль'),
            'repeat_password' => Yii::t('users', 'Повторите пароль')
        ];
    }
}
