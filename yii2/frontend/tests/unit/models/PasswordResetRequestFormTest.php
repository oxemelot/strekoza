<?php

declare(strict_types=1);

namespace frontend\tests\unit\models;

use Codeception\Test\Unit;
use common\fixtures\UserFixture as UserFixture;
use common\models\User;
use frontend\models\PasswordResetRequestForm;
use frontend\tests\UnitTester;
use Yii;
use yii\mail\MessageInterface;

class PasswordResetRequestFormTest extends Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;

    public function _before()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class'    => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php',
            ],
        ]);
    }

    public function testSendMessageWithWrongEmailAddress()
    {
        $model = new PasswordResetRequestForm();
        $model->email = 'not-existing-email@example.com';
        verify($model->sendEmail())->false();
    }

    public function testNotSendEmailsToInactiveUser()
    {
        $user = $this->tester->grabFixture('user', 1);
        $model = new PasswordResetRequestForm();
        $model->email = $user['email'];
        verify($model->sendEmail())->false();
    }

    public function testSendEmailSuccessfully()
    {
        $userFixture = $this->tester->grabFixture('user', 0);

        $model = new PasswordResetRequestForm();
        $model->email = $userFixture['email'];
        $user = User::findOne(['password_reset_token' => $userFixture['password_reset_token']]);

        verify($model->sendEmail())->notEmpty();
        verify($user->password_reset_token)->notEmpty();

        $emailMessage = $this->tester->grabLastSentEmail();
        verify($emailMessage)->instanceOf(MessageInterface::class);
        verify($emailMessage->getTo())->arrayHasKey($model->email);
        verify($emailMessage->getFrom())->arrayHasKey(Yii::$app->params['supportEmail']);
    }
}
