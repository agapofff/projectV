<?php

namespace app\forms\admin;

use Yii;
use yii\base\Model;

/**
 * @property int id
 * @property string category
 * @property int position
 * @property string created_at
 * @property int quantity
 * @property string az_az
 * @property string bg_bg
 * @property string de_de
 * @property string en_us
 * @property string fr_fr
 * @property string hu_hu
 * @property string hy_am
 * @property string it_it
 * @property string kk_kz
 * @property string ko_kp
 * @property string lt_lt
 * @property string lv_lv
 * @property string mn_mn
 * @property string pl_pl
 * @property string pt_pt
 * @property string ru_ru
 * @property string sr_sp
 * @property string uk_ua
 * @property string uz_uz
 * @property string vi_vn
 * @property string zh_cn
 * @property string zh_hk
 * @property string zh_tw
 *
 */
class LangTranslationForm extends Model
{
    public $id;
    public $category;
    public $position;
    public $created_at;
    public $quantity;
    public $az_az;
    public $update_at_az_az;
    public $bg_bg;
    public $update_at_bg_bg;
    public $de_de;
    public $update_at_de_de;
    public $en_us;
    public $update_at_en_us;
    public $fr_fr;
    public $update_at_fr_fr;
    public $hu_hu;
    public $update_at_hu_hu;
    public $hy_am;
    public $update_at_hy_am;
    public $it_it;
    public $update_at_it_it;
    public $kk_kz;
    public $update_at_kk_kz;
    public $ko_kp;
    public $update_at_ko_kp;
    public $lt_lt;
    public $update_at_lt_lt;
    public $lv_lv;
    public $update_at_lv_lv;
    public $mn_mn;
    public $update_at_mn_mn;
    public $pl_pl;
    public $update_at_pl_pl;
    public $pt_pt;
    public $update_at_pt_pt;
    public $ru_ru;
    public $update_at_ru_ru;
    public $sr_sp;
    public $update_at_sr_sp;
    public $uk_ua;
    public $update_at_uk_ua;
    public $uz_uz;
    public $update_at_uz_uz;
    public $vi_vn;
    public $update_at_vi_vn;
    public $zh_cn;
    public $update_at_zh_cn;
    public $zh_hk;
    public $update_at_zh_hk;
    public $zh_tw;
    public $update_at_zh_tw;

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('admin', 'ID'),
            'category' => Yii::t('admin', 'Категория'),
            'position' => Yii::t('admin', 'Позиция'),
            'az_az' => Yii::t('admin', 'Текст'),
            'bg_bg' => Yii::t('admin', 'Текст'),
            'de_de' => Yii::t('admin', 'Текст'),
            'en_us' => Yii::t('admin', 'Текст'),
            'fr_fr' => Yii::t('admin', 'Текст'),
            'hu_hu' => Yii::t('admin', 'Текст'),
            'hy_am' => Yii::t('admin', 'Текст'),
            'it_it' => Yii::t('admin', 'Текст'),
            'kk_kz' => Yii::t('admin', 'Текст'),
            'ko_kp' => Yii::t('admin', 'Текст'),
            'lt_lt' => Yii::t('admin', 'Текст'),
            'lv_lv' => Yii::t('admin', 'Текст'),
            'mn_mn' => Yii::t('admin', 'Текст'),
            'pl_pl' => Yii::t('admin', 'Текст'),
            'pt_pt' => Yii::t('admin', 'Текст'),
            'ru_ru' => Yii::t('admin', 'Текст'),
            'sr_sp' => Yii::t('admin', 'Текст'),
            'uk_ua' => Yii::t('admin', 'Текст'),
            'uz_uz' => Yii::t('admin', 'Текст'),
            'vi_vn' => Yii::t('admin', 'Текст'),
            'zh_cn' => Yii::t('admin', 'Текст'),
            'zh_hk' => Yii::t('admin', 'Текст'),
            'zh_tw' => Yii::t('admin', 'Текст'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['id', 'category'], 'required'],
            [['quantity'], 'safe'],
            [['az_az', 'bg_bg', 'de_de', 'en_us', 'fr_fr', 'hu_hu', 'hy_am', 'it_it', 'kk_kz', 'ko_kp', 'lt_lt', 'lv_lv', 'mn_mn', 'pl_pl', 'pt_pt', 'ru_ru', 'sr_sp', 'uk_ua', 'uz_uz', 'vi_vn', 'zh_cn', 'zh_hk', 'zh_tw'], 'trim'],
            [['az_az', 'bg_bg', 'de_de', 'en_us', 'fr_fr', 'hu_hu', 'hy_am', 'it_it', 'kk_kz', 'ko_kp', 'lt_lt', 'lv_lv', 'mn_mn', 'pl_pl', 'pt_pt', 'ru_ru', 'sr_sp', 'uk_ua', 'uz_uz', 'vi_vn', 'zh_cn', 'zh_hk', 'zh_tw'], 'safe'],
        ];
    }
}
