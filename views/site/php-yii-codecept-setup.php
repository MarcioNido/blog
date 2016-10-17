<?php

/* @var $this yii\web\View */

$this->title = 'Yii2 Codeception Configuration';
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
                
                <h2>Yii2 Codeception Configuration</h2>
                <p>Yii2 uses Codeception for tests. If you followed the environment setup section, codeception is already installed and ready to use. If not, follow the instructions from the Yii2 Guide page : <a target="_blank" href='http://www.yiiframework.com/doc-2.0/guide-test-environment-setup.html'>Testing environment setup</a>.</p>
                <p>Ok, now before start testing, we have to change some configurations.</p>
                <p>First, go to tests folder inside your project and edit the file codeception.yml. Here we have to change the last line, the test_entry_url like this:</p>
                <pre>
                    <code class='bash hljs'>
test_entry_url: http://apps.dev/basic-calendar/web/index-test.php                   
                    </code>
                </pre>
                
                <p>Now, edit the file inside codeception folder called acceptange.suite.yml, and change the url parameter of the PhpBrowser section like this: </p>
                <pre>
                    <code class='bash hljs'>
url: http://apps.dev
                    </code>
                </pre>
                <p>Note that I am using http://apps.dev because I created this domain. If you created the domain with another name, use the name you created instead.</p>
                
                <p>Now, one more thing I had to do. The entry script for the tests is index-test.php, but it has a security in it to avoid someone execute this script if it is in a production environment. It checks the IP. In my case I had to change it to the virtual server IP, that was 192.168.83.137. For this, edit the file basic-calendar/web/index-test.php and add your server IP:</p>
                <pre>
                    <code class='php'>
// NOTE: Make sure this file is not accessible when deployed to production
if (!in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1', '192.168.83.137'])) {
    die('You are not allowed to access this file from IP .'.$_SERVER['REMOTE_ADDR']);
}

                    </code>
                </pre>
                

                <p>Ok, now we are able to run the tests the already come with the basic template. Just go to the tests folder and run the command :</p>                
                <pre>
                    <code class='bash hljs'>
codecept run
                    </code>
                </pre>
                
                <p>If everything went right we will see a result like this:</p>
               
                <div class='thumbnail'>
                    <img src="images/ss-first-test.png" class="img-responsive"/>
                </div>
                
                <p>Now we are ready to start coding and testing.</p>
              
            </div>
        </div>

    </div>
</div>

<script language="javascript">
//    SyntaxHighlighter.all();
</script>
