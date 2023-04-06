<?php

namespace app\repositories;

use app\entities\admin\Log;

class LogRepository
{
    public function get($id)
    {
        if ($model = Log::findOne($id)) {
            return $model;
        }

        return false;
    }

    public function getAll() : array
    {
        return Log::find()
            ->orderBy('id DESC')
            ->all();
    }

    public function create(Log $model) : Log
    {
        if (!$model->save()) {
            throw new \RuntimeException('Saving error.');
        }
        return $model;
    }

    public function save(Log $model) : Log
    {
        if (!$model->save()) {
            throw new \RuntimeException('Saving error.');
        }
        return $model;
    }

    public function remove(Log $model) : void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}
