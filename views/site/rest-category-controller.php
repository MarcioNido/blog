<?php

/* @var $this yii\web\View */

$this->title = 'REST Category Controller';
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
                
                <h2>REST Category Controller</h2>
                <p>We will create now the CategoryController class. Unlike the controllers from the Yii Project Tutorial, this controller will extend yii\rest\ActiveController.</p>
                <p>So, let's create the CategoryController.php file inside the controllers folder of our v1 module:</p>
                <pre>
                    <code>
&lt;?php

namespace app\modules\v1\controllers;

use yii\rest\ActiveController;

/**
 * Category Controller
 *
 * @author Marcio Nido <marcionido@gmail.com>
 */
class CategoryController extends ActiveController 
{
    public $modelClass = 'app\modules\v1\models\Category';
}
                        
</code>
                </pre>

                <p>That's just it for now.</p>
              
            </div>
        </div>

    </div>
</div>
