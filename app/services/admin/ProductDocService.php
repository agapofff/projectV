<?php

namespace app\services\admin;

use app\entities\admin\ProductDoc;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use yii\web\UploadedFile;
use app\repositories\ProductDocRepository;

class ProductDocService
{
    private $productDocRepository;

    public function __construct(
        ProductDocRepository $productDocRepository
    )
    {
        $this->productDocRepository = $productDocRepository;
    }

    public function create($model, $form)
    {
        FileHelper::createDirectory(Url::to('@webroot' . $model->getDir()));

        if ($doc = UploadedFile::getInstance($form, 'doc')) {

            $dir = Url::to('@webroot' . $model->getDir());
            $fileName = $doc->baseName . '.' . $doc->extension;
            $doc->saveAs($dir . $fileName);

            $form->doc = $fileName;
        }

        $productDoc = ProductDoc::create(
            $form->product_id,
            $form->lang_id,
            $form->doc,
            $fileName
        );
        $this->productDocRepository->save($productDoc);
    }

    public function changeTitle(
        $id,
        $title
    )
    {
        $productDoc = $this->productDocRepository->get($id);
        $productDoc->changeTitle($title);
        $this->productDocRepository->save($productDoc);
    }

    public function updatePosition($items)
    {
        $i = 0;
        while (isset($items[$i])) {
            $id = (int)$items[$i];
            $position = $i;
            $this->productDocRepository->updatePosition($id, $position);
            $i++;
        }
    }

    public function remove($id)
    {
        $productDoc = $this->productDocRepository->get((int)$id);

        $file = Url::to('@webroot' . $productDoc->getDir() . $productDoc->doc);
        if (is_file($file)) FileHelper::unlink($file);

        $this->productDocRepository->remove($productDoc);

        return $productDoc;
    }
}
