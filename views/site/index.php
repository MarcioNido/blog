<?php

/* @var $this yii\web\View */

$this->title = 'Marcio Nido - Web Development';
use yii\helpers\Html;

?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Web Development</h1>
        <p class="lead">With PHP, Yii Framework, AngularJS and other cool tools.</p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Web Application</h2>
                <p>A sample web application developed using Yii Framework.</p>
                <p><?= Html::a("Go to page &raquo;", array('site/php-yii', 'page'=>'project'), array('class'=>'btn btn-default')) ?></p>
            </div>
            <div class="col-lg-4">
                <h2>RESTful API</h2>
                <p>A RESTFul API developed with PHP and Yii Framework.</p>
                <p><?= Html::a("Go to page &raquo;", array('site/restful'), array('class'=>'btn btn-default')) ?></p>
            </div>
            <div class="col-lg-4">
                <h2>Angular JS</h2>
                <p>Sample web application developed with AngularJS.</p>
                <p><?= Html::a("Go to page &raquo;", array('site/angular'), array('class'=>'btn btn-default')) ?></p>
            </div>
        </div>

    </div>
</div>
