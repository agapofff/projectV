<?php

namespace app\entities\lang;

use app\repositories\LangTranslationRepository;
use Yii;
use yii\db\ActiveRecord;

/**
 * @property int id
 * @property string category
 * @property int active
 * @property string created_at
 * @property string az_az
 * @property string bg_bg
 * @property string de_de
 * @property string en_us
 * @property string it_it
 * @property string kk_kz
 * @property string ko_kp
 * @property string lt_lt
 * @property string lv_lv
 * @property string mn_mn
 * @property string pl_pl
 * @property string ru_ru
 * @property string sr_sp
 * @property string uk_ua
 * @property string uz_uz
 * @property string vi_vn
 * @property string zh_cn
 * @property string zh_hk
 * @property string zh_tw
 */
class LangTranslation extends ActiveRecord
{
    /**
     * Переменная, для хранения текущего объекта языка
     */
    static $current = null;

    public static function tableName(): string
    {
        return '{{%lang_translations}}';
    }

    ####################################################################################################################

    public static function getUntranslated(string $locale)
    {
        $message = self::getMessage($locale);

        $language_translation = new LangTranslationRepository();
        return $language_translation->getUntranslated($message);
    }

    public static function getTranslated(string $locale)
    {
        $message = self::getMessage($locale);

        $language_translation = new LangTranslationRepository();
        return $language_translation->getTranslated($message);
    }

    ####################################################################################################################

    public static function create(
        string $ru_ru,
        int $active
    ): self
    {
        $model = new self();
        $model->ru_ru = $ru_ru;
        $model->active = $active;

        return $model;
    }

    public function editMessage(
        string $locale,
        string $message
    ) {
        $_message = $this->getMessage($locale);
        $_updated_at = $this->getUpdatedAt($locale);
        $this->$_message = trim($message);
        $this->$_updated_at = date('Y-m-d H:i:s');
    }

    public function editActive(int $active)
    {
        $this->active = $active;
    }

    ####################################################################################################################

    public static function getLocale(string $locale)
    {
        return str_replace('-', '_', $locale);
    }

    public static function getMessage(string $locale)
    {
        return strtolower(self::getLocale($locale));
    }

    public static function getUpdatedAt(string $locale)
    {
        return 'update_at_' . strtolower(self::getLocale($locale));
    }

    public function getUpdatedAtForView(string $locale)
    {
        $message_updated_at_to = $this->getUpdatedAt($locale);

        return substr(str_replace('-', '.', $this->$message_updated_at_to), 0, 16);
    }

    public function isUntranslated(string $locale)
    {
        $message = self::getMessage($locale);
        return empty($this->$message);
    }

    public static function getLinkToDirectory(string $locale): string
    {
        return Yii::getAlias('@app/messages/' . $locale);
    }

    public static function getLinkToFile(string $locale, string $category = 'app'): string
    {
        return Yii::getAlias(self::getLinkToDirectory($locale) . '/' . $category . '.php');
    }
}
