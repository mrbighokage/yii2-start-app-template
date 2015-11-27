<?php
    use common\modules\users\models\User;
    use common\helpers\ThumbHelper;
?>

<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <!--<img src="<?/*= $directoryAsset */?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>-->
                <?= ThumbHelper::getImg(Yii::$app->user->identity->avatar, 45, 45, ['class' => 'img-circle', 'alt' => 'User Image']) ?>
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity->title ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'Menu', 'options' => ['class' => 'header']],
                    [
                        'label' => 'Users',
                        'icon' => 'fa fa-users',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Create User', 'icon' => 'fa fa-plus', 'url' => '/admin/users/default/create'],
                            ['label' => 'Users list', 'icon' => 'fa fa-list', 'url' => '/admin/users/default/index']
                        ]
                    ],

                    // System menu uses only super admin in debug mode
                    ['label' => 'System', 'options' => ['class' => 'header'], 'visible' => (YII_DEBUG && \Yii::$app->user->can(User::PERMISSION_ADMIN_EDIT_ALL_CONTENT))],
                    [
                        'label' => 'Same tools',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'visible' => (YII_DEBUG && \Yii::$app->user->can(User::PERMISSION_ADMIN_EDIT_ALL_CONTENT)),
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii']],
                            ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug']],
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
