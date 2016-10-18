<?php

/* @var $this yii\web\View */

$this->title = 'Calendar Module';
use yii\helpers\Html;

$this->params['breadcrumbs'][] = ['label' => 'Yii2 Project', 'url' => array('site/php-yii')];
$this->params['breadcrumbs'][] = $this->title;
?>
<link rel="stylesheet" href="js/styles/googlecode.css">
<script src="js/highlight.pack.js"></script>
<script>hljs.initHighlightingOnLoad();</script>
        
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-lg-12">
                
                <h2>Creating the Calendar Module</h2>
                <p>This is a small example application, but if our application tends to grow, the best thing is to organize it from the start.</p>
                <p>For organization and portability purposes we will create a module for the calendar functionalities.</p>
                <p>For that we can use again Gii and create the module:</p>
                
                <div class="thumbnail">
                    <img class="img-responsive" src="images/ss-calendar-module.png" />
                </div>
                
                <p>This will generate the necessary folders and module class. But for our application to recognize the module we still have to add the module to @app/config/web.php, to the $config array, like this:</p>
                <pre>
                    <code class="php">
'modules' => [
    'calendar' => [
        'class' => 'app\modules\calendar\Module',
    ],
],                          
</code>
                </pre>
                

            </div>
            
        </div>

    </div>
    
</div>

