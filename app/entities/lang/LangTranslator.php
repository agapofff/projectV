<?php

namespace app\entities\lang;

use app\entities\user\User;
use Yii;
use yii\db\ActiveRecord;

/**
 * @property int id
 * @property int lang_id
 * @property int user_id
 * @property string created_at
 * @property string updated_at
 */
class LangTranslator extends ActiveRecord
{
    /**
     * Переменная, для хранения текущего объекта языка
     */
    static $current = null;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%lang_translators}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('admin', 'ID'),
            'lang_id' => Yii::t('admin', 'Язык'),
            'user_id' => Yii::t('admin', 'Переводчик'),
            'created_at' => Yii::t('admin', 'Created date'),
            'updated_at' => Yii::t('admin', 'Updated date'),
        ];
    }

    ####################################################################################################

    public function getLang()
    {
        return $this->hasOne(Lang::class, ['id' => 'lang_id'])->alias('l');
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id'])->alias('u');
    }

    ####################################################################################################

    public static function create(
        $lang_id,
        $user_id
    )
    {
        $model = new self();
        $model->lang_id = $lang_id;
        $model->user_id = $user_id;

        return $model;
    }

    public function edit(
        $lang_id,
        $user_id
    )
    {
        $this->lang_id = $lang_id;
        $this->user_id = $user_id;
    }
}
