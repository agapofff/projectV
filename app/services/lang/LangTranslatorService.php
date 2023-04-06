<?php

namespace app\services\lang;

use app\entities\lang\LangTranslation;
use app\repositories\LangRepository;
use Yii;

class LangTranslatorService
{
    private $langRepository;

    public function __construct(
        LangRepository $langRepository
    )
    {
        $this->langRepository = $langRepository;
    }

    public function information()
    {
        $langs = $this->langRepository->getAllActiveExceptDefault();

        $arr = [];

        foreach ($langs as $lang) {
            foreach ($lang->translators as $translator) {
                if ($user = $translator->user) {
                    $untranslated_messages = LangTranslation::getUntranslated($lang->iso);
                    if ($untranslated_messages > 0) {
                        $arr[$user->username] = (object) [
                            'quantity' => $untranslated_messages,
                            'lang' => $lang->name,
                        ];
                    }
                }
            }
        }

        foreach ($arr as $email => $info) {
            $rowsInfo = Yii::t('admin', '{number, plural, one{# строка} few{# строки} many{# строк} other{# строк}}, которые необходимо перевести.', [
                    'number' => $info->quantity,
                ]) . '<br>';
            //$this->sendEmail($rowsInfo, $info->lang, $email);
        }
    }

    public function sendEmail($rowsInfo, $lang, $to)
    {
        $message = Yii::$app->mailer
            ->compose(
                ['html' => 'lang/translator/cron-html', 'text' => 'lang/translator/cron-text'],
                [
                    'rowsInfo' => $rowsInfo,
                    'lang' => $lang,
                ]
            )
            ->setFrom(Yii::$app->params['email-info'])
            ->setTo($to)
            ->setSubject(Yii::t('admin', 'Необходим перевод на {lang}', ['lang' => $lang], 'ru-RU'))
            ->send();
        if (!$message) {
            throw new \RuntimeException('Sending error.');
        }
    }
}
