<?php

/* @var $this yii\web\View */

$this->title = 'REST Creating Module';
use yii\helpers\Html;

$this->params['breadcrumbs'][] = ['label' => 'REST Project', 'url' => array('site/rest')];
$this->params['breadcrumbs'][] = $this->title;
?>

<link rel="stylesheet" href="js/styles/googlecode.css">
<script src="js/highlight.pack.js"></script>
<script>hljs.initHighlightingOnLoad();</script>

        
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-lg-12">
                
                <h2>REST Creating the Module</h2>
                <p>When building an API, you have to be careful with changes. Changing a RESTFul API is not like changing a Web Application. If you are going to make some change that is not compatible with the previous version, you will probably have to keep the older version running, at least for some time.</p>
                <p>The way to do that with Yii2 is with modules. So we will create a module called v1 and put our API inside it. If needed we can create the v2 module and have a new major version of the API.</p>
                <p>For that we use Gii. Remember to configure gii in your @app/config/web.php file:</p>
                <pre>
                    <code>
$config['bootstrap'][] = 'gii';
$config['modules']['gii'] = [
    'class' => 'yii\gii\Module',
    'allowedIPs' => ['192.168.83.*'],  // This is your client machine IP      
];                        
</code>
                </pre>
                
                <p>Ok, now we can open Gii in our browser at http://apps.dev/rest-api/web/index.php?r=gii</p>
                <div class='thumbnail'>
                    <img class='img-responsive' src='images/rest-module-gii.png' />
                </div>
                
                <p>And add the module to the @app/config/web.php file:</p>
                
                <pre>
                    <code>
'modules' => [
    'v1' => [
        'class' => 'app\modules\v1\Module',
    ],
],                         
</code>
                </pre>
                
                
                <p>Our v1 module is created.</p>
              
            </div>
        </div>

    </div>
</div>
