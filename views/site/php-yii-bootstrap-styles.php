<?php

/* @var $this yii\web\View */

$this->title = 'Yii2 Bootstrap';
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
                
                <h2>Bootstrap Default Styles Changes</h2>
                <p>It is possible to customize Bootstrap styles when you download it. But then you will have to save the configuration you made, so if you have to change something else, you can load this file and make other changes, then download again.</p>
                <p>Another way is to overwrite some of the styles creating a new css file in our project. That is the way I am doing here.</p>
                <p>So I created a css file called <code>basic.css</code> and placed it inside web/css folder of the application.</p>
                <p>To change the navbar, headings and labels default colors add these lines to basic.css file:</p>
                <pre>
                    <code class='css'>                        
h1,h2,h3,h4 { color: #286090; }
.jumbotron h1 { color: #286090; }
label { font-weight: normal; color: #286090; }

/* ### CHANGE NAVBAR COLORS ### */
.navbar-default { background-color: #286090; border-color: #204d74; }
/* title */
.navbar-default .navbar-brand { color: #E7E7E7; }
.navbar-default .navbar-brand:hover, .navbar-default .navbar-brand:focus { color: #FFFFFF; }
/* link */
.navbar-default .navbar-nav > li > a { color: #E7E7E7; }
.navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus { color: #FFFFFF; }
.navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active > a:hover, .navbar-default .navbar-nav > .active > a:focus { color: #FFFFFF; background-color: #286090; }
.navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .open > a:hover, .navbar-default .navbar-nav > .open > a:focus { color: #FFFFFF; background-color: #286090; }
/* caret */
.navbar-default .navbar-nav > .dropdown > a .caret { border-top-color: #E7E7E7; border-bottom-color: #E7E7E7; }
.navbar-default .navbar-nav > .dropdown > a:hover .caret, .navbar-default .navbar-nav > .dropdown > a:focus .caret { border-top-color: #204d74; border-bottom-color: #204d74; }
.navbar-default .navbar-nav > .open > a .caret, .navbar-default .navbar-nav > .open > a:hover .caret, .navbar-default .navbar-nav > .open > a:focus .caret { border-top-color: #FFFFFF; border-bottom-color: #FFFFFF; }
/* mobile version */
.navbar-default .navbar-toggle { border-color: #E7E7E7; }
.navbar-default .navbar-toggle:hover, .navbar-default .navbar-toggle:focus { background-color: #286090; }
.navbar-default .navbar-toggle .icon-bar { background-color: #E7E7E7; }
/* botão logout */
.navbar-default .btn-link { color: #E7E7E7; }
.navbar-default .btn-link:hover, .navbar-default .btn-link:focus { color: #FFFFFF; }

@media (max-width: 767px) { 
    .navbar-default .navbar-nav .open .dropdown-menu > li > a { color: #E7E7E7; }
    .navbar-default .navbar-nav .open .dropdown-menu > li > a:hover, .navbar-default .navbar-nav .open .dropdown-menu > li > a:focus { color: #FFFFFF; }
}
/* ### CHANGE NAVBAR COLORS END ### */              
                    </code>
                </pre>
                
                
                <p>Now, for our changes to take effect we have to load this css file. So add this file to the assets/AppAsset.php in the css section. It will be like this:</p>
                <pre>
                    <code class="php">
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/basic.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}                        
</code>
                </pre>
              
                <p>One more change to the layout main.php. I changed the navbar class. By default it comes with the class "navbar-inverse" and I changed to "navbar-default" which I have configured above. So, inside the views folder, layouts, edit main.php and change the navbar class like this:</p>
                <pre>
                    <code class="php">
    NavBar::begin([
        'brandLabel' => 'My Company',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-default navbar-fixed-top',
        ],
    ]);                        
</code>
                </pre>

                <p>Ok, now we should have a blue navbar, headings and labels like this:</p>
                <div class="thumbnail">
                    <img class="img-responsive" src="images/ss-bootstrap-styles.png" />
                </div>
                
                <br />&nbsp;
                <p>We can already make some changes to the main page for this project. Edit @app/views/site/index.php:</p>
                <pre>
                    <code class="php">
&lt;?php

/* @var $this yii\web\View */
use yii\helpers\Html;

$this->title = 'NIDO Basic Calendar';
?&gt;
&lt;div class="site-index"&gt;

    &lt;div class="jumbotron"&gt;
        &lt;h1&gt;Basic Calendar&lt;/h1&gt;

        &lt;p class="lead"&gt;This is a demo application. To see how it was done check the tutorial at: &lt;a href="http://marcionido.info/blog/web/index.php?r=site%2Fphp-yii&page=project"&gt;http://marcionido.info.&lt;/a&gt;&lt;/p&gt;
        &lt;br /&gt;
        &lt;br /&gt;
        &lt;p&gt;You can sign in using: ADMIN/ADMIN or DEMO/DEMO (uppercase).&lt;/p&gt;
        &lt;br /&gt;
        &lt;p&gt;&lt;?= Html::a("Open Calendar", ['calendar/event'], ['class'=&gt;'btn btn-lg btn-success']); ?&gt;&lt;/p&gt;
    &lt;/div&gt;

&lt;/div&gt;                        
                    </code>
                </pre>
                
                <p>And now we have a home page like this:</p>
                <div class="thumbnail">
                    <img class="img-responsive" src="images/ss-home.png" />
                </div>
                
            </div>
                
        </div>

    </div>
</div>

<script language="javascript">
//    SyntaxHighlighter.all();
</script>
