<?php

namespace app\entities\admin;

use app\entities\store\OrderProduct;
use app\repositories\ProductRepository;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;

/**
 * @property int id
 * @property string sessia_vendor_code
 * @property string sessia_title
 * @property string sessia_img
 * @property string category
 * @property string collection
 * @property string sex
 * @property string problem
 * @property int active
 * @property int position
 * @property string created_at
 * @property string updated_at
 */
class Product extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%products}}';
    }

    public function getTitle(): string
    {
        return $this->id . ' | ' . $this->sessia_title;
    }

    ####################################################################################################################

    public function getSessiaByCurrencyIso()
    {
        return $this->hasOne(ProductSessia::class, ['product_id' => 'id'])->alias('ps')
            ->where('ps.store_id = :store_id', [
                'store_id' => Yii::$app->params['store_id'],
            ])
            ->orderBy('ps.store_id DESC');
    }

    public function getCoverByCurrencyIso()
    {
        return $this->hasOne(ProductImg::class, ['product_id' => 'id'])->alias('pi')
            ->where('pi.currency_iso = ""')
            ->orderBy('pi.position, pi.id');
    }

    public function getImgsByCurrencyIso()
    {
        return $this->hasMany(ProductImg::class, ['product_id' => 'id'])
            ->where('currency_iso = :currency_iso OR currency_iso = ""', [
                'currency_iso' => Yii::$app->params['currency'],
            ])
            ->orderBy('position, id');
    }

    public function getTranslateByLangId()
    {
        return $this->hasOne(ProductTranslate::class, ['product_id' => 'id'])->alias('pt')
            ->where('pt.title != "" AND pt.lang_id = :lang_id', [
                'lang_id' => Yii::$app->params['lang_id'],
            ]);
    }

    public function getDocumentsByLangId()
    {
        return $this->hasMany(ProductDoc::class, ['product_id' => 'id'])
            ->where(['lang_id' => Yii::$app->params['lang_id']])
            ->orderBy('position, id');
    }

    public function getOrderProductQuantity()
    {
        return $this->hasOne(OrderProduct::class, ['product_id' => 'id'])
            ->where(['order_id' => Yii::$app->params['order_id']]);
    }


    public static function checkAvailable($collection)
    {
        $productRepository = new ProductRepository();
        $model = $productRepository->search(' AND collection = :collection', ['collection' => $collection], Yii::$app->params['currency'], Yii::$app->params['store_id']);
        return count($model) > 0;
    }


    /**
     * Для админки
     */
    public function getCountries($id)
    {
        return self::find()->alias('p')
            ->select('
                s.id as store_id,
                s.title as store_title,
                ps.id as product_id,
                p.sessia_title as product_title,
                c.id as country_id,
                c.title as country_title
            ')
            ->innerJoin('tbl_products_sessia ps', 'ps.product_id = p.id')
            ->innerJoin('tbl_stores s', 's.id = ps.store_id')
            ->innerJoin('tbl_store_in_countries sic', 'sic.store_id = ps.store_id')
            ->innerJoin('tbl_countries c', 'c.id = sic.country_id')
            ->where('p.id = :id', [
                'id' => $id,
            ])
            ->orderBy('s.currency_iso, s.id')
            ->asArray()
            ->all();
    }

    public function getSessias()
    {
        return $this->hasMany(ProductSessia::class, ['product_id' => 'id'])->alias('ps')
            ->orderBy('store_id');
    }

    ####################################################################################################################

    public static function createFromSessia(
        $sessia_title,
        $sessia_vendor_code,
        $sessia_img
    ): self
    {
        $model = new self();
        $model->sessia_title = $sessia_title;
        $model->sessia_vendor_code = $sessia_vendor_code;
        $model->sessia_img = $sessia_img;

        return $model;
    }

    public function updateFromSessia(
        $sessia_title,
        $sessia_img
    )
    {
        $this->sessia_title = $sessia_title;
        $this->sessia_img = $sessia_img;
    }

    public function edit(
        $sessia_vendor_code,
        $category,
        $collection,
        $sex,
        $problem,
        $active
    )
    {
        $this->sessia_vendor_code = $sessia_vendor_code;
        $this->category = $category;
        $this->collection = $collection;
        $this->sex = $sex;
        $this->problem = $problem;
        $this->active = $active;
    }

    public function getUrl($from = '')
    {
        return array_filter(['/store/default/product', 'id' => $this->id, 'url' => !empty($this->getTitleToUrl()) ? $this->getTitleToUrl() : 'no-title', 'from' => '']);
    }

    public function getTitleToUrl()
    {
        return ($translate = $this->translateByLangId) ? Inflector::slug(str_replace("&nbsp;", " ", $translate->title)) : 'product';
    }

    public function getDir()
    {
        return '/storage/store/product/' . $this->id . '/';
    }

    ####################################################################################################################

    public static function getCategoryList()
    {
        return [
            [
                'label' => Yii::t('app', 'Нутрицевтики'),
                'url' => 'nutraceuticals',
            ],
            [
                'label' => Yii::t('app', 'Космецевтика'),
                'url' => 'cosmeceuticals',
            ],
            [
                'label' => Yii::t('app', 'Титановые браслеты'),
                'url' => 'titanium-bracelets',
            ],
        ];
    }

    public static function getCategoriesFilter()
    {
        return [
            [
                'label' => Yii::t('app', 'Нутрицевтики'),
                'url' => 'nutraceuticals',
                'items' => [
                    [
                        'label' => 'Classic hit',
                        'url' => 'classic-hit',
                    ],
                    [
                        'label' => 'Direct hit',
                        'url' => 'direct-hit',
                    ],
                    [
                        'label' => 'Junior hit',
                        'url' => 'junior-hit',
                    ],
                ],
            ],
            [
                'label' => Yii::t('app', 'Космецевтика'),
                'url' => 'cosmeceuticals',
                'items' => [
                    [
                        'label' => 'Switzerland cosmetics',
                        'url' => 'switzerland-cosmetics',
                    ],
                    [
                        'label' => 'Premium French Care',
                        'url' => 'premium-french-care',
                    ],
                ],
            ],
            [
                'label' => Yii::t('app', 'Титановые браслеты'),
                'url' => 'titanium-bracelets',
                'items' => [
                    [
                        'label' => Yii::t('admin', 'Trinity Power'),
                        'url' => 'trinity-power',
                    ],
                ],
            ],
        ];
    }

    public function getCategoryName()
    {
        $label = '';
        foreach ($this->getCategoriesFilter() as $category) {
            $find = false;
            $label = $category['label'];
            foreach ($category['items'] as $collection) {
                if ($this->collection === $collection['url']) {
                    $find = true;
                }
            }
            if ($find) {
                break;
            }
        }
        return $label;
    }

    public function getCollectionName()
    {
        $label = '';
        foreach ($this->getCategoriesFilter() as $category) {
            foreach ($category['items'] as $collection) {
                if ($this->collection === $collection['url']) {
                    $label = $collection['label'];
                    break;
                }
            }
        }
        return $label;
    }

    public static function getSexFilter()
    {
        return [
            [
                'label' => Yii::t('app', 'Для женщин'),
                'url' => 'woman',
            ],
            [
                'label' => Yii::t('app', 'Для мужчин'),
                'url' => 'man',
            ],
            [
                'label' => Yii::t('app', 'Для детей'),
                'url' => 'children',
            ],
        ];
    }

    public static function getProblemsFilter()
    {
        $array = [
            [
                'label' => Yii::t('app', 'Мозговая активность'),
                'url' => 'brain-activity',
            ],
            [
                'label' => Yii::t('app', 'Эффективная детоксикация'),
                'url' => 'efficient-detoxification',
            ],
            [
                'label' => Yii::t('app', 'Здоровье сердца'),
                'url' => 'heart-function',
            ],
            [
                'label' => Yii::t('app', 'Молодость кожи'),
                'url' => 'youthful-skin',
            ],
            [
                'label' => Yii::t('app', 'Печень под защитой'),
                'url' => 'liver-protection',
            ],
            [
                'label' => Yii::t('app', 'Здоровье мочеполовой системы'),
                'url' => 'genitourinary-system-health',
            ],
            [
                'label' => Yii::t('app', 'Отличное зрение'),
                'url' => 'perfect-vision',
            ],
            [
                'label' => Yii::t('admin', 'Anti-Age'),
                'url' => 'anti-age',
            ],
            [
                'label' => Yii::t('app', 'Заряд энергии'),
                'url' => 'energy-boost',
            ],
            [
                'label' => Yii::t('app', 'Рост и здоровье детей'),
                'url' => 'growth-and-health-of-kids',
            ],
            [
                'label' => Yii::t('app', 'Стресс под контролем'),
                'url' => 'stress-under-control',
            ],
            [
                'label' => Yii::t('app', 'Здоровые суставы и мышцы'),
                'url' => 'healthy-joints-and-muscles',
            ],
            [
                'label' => Yii::t('app', 'Крепкий иммунитет'),
                'url' => 'strong-immune-system',
            ],
        ];

        usort($array, function($a, $b) {
            return strcmp($a["label"], $b["label"]);
        });

        return $array;
    }

    public function getProblem()
    {
        $label = '';
        foreach ($this->getProblemsFilter() as $problem) {
            if (preg_match("(" . $problem['url'] . ")", $this->problem)) {
                $label .= $problem['label'] . ', ';
            }
        }
        return substr($label, 0, -2);
    }
}
