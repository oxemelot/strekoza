<?php

declare(strict_types=1);

namespace backend\controllers;

use backend\components\BaseBackendController;
use common\models\LoginForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\ErrorAction;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends BaseBackendController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow'   => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     */
    public function actionIndex(): string
    {
        return $this->render('index');
    }

    /**
     * Login action.
     */
    public function actionLogin(): Response|string
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     */
    public function actionLogout(): Response
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
