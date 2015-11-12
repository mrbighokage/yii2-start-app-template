<?php

namespace frontend\modules\users\components;

use Yii;
use yii\authclient\clients\LinkedIn;

use common\modules\users\models\User;
use common\modules\users\models\UserProfile;

use frontend\modules\users\models\UserAuth;

class OAuthLinkedInClient extends LinkedIn
{
    public $attributeNames = [
        'id',
        'email-address',
        'first-name',
        'last-name',
        'public-profile-url',
        'picture-url',
        'location',
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->scope === null) {
            $this->scope = implode(' ', [
                'r_basicprofile',
                'r_emailaddress',
                'rw_company_admin',
                'w_share'
            ]);
        }
    }

    public function signIn() {
        $attributes = $this->getUserAttributes();

        $password = Yii::$app->security->generateRandomString(6);
        $user = new User([
            'email'    => $attributes['email'],
            'password' => $password,
            'first_name' => isset($attributes['first_name']) ? $attributes['first_name'] : '',
            'last_name' => isset($attributes['last_name']) ? $attributes['last_name'] : ''
        ]);

        $user->generateAuthKey();
        $user->generatePasswordResetToken();
        $transaction = $user->getDb()->beginTransaction();
        if ($user->save()) {

            // create empty profile
            $profile = new UserProfile([
                'user_id' => $user->getId()
            ]);
            $profile->save();

            if(isset($attributes['pictureUrl']) && $attributes['pictureUrl']) {

                // upload facebook images
                $fname = basename($attributes['pictureUrl']) . '.jpg';
                $ch = curl_init($attributes['pictureUrl']);
                $fp = fopen(Yii::getAlias('@uploads/users/' . $fname), 'wb');
                curl_setopt($ch, CURLOPT_FILE, $fp);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_exec($ch);
                curl_close($ch);
                fclose($fp);

                $user->avatar = $fname;
            }

            $user->update(false);

            // assign default role ROLE_USER
            $authManager = Yii::$app->authManager;
            $authManager->assign($authManager->getRole(User::ROLE_USER), $user->getId());

            $auth = new UserAuth([
                'user_id'   => $user->id,
                'source'    => $this->getId(),
                'source_id' => (string)$attributes['id'],
            ]);
            if ($auth->save()) {

                $transaction->commit();

                // auto login
                Yii::$app->user->login($user);

                return true;
            } else {
                Yii::$app->getSession()->setFlash('error', 'Auth client  "' . $this->getTitle() . '" not connected');
            }
        } else {
            Yii::$app->getSession()->setFlash('error', 'User "' . $attributes['login'] . '" not register');
        }
        return false;
    }

}
