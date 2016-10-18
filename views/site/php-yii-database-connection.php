<?php

/* @var $this yii\web\View */

$this->title = 'Yii2 Database Connection';
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
                
                <h2>Database Connection</h2>
                <p>In this project we will use the Yii2 migration tools to create our tables, so it will be totally independent of the database engine. So, you can choose the database engine you want to use.</p>
                <p>What we have to do is create our database in our preffered database engine and configure the db and test db connections. </p>
                <p>I am using MySQL for this project, and created two databases, basic_calendar and basic_calendar_test and the configurations file will be like this:</p>
                <p>First, at the @app/config/db.php:</p>
                <pre>
<code class='php'>
&lt;?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=apps.dev;dbname=basic_calendar',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
];
   
                        
</code>
                </pre>
                
                <p>And then the test database connection in file @app/tests/codeception/config/config.php:</p>
                <pre>
<code class='php'>
&lt;?php
/**
 * Application configuration shared by all test types
 */
return [
    'language' => 'en-US',
    'controllerMap' => [
        'fixture' => [
            'class' => 'yii\faker\FixtureController',
            'fixtureDataPath' => '@tests/codeception/fixtures',
            'templatePath' => '@tests/codeception/templates',
            'namespace' => 'tests\codeception\fixtures',
        ],
    ],
    'components' => [
        'db' => [
            'dsn' => 'mysql:host=apps.dev;dbname=basic_calendar_test',
        ],
        'mailer' => [
            'useFileTransport' => true,
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
    ],
];
                       
</code>
                </pre>                
                
                
            </div>
                
        </div>

    </div>
</div>

<script language="javascript">
//    SyntaxHighlighter.all();
</script>
