<?php

namespace app\entities\admin;

use yii\db\ActiveRecord;

/**
 * @property int id
 * @property string iso
 * @property int round_scale
 * @property string created_at
 * @property string updated_at
 */
class Currency extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%currencies}}';
    }

    public static function create(
        $id,
        $iso,
        $round_scale
    ): self
    {
        $model = new self();
        $model->id = $id;
        $model->iso = $iso;
        $model->round_scale = $round_scale;

        return $model;
    }

    public function edit(
        $iso,
        $round_scale
    )
    {
        $this->iso = $iso;
        $this->round_scale = $round_scale;
    }
}
