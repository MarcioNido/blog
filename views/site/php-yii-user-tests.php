<?php

/* @var $this yii\web\View */

$this->title = 'User Model and Authentication Tests';
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
                
                <h2>User Model and Authentication Tests</h2>
                <p>With the changes made to the user model class, some of our tests are failing now. So we have to make some changes to the test classes so it can run successfuly again.</p>
                <p>In the unit tests, the LoginForm::testLoginCorrect if failing. To correct it edit the file @app/tests/codeception/unit/models/LoginFormTest.php. The only problem here is the username and password. In our database we created the users ADMIN/ADMIN and DEMO/DEMO, all uppercase, and the test is trying to authenticate demo/demo lowercase. Just change to DEMO/DEMO uppercase and run the tests again.</p>
                <p>The same thing must be done to the functional and acceptance test. Edit the files @app/tests/codeception/functional/LoginCept.php and @app/tests/codeception/acceptance/LoginCept.php. In both files, change all lowercase admin to uppercase ADMIN.</p>
                <p>Run the tests again. All tests are successful again.</p>
                <p>Now, we have to create the tests for the user model. The tests above are only testing the authentication. We need to test the CRUD functionality and validation.</p>
                <p>For this kind of test we will create a fixture. For this, create a UserFixture class inside @app/tests/codeception/fixtures like this:</p>
                <pre>
                    <code class="php">
&lt;?php
namespace app\tests\codeception\fixtures;
use yii\test\ActiveFixture;

/**
 * UserFixture
 * @author Marcio Nido <marcionido@gmail.com>
 */
class UserFixture extends ActiveFixture {
    
    public $modelClass = 'app\models\user';
    
}
                        
                    </code>
                </pre>
                <p>And create the fixture data file inside the data folder @app/tests/codeception/fixtures/data with the table name, so user.php:</p>
                <pre>
<code class="php">
&lt;?php
/**
 * Fixture data for user table 
 */
return [
    [
        'name'          =>'ADMIN',
        'username'      =>'ADMIN',
        'password'      =>Yii::$app->getSecurity()->generatePasswordHash('ADMIN'),
        'active'        =>1,
        'access_token'  =>null,
        'auth_key'      =>'9CEQD9h51DASTja10X1zCaGDCPyp9Lnv',
    ],
    [
        'name'          =>'DEMO',
        'username'      =>'DEMO',
        'password'      =>Yii::$app->getSecurity()->generatePasswordHash('DEMO'),
        'active'        =>1,
        'access_token'  =>null,
        'auth_key'      =>'qN38K8lRV7nVmrJPhkcVpUmsceLqoeKN',
    ],
    [
        'name'          =>'BUDDY',
        'username'      =>'BUDDY',
        'password'      =>Yii::$app->getSecurity()->generatePasswordHash('BUDDY'),
        'active'        =>1,
        'access_token'  =>null,
        'auth_key'      =>'asldkfJkdlIjflaOosdjoaiOIljkdaKN',
    ],
    
    
];                        
</code>
                </pre>
                
                <p>And create the UserTest class inside @app/tests/codeception/unit:</p>
                <pre>
                    <code class="php">
&lt;?php

namespace tests\codeception\unit\models;

use Yii;
use yii\codeception\DbTestCase;
use app\tests\codeception\fixtures\UserFixture;
use app\models\User;

use Codeception\Specify;

/**
 * Test Class for model \app\models\User
 * @author Marcio Nido <marcionido@gmail.com>
 */
class UserTest extends DbTestCase
{
    use \Codeception\Specify;
    
    /**
     * Load fixtures for the tests
     * @return array fixtures to be loaded
     */
    public function fixtures() 
    {
        return [
            'users' => UserFixture::className(),
        ];
    }
    
    /**
     * Executes before tests
     */
    protected function setUp()
    {
        // nothing else to do for this test
        parent::setUp();
    }
    
    /**
     * Tests user model validation 
     */
    public function testValidators() 
    {

        $this->specify('Fixtures should be loaded', function() {
           expect('User BUDDY is in the table', User::findOne(['name'=>'BUDDY']))->notNull(); 
        });
        
        $this->specify('User model should not accept empty required fields', function () {
            $model = new User();
            $model->validate();
            expect('name is required', $model->errors)->hasKey('name');
            expect('username is required', $model->errors)->hasKey('username');
            expect('password is required', $model->errors)->hasKey('password');
            expect('no more fields required', count($model->errors))->equals(3);
        });
        
        $this->specify('validate fields too long', function () {
            $model = new User();
            $model->name = str_repeat('A', 51);
            $model->username = str_repeat('A', 31);
            $model->password = str_repeat('A', 101);
            $model->access_token = str_repeat('A', 101);
            $model->auth_key = str_repeat('A', 101);
            expect('name too long', $model->validate(['name']))->false();
            expect('username too long', $model->validate(['username']))->false();
            expect('password too long', $model->validate(['password']))->false();
            expect('access_token too long', $model->validate(['access_token']))->false();
            expect('auth_key too long', $model->validate(['auth_key']))->false();
        });

        $this->specify('validate username cannot be duplicated', function() {
            $model = new User();
            $model->username = 'ADMIN';
            expect('username is duplicated', $model->validate(['username']))->false();
        });
        
    }
    
    /**
     * Tests Create, Update and Delete for the user model
     */
    public function testCrudUser() 
    {
        $this->specify('Create New User', function () {
            $model = new User();
            $model->name = 'John Doe';
            $model->username = 'JohnDoe';
            $model->password = Yii::$app->getSecurity()->generatePasswordHash('123456');
            $model->active = 1;
            expect('Saves successfuly', $model->save())->true();
            expect('Record is in database', $model->findOne(['username'=>'JohnDoe']))->notNull();
        });
        
        $this->specify('Update User Data', function() { 
            $model = User::findOne(['username'=>'JohnDoe']);
            $model->name = 'Jane Doe';
            expect('Saves successfuly', $model->save())->true();
            expect('Updated Record is in database', $model->findOne(['name'=>'Jane Doe']))->notNull();
        });
        
        $this->specify('Delete User', function() {
            $model = User::findOne(['username'=>'JohnDoe']);
            expect('Deletes record', $model->delete())->equals(1);
            expect('Record no longer exists', $model->findOne(['username'=>'JohnDoe']))->null();
        });
        
    }
    
}
                        
</code>
                </pre>
                

            </div>
            
        </div>

    </div>
    
</div>

