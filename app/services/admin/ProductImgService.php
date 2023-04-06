<?php

namespace app\services\admin;

use app\entities\admin\ProductImg;
use Yii;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use yii\imagine\Image;
use yii\web\UploadedFile;
use app\repositories\ProductImgRepository;

class ProductImgService
{
    private $productImgRepository;

    public function __construct(
        ProductImgRepository $productImgRepository
    )
    {
        $this->productImgRepository = $productImgRepository;
    }

    public function create($model, $form)
    {
        FileHelper::createDirectory(Url::to('@webroot' . $model->getDir()));

        if ($img = UploadedFile::getInstance($form, 'img')) {

            $dir = Url::to('@webroot' . $model->getDir());
            $fileName = date("Ymd-His") . '.' . $img->extension;
            $img->saveAs($dir . $fileName);

            $form->img = $fileName;

            $imgParams = Yii::$app->params['images']['product'];

            Image::autorotate($dir . $fileName)
                ->save($dir . $fileName, ['quality' => 100]);
            Image::resize($dir . $fileName, $imgParams['img'][0], $imgParams['img'][1])
                ->save($dir . $fileName, ['quality' => 80]);
            Image::resize($dir . $fileName, $imgParams['img-prev'][0], $imgParams['img-prev'][1])
                ->save($dir . $model->getPrevName($fileName), ['quality' => 80]);
        }

        $productImg = ProductImg::create(
            $form->product_id,
            $form->img
        );
        $this->productImgRepository->save($productImg);
    }

    public function updatePosition($items)
    {
        $i = 0;
        while (isset($items[$i])) {
            $id = (int)$items[$i];
            $position = $i;
            $this->productImgRepository->updatePosition($id, $position);
            $i++;
        }
    }

    public function updateIso($id, $iso)
    {
        $productImg = $this->productImgRepository->get($id);
    
        $productImg->updateIso(
            $iso
        );
        $this->productImgRepository->save($productImg);
    }

    public function remove($id)
    {
        $productImg = $this->productImgRepository->get((int)$id);

        $file = Url::to('@webroot' . $productImg->getDir() . $productImg->img);
        if (is_file($file)) FileHelper::unlink($file);

        $file = Url::to('@webroot' . $productImg->getDir() . $productImg->getPrevName($productImg->img));
        if (is_file($file)) FileHelper::unlink($file);

        $this->productImgRepository->remove($productImg);

        return $productImg;
    }
}
