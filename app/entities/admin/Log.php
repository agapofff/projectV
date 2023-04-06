<?php

namespace app\entities\admin;

use Yii;
use yii\db\ActiveRecord;

/**
 * @property int id
 * @property string type
 * @property string request
 * @property string response
 * @property string status
 * @property string created_at
 * @property string updated_at
 */
class Log extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%logs}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('admin', 'ID'),
            'type' => Yii::t('admin', 'Тип'),
            'request' => Yii::t('admin', 'Запрос'),
            'response' => Yii::t('admin', 'Ответ'),
            'status' => Yii::t('admin', 'Статус'),
            'created_at' => Yii::t('admin', 'Created date'),
            'updated_at' => Yii::t('admin', 'Updated date'),
        ];
    }

    ####################################################################################################################

    public static function create(
        $type,
        $request,
        $response,
        $status
    ): self
    {
        $model = new self();
        $model->type = $type;
        $model->request = $request;
        $model->response = $response;
        $model->status = $status;

        return $model;
    }

    public function changeStatus($status)
    {
        $this->status = $status;
    }

    ####################################################################################################################

    public static function getTypeList()
    {
        return [
            'order' => Yii::t('admin', 'Обычный заказ'),
            'light-order' => Yii::t('admin', 'Заказ в один клик'),
        ];
    }

    public function getType()
    {
        return $this->getTypeList()[$this->type];
    }

    public static function getStatusList()
    {
        return [
            0 => Yii::t('admin', 'Не обработан'),
            1 => Yii::t('admin', 'Обработан'),
        ];
    }

    public function getStatus()
    {
        return $this->getStatusList()[$this->status];
    }

    public function getResponse()
    {
        return json_decode(htmlspecialchars_decode(str_replace("\r\n", "<br>", $this->response)));
    }
}
