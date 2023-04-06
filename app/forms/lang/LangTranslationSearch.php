<?php

namespace app\forms\lang;

use app\entities\lang\LangTranslation;

class LangTranslationSearch extends LangTranslation
{
    public function search(string $locale_from = 'ru-RU', string $locale_to, string $filter = null)
    {
        $query = self::find()
            ->where(['active' => 1])
            ->orderBy('ru_ru ASC');

        if ($filter === 'untranslated') {
            $message_to = $this->getMessage($locale_to);
            $query->andWhere($message_to . ' IS NULL OR ' . $message_to . ' = ""');
        } elseif ($filter === 'variable') {
            $message_to = $this->getMessage($locale_from);
            $query->andWhere($message_to . ' LIKE "%{%"');
        }

        return $query->all();
    }
}
