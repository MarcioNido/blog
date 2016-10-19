<?php

/* @var $this yii\web\View */

$this->title = 'Marcio Nido - Web Development';
use yii\helpers\Html;

?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Web Development</h1>
        <p class="lead">With PHP, Yii Framework and other cool tools.</p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Yii2 Framework Tutorial</h2>
                <p>Build a calendar application from the start using Yii2 Framework, Bootstrap, Codeception.</p>
                <p><?= Html::a("Go to page &raquo;", array('site/php-yii', 'page'=>'project'), array('class'=>'btn btn-default')) ?></p>
            </div>
            <div class="col-lg-4">
                <h2>RESTful API Tutorial</h2>
                <p>Building a RESTFul API with Yii2 Framework.</p>
                <p><?= Html::a("Go to page &raquo;", array('site/rest', 'page'=>'project'), array('class'=>'btn btn-default')) ?></p>
            </div>
            <div class="col-lg-4">
                <h2>RBAC Tutorial</h2>
                <p>Role based access control with Yii2 Framework.</p>
                <p><?= Html::a("Coming soon", 'javascript:void(0)', array('class'=>'btn btn-default', 'disabled' => 'disabled')) ?></p>
            </div>
        </div>

    </div>
</div>
