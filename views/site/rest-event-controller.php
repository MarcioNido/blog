<?php

/* @var $this yii\web\View */

$this->title = 'REST Event Controller';
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
                
                <h2>REST Event Controller</h2>
                <p>The Event Controller can be created the same way we did the Category Controller:</p>
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
class EventController extends ActiveController 
{
    public $modelClass = 'app\modules\v1\models\Event';
}
                        
</code>
                </pre>

                <p>And add the rule to the Url Manager. The controller attribute of the rule can be changed to an array like this:</p>
                
                <pre>
                    <code>
'urlManager' => [
    'enablePrettyUrl' => true,
    'enableStrictParsing' => true,
    'showScriptName' => true,
    'rules' => [
        ['class' => 'yii\rest\UrlRule', 'controller' => ['v1/category','v1/event']],
    ],
],                        
</code>
                </pre>
                
                <p>Our event resource can already be accessed:</p>
                
                <pre>
                    <code>
curl -i -H "Accept:application/json" "http://api.dev/v1/events"
HTTP/1.1 200 OK
Server: nginx/1.4.6 (Ubuntu)
Date: Wed, 19 Oct 2016 14:53:33 GMT
Content-Type: application/json; charset=UTF-8
Transfer-Encoding: chunked
Connection: keep-alive
X-Powered-By: PHP/5.5.9-1ubuntu4.20
X-Pagination-Total-Count: 2
X-Pagination-Page-Count: 1
X-Pagination-Current-Page: 1
X-Pagination-Per-Page: 20
Link: &lt;http://api.dev/v1/events?page=1&gt;; rel=self

[{"event_id":1,"user_id":1,"category_id":1,"date":"2016-10-17","time":"18:00:00","description":"Test Application","active":1,"done":1},{"event_id":2,"user_id":1,"category_id":1,"date":"2016-10-18","time":"15:00:00","description":"Check reports","active":1,"done":0}]
</code>
                        
                </pre>
              
            </div>
        </div>

    </div>
</div>
