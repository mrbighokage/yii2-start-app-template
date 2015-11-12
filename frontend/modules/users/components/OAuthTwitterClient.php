<?php

namespace frontend\modules\users\components;

use Yii;
use yii\authclient\clients\Twitter;

use common\modules\users\models\User;
use common\modules\users\models\UserProfile;

use frontend\modules\users\models\UserAuth;

class OAuthTwitterClient extends Twitter
{
    public function signIn() {
        return false;
    }
}
