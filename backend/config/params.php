<?php
return [
    'baseSideMenu' => [
        'dashboard' => [
            'visible' => 1,
            'label' => Yii::t('app', 'Dashboard'),
            'img' => 'dashboard',
            'url' => '/',
            'options' => [],
            'items' => [],
        ],
        'users' => [
            'visible' => 1,
            'label' => Yii::t('app', 'Users'),
            'img' => 'users',
            'url' => "/users",
            'options' => [],
            'items' => [],
        ],
        'comments' => [
            'visible' => 1,
            'label' => Yii::t('app', 'Comments'),
            'img' => 'comment',
            'url' => "/comments",
            'options' => [],
            'items' => [],
        ],
    ],
];
