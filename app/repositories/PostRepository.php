<?php

namespace app\repositories;

use app\entities\about\Post;

class PostRepository
{
    public function get($id)
    {
        if (!$model = Post::findOne($id)) {
            throw new NotFoundException('Model is not found.');
        }
        return $model;
    }

    public function getAllByType($lang, $type)
    {
        return Post::find()
            ->where('lang = :lang AND url != "" AND type = :type', [
                'lang' => $lang,
                'type' => $type,
            ])
            ->orderBy('created_at DESC, id DESC');
    }

    public function getAll($type)
    {
        return Post::find()
            ->where('url != "" AND type = :type', [
                'type' => $type,
            ])
            ->orderBy('created_at DESC, id DESC')
            ->all();
    }

    public function getAllAfterDate($type, $lang, $date, $limit)
    {
        return Post::find()
            ->where('type = :type AND lang = :lang AND created_at < STR_TO_DATE(:date, "%Y-%m-%d %H:%i:%s")', [
                'type' => $type,
                'lang' => $lang,
                'date' => $date,
            ])
            ->orderBy('created_at DESC')
            ->limit($limit)
            ->all();
    }

    public function getLastByTypeAndLang($type, $lang)
    {
        return Post::find()
            ->where('type = :type AND lang = :lang', [
                'type' => $type,
                'lang' => $lang,
            ])
            ->orderBy('id')
            ->one();
    }

    public function create(Post $model): Post
    {
        if (!$model->save()) {
            throw new \RuntimeException('Saving error.');
        }
        return $model;
    }

    public function save(Post $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Post $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}
