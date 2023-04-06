<?php

namespace app\forms\admin;

use Yii;
use yii\base\Model;

/**
 * @property string type
 * @property string request
 * @property string response
 * @property string status
 */
class LogForm extends Model
{
    public $type;
    public $request;
    public $response;
    public $status;

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'type' => Yii::t('admin', 'Тип'),
            'request' => Yii::t('admin', 'Запрос'),
            'response' => Yii::t('admin', 'Ответ'),
            'status' => Yii::t('admin', 'Статус'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['type', 'request'], 'required'],
            [['request', 'response'], 'trim'],
            [['response', 'status'], 'safe'],
        ];
    }
}
