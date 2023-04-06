<?php

namespace app\repositories;

use app\entities\lang\LangTranslation;

class LangTranslationRepository
{
    public function get($id)
    {
        if ($model = LangTranslation::findOne($id)) {
            return $model;
        }
        
        return false;
    }
    
    public function getAll()
    {
        return LangTranslation::find()
            ->orderBy('position')
            ->all();
    }

    public function checkMessage($message)
    {
        return LangTranslation::find()
            ->where('ru_ru = :ru_ru', [
                'ru_ru' => $message,
            ])
            ->count();
    }

    public function updateActive($message): void
    {
        LangTranslation::updateAll([
            'active' => 1,
        ], ['ru_ru' => $message]);
    }

    public function updateInactive(): void
    {
        LangTranslation::updateAll([
            'active' => 0,
        ]);
    }

    public function findByMessage($message)
    {
        return LangTranslation::find()
            ->where('ru_ru = :ru_ru', [
                'ru_ru' => $message,
            ])
            ->one();
    }

    public function getAllByCategory($category, $empty, $lang_iso)
    {
        $empty = !$empty ? "" : " AND (" . $lang_iso . " IS NULL OR " . $lang_iso . " = '')";
        return LangTranslation::find()
            ->where('quantity = :quantity AND category = :category' . $empty, [
                'quantity' => 1,
                'category' => $category,
            ])
            ->orderBy('position')
            ->all();
    }

    public function getAllForTable()
    {
        return LangTranslation::find()
            ->orderBy('category, position')
            ->all();
    }
    
    public static function getQuantityUntranslated($lang_db, $category)
    {
        return LangTranslation::find()
            ->where('quantity = :quantity AND (' . $lang_db . ' IS NULL OR ' . $lang_db . ' = "") AND category = :category', [
                'quantity' => 1,
                'category' => $category,
            ])
            ->count();
    }
    
    public static function getQuantity($category)
    {
        return LangTranslation::find()
            ->where('quantity = :quantity AND category = :category', [
                'quantity' => 1,
                'category' => $category,
            ])
            ->count();
    }
    
    public static function hasDefaultValue($lang_db, $value)
    {
        $quantity = LangTranslation::find()
            ->where('quantity = :quantity AND ' . $lang_db . ' = :value', [
                'quantity' => 1,
                'value' => $value,
            ])
            ->count();
        
        return $quantity > 0 ? true : false;
    }
    
    public function updatePosition($id, $position): void
    {
        LangTranslation::updateAll([
            'position' => $position,
        ], ['id' => $id]);
    }
    
    public function updateValue($id, $lang_db, $value): void
    {
        LangTranslation::updateAll([
            $lang_db => $value,
        ], ['id' => $id]);
    }
    
    public function save(LangTranslation $model)
    {
        if (!$model->save(false)) {
            throw new \RuntimeException('Saving error.');
        }
        return $model;
    }
    
    public function remove(LangTranslation $model)
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }

    public function getUntranslated(string $message)
    {
        return LangTranslation::find()
            ->where('(' . $message . ' IS NULL OR ' . $message . ' = "") AND active = 1')
            ->count();
    }

    public function getTranslated(string $message)
    {
        return LangTranslation::find()
            ->where($message . ' IS NOT NULL AND ' . $message . ' != "" AND active = 1')
            ->count();
    }
}
