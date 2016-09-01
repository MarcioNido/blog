<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = ['label'=>'Calendar', 'url'=> ['//calendar/event']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <p>
        <?= Html::a("<span class='glyphicon glyphicon-plus'></span> Create Category", ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a("<span class='glyphicon glyphicon-calendar'></span> Back to Calendar", ['//calendar/event'], ['class' => 'btn btn-primary']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'category_id',
            'name',
            'active',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
