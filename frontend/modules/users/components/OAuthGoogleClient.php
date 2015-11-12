<?php

namespace frontend\modules\users\components;

use Yii;
use yii\authclient\clients\GoogleOAuth;

use common\modules\users\models\User;
use common\modules\users\models\UserProfile;

use frontend\modules\users\models\UserAuth;

class OAuthGoogleClient extends GoogleOAuth
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->scope === null) {
            $this->scope = implode(' ', [
                'profile',
                'email',
                'placesLived',
                'organizations'
            ]);
        }
    }

    public function signIn() {
        $attributes = $this->getUserAttributes();

        $password = Yii::$app->security->generateRandomString(6);

        $user = new User([
            'password' => $password,
        ]);

        if($attributes['emails']) {
            $email = current($attributes['emails']);
            $user->email = $email['value'];
        }

        if($attributes['name']) {
            $user->first_name = isset($attributes['name']['givenName']) ? $attributes['name']['givenName'] : '';
            $user->last_name = isset($attributes['name']['familyName']) ? $attributes['name']['familyName'] : '';
        }

        $user->generateAuthKey();
        $user->generatePasswordResetToken();
        $transaction = $user->getDb()->beginTransaction();
        if ($user->save()) {

            // create empty profile
            $profile = new UserProfile([
                'user_id' => $user->getId()
            ]);
            $profile->save();

            if(isset($attributes['image'])) {
                if($attributes['image']['url']) {

                    // upload facebook images
                    $prepareUrl = substr($attributes['image']['url'], 0, strpos($attributes['image']['url'], '?'));
                    $fname = basename($prepareUrl);
                    $ch = curl_init($attributes['image']['url']);
                    $fp = fopen(Yii::getAlias('@uploads/users/' . $fname), 'wb');
                    curl_setopt($ch, CURLOPT_FILE, $fp);
                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_exec($ch);
                    curl_close($ch);
                    fclose($fp);

                    $user->avatar = $fname;
                }
            }

            $user->update(false);

            // assign role default ROLE_USER
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
