<?php

/* @var $this yii\web\View */

$this->title = 'REST Authentication';
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
                
                <h2>REST Authentication</h2>
                <p>For this project we will use Http Basic Auth authentication. So, first we configure the module to not use session and set the loginUrl property to null, that way if an unauthanticated user tries to access a resource he will receive a HTTP 403 Error instead of being redirected to the login page. In our Module class, @app/modules/v1/Module.php file: </p>
                <pre>
                    <code>
&lt;?php

namespace app\modules\v1;

/**
 * v1 module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\v1\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        \Yii::$app->user->enableSession = false;
        \Yii::$app->user->loginUrl = null;
    }
}                        
</code>
                </pre>
                
                <p>Now, we have to configure our controller to use the Http Basic Auth authentication. We do that overwriting the behaviors method of the controller class:</p>
                <pre>
                    <code>
&lt;?php

namespace app\modules\v1\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;

/**
 * Category Controller
 *
 * @author Marcio Nido <marcionido@gmail.com>
 */
class CategoryController extends ActiveController 
{
    public $modelClass = 'app\modules\v1\models\Category';
    
    public function behaviors() {
        
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class'=> HttpBasicAuth::className(),
        ];
        
        return $behaviors;
        
        
    }
    
}                        
</code>
                </pre>
                <p>Now, if we try to access again the categories resource we will receive an error:</p>
                <pre>
                    <code>
curl -i http://api.dev/v1/categories
HTTP/1.1 401 Unauthorized
Server: nginx/1.4.6 (Ubuntu)
Date: Wed, 19 Oct 2016 21:52:01 GMT
Content-Type: application/json; charset=UTF-8
Transfer-Encoding: chunked
Connection: keep-alive
X-Powered-By: PHP/5.5.9-1ubuntu4.20
Www-Authenticate: Basic realm="api"

{"name":"Unauthorized","message":"You are requesting with an invalid credential.","code":0,"status":401,"type":"yii\\web\\UnauthorizedHttpException"}                        
</code>
                </pre>
                
                <p>To access this resource now, we will have to provide an access token. This acess token is stored in the user table.</p>
                <p>For the client to have access to his token, we will create an user resource with an authenticate action to retrieve the token:</p>
                
                <pre>
                    <code>
&lt;?php

namespace app\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use app\models\User;

/**
 * User Controller
 * API Authentication 
 *
 * @author Marcio Nido <marcionido@gmail.com>
 */
class UserController extends ActiveController 
{
    public $modelClass = 'app\modules\v1\models\User';

    public function actionAuthenticate() 
    {
        
        $post = Yii::$app->request->post();
        if (! isset($post['username']) || ! isset($post['password'])) {
            throw new \yii\web\ForbiddenHttpException();
        }
        
        $user = User::findOne(['username'=>$post['username']]);
        if ($user == null) {
            throw new \yii\web\ForbiddenHttpException();
        }
        
        if (! $user->validatePassword($post['password'])) {
            throw new \yii\web\ForbiddenHttpException();
        }
        
        return base64_encode($user->access_token.':');
        
    }
    
    
}                        
</code>
                </pre>
                
                <p>And we need to create this rule in the UrlManager configuration:</p>
                <pre>
                    <code>
'urlManager' => [
    'enablePrettyUrl' => true,
    'enableStrictParsing' => true,
    'showScriptName' => false,
    'rules' => [
        ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/user', 'extraPatterns' => ['POST authenticate' => 'authenticate']],
        ['class' => 'yii\rest\UrlRule', 'controller' => ['v1/category', 'v1/event']],
    ],
],                        
</code>
                </pre>
                <p>Now the client can authenticate to the API and retrieve his token:</p>
                
                <code>
                    <pre>
curl -X POST --data "username=ADMIN&password=ADMIN" http://api.dev/v1/users/authenticate
"OUNFUUQ5aDUxREFTVGphMTBYMXpDYUdEQ1B5cDlMbnY6"                        
                    </pre>
                </code>
                <p>And use the token to use the other resources:</p>
                <pre>
                    <code>
curl -i -H "Authorization: Basic OUNFUUQ5aDUxREFTVGphMTBYMXpDYUdEQ1B5cDlMbnY6" "http://api.dev/v1/categories"
HTTP/1.1 200 OK
Server: nginx/1.4.6 (Ubuntu)
Date: Wed, 19 Oct 2016 22:13:33 GMT
Content-Type: application/json; charset=UTF-8
Transfer-Encoding: chunked
Connection: keep-alive
X-Powered-By: PHP/5.5.9-1ubuntu4.20
X-Pagination-Total-Count: 2
X-Pagination-Page-Count: 1
X-Pagination-Current-Page: 1
X-Pagination-Per-Page: 20
Link: <http://api.dev/v1/categories?page=1>; rel=self

[{"category_id":1,"name":"General","active":1},{"category_id":2,"name":"Test","active":1}]                        
</code>
                </pre>
                
                
                <p>The same change on the behavior method must be done in the events resource. We could create the API default controller class with this behavior and extend all our controllers from this class, so we don't need to do it in every class. But as this is a small example test I will do that in the EventController class.</p>
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
    
    public function behaviors() {
        
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class'=> HttpBasicAuth::className(),
        ];
        
        return $behaviors;
        
        
    }    
}
                        
</code>
                </pre>
                
                <p>Ok, now our API tests are failing because of the authentication. So, we will have to change the tests and add the authentication information.</p>
                <p>For that we will need to create the UserFixture class and data:</p>
                <pre>
                    <code>
&lt;?php
namespace app\tests\codeception\fixtures;
use yii\test\ActiveFixture;
/**
 * UserFixture class
 *
 * @author Marcio
 */
class UserFixture extends ActiveFixture {
    
    public $modelClass = 'app\models\User';
    
}
                        
</code>
                </pre>
                
                <pre>
                    <code>
&lt;?php
/**
 * Fixture data for user table 
 */
return [
    'ADMIN' => [
        'name'          =>'ADMIN',
        'username'      =>'ADMIN',
        'password'      =>Yii::$app->getSecurity()->generatePasswordHash('ADMIN'),
        'active'        =>1,
        'access_token'  =>Yii::$app->getSecurity()->generateRandomString(),
        'auth_key'      =>Yii::$app->getSecurity()->generateRandomString(),
    ],
    'DEMO' => [
        'name'          =>'DEMO',
        'username'      =>'DEMO',
        'password'      =>Yii::$app->getSecurity()->generatePasswordHash('DEMO'),
        'active'        =>1,
        'access_token'  =>Yii::$app->getSecurity()->generateRandomString(),
        'auth_key'      =>Yii::$app->getSecurity()->generateRandomString(),
    ],
    'BUDDY' => [
        'name'          =>'BUDDY',
        'username'      =>'BUDDY',
        'password'      =>Yii::$app->getSecurity()->generatePasswordHash('BUDDY'),
        'active'        =>1,
        'access_token'  =>Yii::$app->getSecurity()->generateRandomString(),
        'auth_key'      =>Yii::$app->getSecurity()->generateRandomString(),
    ],
    
    
];                        
</code>
                        
                        
                </pre>
                
                <p>Note that I named the rows in the user data file so I can retrieve the data I want.</p>
                <p>And now the changes to our test class CategoryAPICept.php:</p>
                <pre>
                    <code>
&lt;?php 
$I = new FunctionalTester($scenario);
$I->wantTo('test the category API');

// get the ADMIN token
$fixtures = $I->getFixtures();
$userFixtures = $fixtures['user'];
$adminToken = $userFixtures['ADMIN']['access_token'];

$I->amHttpAuthenticated($adminToken, '');
$I->sendGet('categories');
$I->seeResponseCodeIs(200);
$I->seeResponseContains('General');
$I->seeResponseContains('Test');
                        
</code>
                </pre>
                
                <p>That's it. Our test is passing again. Now we can create the tests for all other API endpoints, and implement the methods to see them pass.</p>
                
            </div>
            
        </div>

    </div>
    
</div>
