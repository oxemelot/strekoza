<?php

declare(strict_types=1);

namespace frontend\tests\unit\models;

use Codeception\Test\Unit;
use frontend\models\ContactForm;
use yii\mail\MessageInterface;

class ContactFormTest extends Unit
{
    public function testSendEmail()
    {
        $model = new ContactForm();

        $model->attributes = [
            'name'    => 'Tester',
            'email'   => 'tester@example.com',
            'subject' => 'very important letter subject',
            'body'    => 'body of current message',
        ];

        verify($model->sendEmail('admin@example.com'))->notEmpty();

        // using Yii2 module actions to check email was sent
        $this->tester->seeEmailIsSent();

        /** @var MessageInterface  $emailMessage */
        $emailMessage = $this->tester->grabLastSentEmail();
        verify($emailMessage)->instanceOf(MessageInterface::class);
        verify($emailMessage->getTo())->arrayHasKey('admin@example.com');
        verify($emailMessage->getFrom())->arrayHasKey('noreply@example.com');
        verify($emailMessage->getReplyTo())->arrayHasKey('tester@example.com');
        verify($emailMessage->getSubject())->equals('very important letter subject');
        verify($emailMessage->toString())->stringContainsString('body of current message');
    }
}
