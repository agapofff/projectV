<?php

namespace app\services\about;

use app\entities\about\Post;
use app\forms\about\PostForm;
use app\repositories\PostRepository;
use Yii;
use yii\helpers\FileHelper;
use yii\helpers\Inflector;
use yii\helpers\Url;
use yii\imagine\Image;
use yii\web\UploadedFile;

class PostService
{
    private $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function create($type)
    {
        $post = Post::create(
            $type,
            Yii::$app->language
        );
        $this->postRepository->save($post);

        FileHelper::createDirectory(Url::to('@webroot' . $post->getDir()));
        FileHelper::createDirectory(Url::to('@webroot' . $post->getDir() . 'imgs/'));

        return $post->id;
    }

    public function edit($id, $currentCover, $currentImg, PostForm $form): void
    {
        $post = $this->postRepository->get($id);

        $form->cover = $this->editImg($post, $form, 'cover', $currentCover);
        $form->img = $this->editImg($post, $form, 'img', $currentImg);

        $post->edit(
            $form->type,
            Inflector::slug($form->title),
            $form->cover,
            $form->img,
            $form->metadata_title,
            $form->metadata_description,
            $form->title,
            $form->announcement,
            $form->text,
            $form->created_at
        );
        $this->postRepository->save($post);
    }

    public function editImg($post, $form, $labelImg, $currentImg = '')
    {
        if ($img = UploadedFile::getInstance($form, $labelImg)) {
            $dir = Url::to('@webroot' . $post->getDir());
            $fileName = date("Ymd-His") . '-' . rand(10, 99) . '.' . $img->extension;
            $img->saveAs($dir . $fileName);

            if ($img->extension !== 'svg') {
                Image::thumbnail($dir . $fileName, Yii::$app->params['images']['post'][$labelImg][0], Yii::$app->params['images']['post'][$labelImg][1])
                    ->save($dir . $fileName, ['quality' => 80]);
                Image::autorotate($dir . $fileName)
                    ->save($dir . $fileName, ['quality' => 100]);
            }

            if (is_file($dir . $currentImg)) unlink($dir . $currentImg);
        } else {
            $fileName = $currentImg;
        }

        return $fileName;
    }

    public function remove($id)
    {
        $post = $this->postRepository->get((int)$id);
        $type = $post->type;

        FileHelper::removeDirectory(Url::to('@webroot' . $post->getDir() . 'imgs/'));
        FileHelper::removeDirectory(Url::to('@webroot' . $post->getDir()));

        $this->postRepository->remove($post);

        return $type;
    }

    public static function getTypeList($type, $constant)
    {
        $typeList = Post::getTypeList();

        $arr = [
            [
                'label' => $constant[35],
                'url' => ['/about/post/index', 'type' => $type],
                'active' => $type === '',
            ],
        ];
        foreach ($typeList as $key => $val) {
            $arr[] = [
                'label' => $val,
                'url' => ['/about/post/index', 'type' => $key],
                'active' => $type === $key,
            ];
        }

        return $arr;
    }
}
