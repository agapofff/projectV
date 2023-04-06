<?php

namespace app\forms\admin;

use yii\base\Model;

/**
 * @property string imageFile
 */
class LangTranslationUploadForm extends Model
{
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xlsx'],
        ];
    }

    public function upload($folder)
    {
        if ($this->validate()) {
            $this->imageFile->saveAs($folder . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return $this->imageFile->baseName . '.' . $this->imageFile->extension;
        }
        return false;
    }
}
