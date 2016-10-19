<?php

/* @var $this yii\web\View */

$this->title = 'Yii2 Project';
use yii\helpers\Html;

$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Yii2 Framework Tutorial</h1>
        <p>Building a simple calendar with PHP, Yii2 Framework, Bootstrap.</p>
        
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-12">
                <h2>The Project</h2>
                <p>A simple application tutorial on Yii2 Framework. Database engine independent using migrations and DAO, testing using codeception with fixtures.</p>
                <p>The source code for this project can be found at <a target="_blank" href="https://github.com/MarcioNido/basic-calendar">https://github.com/MarcioNido/basic-calendar</a></p>
                <p><?= Html::a('Run Project', '/basic-calendar/web/index.php', ['class' => 'btn btn-success']) ?></p>
            </div>
        </div>

        <br />
        
        <div class="row">
            <div class="col-lg-12">
                <div class='list-group'>
                    <?= Html::a("<h4>Setting up the environment</h4><p>Setting up the development environment and creating the project</p>", array('site/php-yii', 'page'=>'environment'), array('class'=>'list-group-item')); ?>
                    <?= Html::a("<h4>Starting the new project</h4><p>Starting a new Yii2 basic template project</p>", array('site/php-yii', 'page'=>'project-start'), array('class'=>'list-group-item')); ?>
                    <?= Html::a("<h4>Configuring Codeception</h4><p>Codeception initial configuration for our tests</p>", array('site/php-yii', 'page'=>'codecept-setup'), array('class'=>'list-group-item')); ?>
                    <?= Html::a("<h4>Changing Bootstrap default styles</h4><p>Some changes to the default Bootstrap style</p>", array('site/php-yii', 'page'=>'bootstrap-styles'), array('class'=>'list-group-item')); ?>
                    <?= Html::a("<h4>Database Connection</h4>Database and Test Database connections", array('site/php-yii', 'page'=>'database-connection'), array('class'=>'list-group-item')); ?>
                    <?= Html::a("<h4>Database Migration</h4>Using the database migration tool", array('site/php-yii', 'page'=>'migration-tool'), array('class'=>'list-group-item')); ?>
                    <?= Html::a("<h4>Changing the user authentication</h4><p>User authentication with Yii2 Framework and MySQL database</p>", array('site/php-yii', 'page'=>'user-authentication'), array('class'=>'list-group-item')); ?>
                    <?= Html::a("<h4>Updating the user model and authentication tests</h4>Changes to the tests to reflect the changes made to the user authentication", array('site/php-yii', 'page'=>'user-tests'), array('class'=>'list-group-item')); ?>
                    <?= Html::a("<h4>The calendar module</h4>Creating a separate module for the calendar funcionality", array("site/php-yii", 'page'=>'calendar-module'), array('class'=>'list-group-item')); ?>
                    <?= Html::a("<h4>Creating the categories functionality</h4><p>Creating the category model, crud and tests</p>", array('site/php-yii', 'page'=>'categories'), array('class'=>'list-group-item')); ?>
                    <?= Html::a("<h4>Creating the events functionality</h4><p>Creating the events model, crud and tests</p>", array('site/php-yii', 'page'=>'events'), array('class'=>'list-group-item')); ?>
                    
                </div>
            </div>
        </div>

    </div>
</div>
