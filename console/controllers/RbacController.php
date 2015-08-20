<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

use common\modules\users\models\User;

/*
 * run console command
 * # yii rbac/init
 * to prepare base RBAC
 * */
class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // add "useAdminPanel" permission
        $adminPermission = $auth->createPermission(User::getAdminPermissionKey());
        $adminPermission->description = '';
        $auth->add($adminPermission);

        // add "user" role and give this role the "createPost" permission
        $user = $auth->createRole(User::getRoleUserKey());
        $auth->add($user);

        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        $admin = $auth->createRole(User::getRoleAdminKey());
        $auth->add($admin);
        $auth->addChild($admin, $user);
        $auth->addChild($admin, $adminPermission);

        // Create user admin assign roles
        User::createSuperAdmin();
    }
}