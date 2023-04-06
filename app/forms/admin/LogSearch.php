<?php

namespace app\forms\admin;

use app\entities\admin\Log;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class LogSearch extends Model
{
    public $id;
    public $type;
    public $request;
    public $response;
    public $status;

    public function rules()
    {
        return [
            [['id', 'type', 'request', 'response', 'status'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Log::find()
            ->where('request != "" AND response != ""');
 
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 50,
            ],
        ]);

        $dataProvider->setSort([
            'defaultOrder' => ['id' => SORT_DESC],
            'attributes' => [
                'id',
                'type',
                'request',
                'response',
                'status',
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query
            ->andFilterWhere(['=', 'id', $this->id])
            ->andFilterWhere(['=', 'type', $this->type])
            ->andFilterWhere(['like', 'request', $this->request])
            ->andFilterWhere(['like', 'response', $this->response])
            ->andFilterWhere(['=', 'status', $this->status]);

        return $dataProvider;
    }

    public static function getType()
    {
        return Log::getTypeList();
    }

    public static function getStatus()
    {
        return Log::getStatusList();
    }
}
