<?php

namespace app\components;

use yii\widgets\Menu;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;

class MenuActive extends Menu
{
    protected function renderItem($item)
    {
        $pjax = $this->options['classLink'] === 'menu-nav__link' ? ' data-pjax="0"' : '';

        $linkTemplate = '<a href="{url}" class="' . $this->options['classLink'] . '"' . $pjax . '>{label}</a>';
        $linkTemplateActive = '<div class="' . $this->options['classLink'] . '">{label}</div>';

        if (isset($item['url'])) {
            $linkTemplate = $item['active'] == 1 ? $linkTemplateActive : $linkTemplate;
            $template = ArrayHelper::getValue($item, 'template', $linkTemplate);

            return strtr($template, [
                '{activeClass}'=> ($item['active'] == 1) ? 'class="active"' : '',
                '{url}' => Html::encode(Url::to($item['url'])),
                '{label}' => $item['label'],
            ]);
        }

        $template = ArrayHelper::getValue($item, 'template', $linkTemplateActive);

        return strtr($template, [
            '{label}' => $item['label'],
        ]);
    }
}
