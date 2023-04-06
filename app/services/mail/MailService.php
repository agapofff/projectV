<?php

namespace app\services\mail;

use Yii;

class MailService
{
    public function sendMail($path = null, $params, $from = null, $to = null, $subject, $htmlLayouts = '')
    {
        if (empty($from)) {
            $from = [Yii::$app->params['email-noreply'] => 'noreply'];
        }
    
        if (empty($to)) {
            $to = [Yii::$app->params['email-info'] => Yii::$app->params['name']];
        }

        $sent = Yii::$app->mailer
            ->compose(
                ['html' . $htmlLayouts => $path . '-html', 'text' => $path . '-text'],
                $params
            )
            ->setFrom($from)  // От кого
            ->setTo($to)  // Кому
            ->setSubject($subject)
            ->send();

        if (!$sent) {
            throw new \RuntimeException('Sending error.');
        }
    }
}
