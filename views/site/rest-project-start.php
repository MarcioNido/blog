<?php

/* @var $this yii\web\View */

$this->title = 'REST Project Start';
use yii\helpers\Html;

$this->params['breadcrumbs'][] = ['label' => 'REST Project', 'url' => array('site/rest')];
$this->params['breadcrumbs'][] = $this->title;


// SyntaxHighlighter - http://alexgorbatchev.com/SyntaxHighlighter/manual/installation.html
//$this->registerJsFile('js/sh/shCore.js');
//$this->registerJsFile('js/sh/shBrushSql.js');
//$this->registerCssFile('css/sh/shCore.css');
//$this->registerCssFile('css/sh/shThemeDefault.css');
///////////////////////////////////////////////////////////////////////////////////////////


?>


<link rel="stylesheet" href="js/styles/googlecode.css">
<script src="js/highlight.pack.js"></script>
<script>hljs.initHighlightingOnLoad();</script>

        
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-lg-12">
                
                <h2>REST Project Start</h2>
                <p>Let's start a new Yii2 basic template project for our RESTFul API.</p>
                <p>If you don't have your development environment ready, please refer to the <a href='index.php?r=site/php-yii&page=environment'>Yii2 Framework Tutorial - Yii2 Development Environment Setup</a></p>
                <p>Go to your apps folder and run:</p>
                
                <pre>
                <code class="bash hljs">
composer global require "fxp/composer-asset-plugin:^1.2.0"
composer create-project --prefer-dist yiisoft/yii2-app-basic rest-api
                </code>
                </pre>
                <p>Now we have our new project inside our applications folder with the name rest-api.</p>
                <p>If everything went well, you will see the basic template screen :</p>
                
                <div class='thumbnail'>
                    <img src="images/rest-welcome.png" class="img-responsive"/>
                </div>
                
                <p>Ok, that's it. We have our basic template installed and running.</p>
              
            </div>
        </div>

    </div>
</div>

<script language="javascript">
//    SyntaxHighlighter.all();
</script>
