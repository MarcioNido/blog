<?php

/* @var $this yii\web\View */

$this->title = 'Yii2 Basic Template Project Start';
use yii\helpers\Html;

$this->params['breadcrumbs'][] = ['label' => 'Yii2 Project', 'url' => array('site/php-yii')];
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
                
                <h2>Yii2 Basic Template Project Start</h2>
                <p>For the calendar project I will start a new Yii2 basic template project. I will not use the advanced template created on the environment setup section.</p>
                <p>To do that, access your virtual server via ssh. Go to your applications folder, in my case "/app" and create the new project with these commands:</p>
                
                <pre>
                <code class="bash hljs">
composer global require "fxp/composer-asset-plugin:^1.2.0"
composer create-project --prefer-dist yiisoft/yii2-app-basic basic-calendar
                </code>
                </pre>
                <p>Now we have our new project inside our applications folder with the name basic-calendar.</p>
                <p>If you open a browser in your client machine you can already view the basic project running. In our case: http://apps.dev/basic-calendar/web/. Notice that here we have to put the "/web" at the end of the URL. In production, you will have to point your domain to this folder. If you want you can do that changing nginx configuration, but I will leave this configuration for production only.</p>
                <p>If everything went well, you will see the basic template screen :</p>
                
                <div class='thumbnail'>
                    <img src="images/ss-welcome.png" class="img-responsive"/>
                </div>
                
                <p>Ok, that's it. We have our basic template installed and running.</p>
              
            </div>
        </div>

    </div>
</div>

<script language="javascript">
//    SyntaxHighlighter.all();
</script>
