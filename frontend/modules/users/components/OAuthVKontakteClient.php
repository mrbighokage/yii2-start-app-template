<?php

namespace frontend\modules\users\components;

use Yii;
use yii\authclient\clients\VKontakte;

use common\modules\users\models\User;
use common\modules\users\models\UserProfile;

use frontend\modules\users\models\UserAuth;

class OAuthVKontakteClient extends VKontakte
{
    /**
     * @var array list of attribute names, which should be requested from API to initialize user attributes.
     * @since 2.0.4
     */
    public $attributeNames = [
        'uid',
        'first_name',
        'last_name',
        'nickname',
        'screen_name',
        'sex',
        'bdate',
        'city',
        'country',
        'timezone',
        'photo'
    ];

    public function signIn() {
        return false;
    }
}
