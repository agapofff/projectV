<?php

namespace app\services\contacts;

use app\services\mail\MailService;
use Yii;

class ContactService
{
    private $mailService;

    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    public function sendMailWrite($name, $email, $text)
    {
        $params = [
            'name' => $name,
            'email' => $email,
            'text' => $text,
        ];

        $subject = Yii::t('admin', 'Обратная связь из формы «Напишите нам»');

        $this->mailService->sendMail($path = 'contacts/contacts/write', $params, null, null, $subject);
    }

    public function sendMailCall($name, $phone)
    {
        $params = [
            'name' => $name,
            'phone' => $phone,
        ];

        $subject = Yii::t('admin', 'Обратная связь из формы «Позвоните мне»');

        $this->mailService->sendMail($path = 'contacts/contacts/call', $params, null, null, $subject);
    }
}
