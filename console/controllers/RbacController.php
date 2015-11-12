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
        $disable->description = 'User Disable';
        $auth->add($disable);

        // banned user
        $banned = $auth->createRole(User::ROLE_BANNED);
        $banned->description = 'User Banned';
        $auth->add($banned);

        // add default user role
        $guest = $auth->createRole(User::ROLE_GUEST);
        $guest->description = 'Guest Role';
        $auth->add($guest);

        // add user login permission
        $userPermission = $auth->createPermission(User::PERMISSION_USER_LOGIN);
        $userPermission->description = 'Permission User Login';
        $auth->add($userPermission);

        // add default user role
        $user = $auth->createRole(User::ROLE_USER);
        $user->description = 'User Default Role';
        $auth->add($user);
        $auth->addChild($user, $guest);
        $auth->addChild($user, $userPermission);

        // add moderator role
        $moderator = $auth->createRole(User::ROLE_MODERATOR);
        $moderator->description = 'User Moderator Role';
        $auth->add($moderator);
        $auth->addChild($moderator, $user);

        // add "useAdminPanel" permission
        $adminPermission = $auth->createPermission(User::PERMISSION_ADMIN_LOGIN);
        $adminPermission->description = 'Permission Admin Login';
        $auth->add($adminPermission);

        // add "admin" role
        // as well as the permissions of the "author" role
        $admin = $auth->createRole(User::ROLE_ADMIN);
        $admin->description = 'User Super Admin';
        $auth->add($admin);
        $auth->addChild($admin, $moderator);
        $auth->addChild($admin, $adminPermission);

        // Create user admin assign roles
        User::createSuperAdmin();
    }
}