<?php

namespace app\repositories;

use app\entities\lang\LangTranslator;

class LangTranslatorRepository
{
    public function get($id)
    {
        if ($model = LangTranslator::findOne($id)) {
            return $model;
        }

        return false;
    }

    public function getAll()
    {
        return LangTranslator::find()
            ->orderBy('id')
            ->all();
    }

    public function getByUserId($user_id)
    {
        $model = LangTranslator::find()
            ->where('user_id = :user_id', [
                'user_id' => $user_id,
            ])
            ->one();
        if (!$model) {
            return $this->get(1);
        }

        return $model;
    }

    public function hasTranslator($lang_id, $user_id)
    {
        return LangTranslator::find()
            ->where('lang_id = :lang_id AND user_id = :user_id', [
                'lang_id' => $lang_id,
                'user_id' => $user_id,
            ])
            ->count();
    }

    public function save(LangTranslator $model)
    {
        if (!$model->save()) {
            throw new \RuntimeException('Saving error.');
        }
        return $model;
    }

    public function remove(LangTranslator $model)
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}
