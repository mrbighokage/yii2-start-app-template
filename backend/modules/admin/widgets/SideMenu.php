<?php
/**
 * Created by PhpStorm.
 * User: mrbighokage
 * Date: 20.08.15
 * Time: 17:18
 */

namespace backend\modules\admin\widgets;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\icons\Icon;

/**
 * 'items' => [
 *    'dashboard' => [
 *       'visible' => 1,
 *       'label' => 'Dashboard',
 *       'img' => 'dashboard', // => Icon::show('dashboard')
 *       'url' => Yii::$app->homeUrl,
 *       'options' => [],
 *       'linkOptions\ => [],
 *       'items' => [],
 *    ],
 * ]
 */

class SideMenu extends \yii\bootstrap\Widget {
    private $items = [];

    private function loadMenu() {
        return array_merge(
            $this->items,
            isset(Yii::$app->params['baseSideMenu']) ? Yii::$app->params['baseSideMenu'] : []
        );
    }

    public function init() {
        parent::init();
        Html::addCssClass($this->options, 'nav');
        $items = $this->loadMenu();
        $list = $this->renderItems($items);
        $container = Html::tag('div', $list, ['class' => 'sidebar-collapse']);
        echo Html::tag('nav', $container, ['class' => 'navbar-inverse navbar-static-side']);
    }

    private function renderItems($items, $depth = 0) {
        $values = [];
        $dropdown_options = $this->options;
        if($depth) {
            Html::addCssClass($dropdown_options, 'dropdown-menu');
            Html::addCssClass($dropdown_options, 'nav-second-level');
        } else {
            Html::addCssClass($dropdown_options, 'side-nav');
        }
        $depth++;
        foreach ($items as $item) {
            if (isset($item['visible']) && !$item['visible']) {
                continue;
            }
            $values[] = $this->renderItem($item, $depth);
        }
        return Html::tag('ul', implode("\n", $values), $dropdown_options);
    }

    private function getUrl($item) {
        $i_url = ArrayHelper::getValue($item, 'url', []);
        $url = Yii::$app->homeUrl;
        if(($i_url && $i_url != '#')) {
            $url = Yii::$app->homeUrl . $i_url;
        }
        return $url;
    }

    private function renderItem($item, $depth) {
        $label = $item['label'];
        $items = ArrayHelper::getValue($item, 'items', []);
        $options = ArrayHelper::getValue($item, 'options', []);
        $linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);
        $icon = ArrayHelper::getValue($item, 'img', []);
        $img = $icon ? Icon::show($icon) : Html::tag('i', '', ['class' => 'fa fa-fw']);
        $url = $this->getUrl($item);
        if (is_array($items) && count($items)) {
            Html::addCssClass($linkOptions, 'dropdown-toggle');
            $linkOptions['data-toggle'] = 'dropdown';
            $label .= Html::tag('b', '', ['class' => 'caret']);
            $items = $this->renderItems($items, $depth);
            $options['class'] = 'dropdown clearfix';
        } else {
            $linkOptions['data-method'] = 'post';
            $items = '';
        }
        return Html::tag('li', Html::a(($img . " " . $label), $url, $linkOptions) . $items, $options);
    }
}