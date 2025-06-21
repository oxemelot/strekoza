<?php

declare(strict_types=1);

return [
    'components' => [
        'db' => [
            'class'     => \yii\db\Connection::class,
            'dsn'       => 'pgsql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_NAME'),
            'username'  => getenv('DB_USER'),
            'password'  => getenv('DB_PASS'),
            'charset'   => 'utf8',
            'schemaMap' => ['pgsql' => [
                'class'         => 'yii\db\pgsql\Schema',
                'defaultSchema' => getenv('DB_SCHEMA'),
            ]],
        ],
        'mailer' => [
            'class'    => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@common/mail',
        ],
    ],
];
