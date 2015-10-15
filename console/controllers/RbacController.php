<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

use common\modules\users\models\User;

/*
 * run console command
 * # yii rbac/init
 * to prepare base RBAC
 *
 * check access for login user
 * \Yii::$app->user->can(User::getAdminPermissionKey())
 *
 * check access for custom user
 * $userPermissions = Yii::$app->authManager->getPermissionsByUser($user->getId());
 * if($userPermissions && isset($userPermissions['namePermission'])) {}
 * */
class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // disable user
        $disable = $auth->createRole(User::ROLE_DISABLE);
        $auth->add($disable);

        // banned user
        $banned = $auth->createRole(User::ROLE_BANNED);
        $auth->add($banned);

        // add default user role
        $user = $auth->createRole(User::ROLE_USER);
        $auth->add($user);

        // add "useAdminPanel" permission
        $adminPermission = $auth->createPermission(User::PERMISSION_ADMIN);
        $adminPermission->description = '';
        $auth->add($adminPermission);

        // add "admin" role
        // as well as the permissions of the "author" role
        $admin = $auth->createRole(User::ROLE_ADMIN);
        $auth->add($admin);
        $auth->addChild($admin, $user);
        $auth->addChild($admin, $adminPermission);

        // Create user admin assign roles
        User::createSuperAdmin();
    }
}