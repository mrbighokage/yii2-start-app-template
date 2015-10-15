<?php

namespace common\modules\users\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{

    // default isGuest
    const ROLE_GUEST = 0;

    // active user
    const ROLE_ADMIN = 1;
    const ROLE_USER = 2;

    // inactive user
    const ROLE_DISABLE = 10;
    const ROLE_BANNED = 11;

    // permissions
    const PERMISSION_ADMIN = 'AdminPermissionKey';

    public $password;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['password', 'safe'],
            ['username', 'string'],
            ['email', 'email'],
            [['username', 'status', 'email'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        $userPermissions = Yii::$app->authManager->getRolesByUser($id);
        if($userPermissions && isset($userPermissions[User::ROLE_USER])) {
            return static::findOne(['id' => $id]);
        }
        return null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $user = static::findOne(['username' => $username]);
        $userPermissions = Yii::$app->authManager->getRolesByUser($user->id);
        if($userPermissions && isset($userPermissions[User::ROLE_USER])) {
            return $user;
        }
        return null;
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        $user = static::findOne([
            'password_reset_token' => $token,
        ]);
        $userPermissions = Yii::$app->authManager->getRolesByUser($user->id);
        if($userPermissions && isset($userPermissions[User::ROLE_USER])) {
            return $user;
        }

        return null;
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public static  function createSuperAdmin() {

        if(!self::findByUsername(Yii::$app->params['admin.Username'])) {
            $user = new User();
            $user->password_reset_token = '';
            $user->username = Yii::$app->params['admin.Username'];
            $user->email = Yii::$app->params['admin.Email'];
            $user->setPassword(Yii::$app->params['admin.Password']);
            $user->generateAuthKey();

            if ($user->save()) {

                // Assign role admin to root user
                $auth = Yii::$app->authManager;
                $auth->assign($auth->getRole(Yii::$app->params['admin.Username']), $user->getId());
            }
        }
    }
}
