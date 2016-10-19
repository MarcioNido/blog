<?php

/* @var $this yii\web\View */

$this->title = 'REST Project';
use yii\helpers\Html;

$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-index">

    <div class="jumbotron">
        <h1>RESTFul API Tutorial</h1>
        <p>Building a RESTFul API with Yii2 framework.</p>
        
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-12">
                <h2>The Project</h2>
                <p>A RESTFul API with Yii2 Framework to retrieve and update data from the calendar. </p>
                <p>The source code for this project can be found at <a target="_blank" href="https://github.com/MarcioNido/rest-api">https://github.com/MarcioNido/rest-api</a></p>
            </div>
        </div>

        <br />
        
        <div class="row">
            <div class="col-lg-12">
                <div class='list-group'>
                    
                    <?= Html::a("<h4>Starting the new project</h4><p>Starting a new Yii2 basic template project</p>", array('site/rest', 'page'=>'project-start'), array('class'=>'list-group-item')); ?>
                    <?= Html::a("<h4>Database Structure</h4><p>Database structure for the project</p>", array('site/rest', 'page'=>'database-structure'), array('class'=>'list-group-item')); ?>
                    <?= Html::a("<h4>Creating the module</h4><p>Creating the v1 module for versioning purposes</p>", array('site/rest', 'page'=>'v1-module'), array('class' => 'list-group-item')); ?>
                    <?= Html::a("<h4>Creating the models</h4><p>Creating the ActiveRecord Models for our tables</p>", array('site/rest', 'page'=>'models'), array('class'=>'list-group-item')); ?>
                    <?= Html::a("<h4>The Category Controller</h4><p>Category controller</p>", array('site/rest', 'page'=>'category-controller'), array('class'=>'list-group-item')); ?>
                    <?= Html::a("<h4>Configuring the URLs</h4>Making the changes necessary to enable pretty URL", array('site/rest', 'page'=>'pretty-url'), array('class' => 'list-group-item')); ?>
                    <?= Html::a("<h4>The Event Controller</h4><p>Event controller</p>", array('site/rest', 'page'=>'event-controller'), array('class'=>'list-group-item')); ?>
                    <?= Html::a("<h4>Configuring the API Tests</h4><p>API functional tests environment configuration</p>", array('site/rest', 'page'=>'api-test'), array('class'=>'list-group-item')); ?>
                    <?= Html::a("<h4>Authentication</h4><p>User Authentication</p>", array('site/rest', 'page'=>'authentication'), array('class'=>'list-group-item')); ?>
                </div>
            </div>
        </div>

    </div>
</div>
