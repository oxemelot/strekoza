<?php

declare(strict_types=1);

return [
    'id'         => 'app-common-tests',
    'basePath'   => dirname(__DIR__),
    'components' => [
        'user' => [
            'class'         => \yii\web\User::class,
            'identityClass' => 'common\models\User',
        ],
    ],
];
