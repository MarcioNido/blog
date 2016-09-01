<?php

/* @var $this yii\web\View */

$this->title = 'Yii2 Project';
use yii\helpers\Html;

$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-index">

    <div class="jumbotron">
        <h1>PHP Yii Framework Project</h1>
        <p>A sample project developed with PHP, Yii 2 Framework, MySQL Database & Bootstrap Framework.</p>
        
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-12">
                <h2>The Project</h2>
                <p>A simple calendar developed with PHP, Yii 2 Framework, MySQL Database and Bootstrap. Create, update and delete events. View calendar in more than one format. Multi-user. </p>
                <p><?= Html::a('Run Project', ['//calendar/event'], ['class' => 'btn btn-success']) ?></p>
            </div>
        </div>

        <br />
        
        <div class="row">
            <div class="col-lg-12">
                <div class='list-group'>
                    <?= Html::a("<h4>Database structure</h4><p>SQL instructions for creating the calendar database</p>", array('site/php-yii', 'page'=>'database-structure'), array('class'=>'list-group-item')); ?>
                    <?= Html::a("<h4>User authentication</h4><p>User authentication with Yii2 Framework and MySQL database</p>", array('site/php-yii', 'page'=>'user-authentication'), array('class'=>'list-group-item')); ?>
                </div>
            </div>
        </div>

    </div>
</div>
