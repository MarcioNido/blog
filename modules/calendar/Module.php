<?php

namespace app\modules\calendar;

/**
 * calendar module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\calendar\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        // add main project page to the breadcrumbs for all pages of this module ... 
        \Yii::$app->params['breadcrumbs'][] = ['label'=>'Yii2 Project', 'url'=>['//site/php-yii','page'=>'project']];
    }
}
