<?php

namespace app\forms\lang;

use Yii;
use yii\base\Model;

/**
 * @property int lang_id
 * @property int country_id
 */
class LangInCountryForm extends Model
{
    public $lang_id;
    public $country_id;

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'lang_id' => Yii::t('admin', 'ID языка'),
            'country_id' => Yii::t('admin', 'ID страны'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['lang_id', 'country_id'], 'required'],
        ];
    }
}
