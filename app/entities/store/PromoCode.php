<?php

namespace app\entities\store;

use yii\db\ActiveRecord;

/**
 * @property int id
 * @property string title
 * @property string code
 * @property string type
 * @property string value
 * @property string date_start
 * @property string date_end
 * @property string products
 * @property string usage_limit
 * @property string usage_limit_current_user
 * @property string number_of_uses
 * @property string active
 * @property string created_at
 * @property string updated_at
 */
class PromoCode extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%promo_codes}}';
    }

    ####################################################################################################################

    public static function create(): self
    {
        $model = new self();
        $model->active = 0;

        return $model;
    }

    public function edit(
        $title
    )
    {
        $this->title = $title;
    }
}
