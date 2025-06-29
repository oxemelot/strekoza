<?php

declare(strict_types=1);

return [
    'id'             => getenv('APP_NAME'),
    'name'           => getenv('APP_TITLE'),
    'timeZone'       => 'Europe/Moscow',
    'sourceLanguage' => 'ru',
    'language'       => 'ru',
    'aliases'        => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class'    => \yii\i18n\PhpMessageSource::class,
                    'basePath' => '@common/messages',
                ],
            ],
        ],
    ],
];
