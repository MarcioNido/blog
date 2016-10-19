<?php

/* @var $this yii\web\View */

$this->title = 'REST API Tests';
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
                
                <h2>REST Creating the API Tests</h2>
                <p>Well, now things got a little tricky. Yii2 documentation about tests is not fully complete yet, and there are differences between the basic and advanced templates.</p>
                <p>As in this project I used the basic template, I had to make some changes so I could use fixtures with the functional tests.</p>
                <p>So, to test the REST API we will use codeception functional tests. First, we will have to edit the file @app/tests/codeception/functional.suite.yml:</p>
                <pre>
                    <code>
# Codeception Test Suite Configuration

# suite for functional (integration) tests.
# emulate web requests and make application process them.
# (tip: better to use with frameworks).

# RUN `build` COMMAND AFTER ADDING/REMOVING MODULES.
#basic/web/index.php
class_name: FunctionalTester
modules:
    enabled:
      - Filesystem
      - Yii2
      - REST
      - tests\codeception\_support\FixtureHelper
    config:
        Yii2:
            configFile: 'codeception/config/functional.php'
            part: fixtures
        PhpBrowser: 
            url: 'http://api.dev'
        REST:
            url: 'http://api.dev/v1/'                        
</code>
                </pre>
                <p>I added to the modules enabled section 2 lines: REST and tests\codeception\_support\FixtureHelper. The first one will provide us with methods to test our API, like $I->sendGet, $I->sendPost, etc. The other line will enable the use of fixtures.</p>
                <p>The FixtureHelper class will redeclare some FixtureTrait class methods as public. So we will have to create it or grab it from the advanced template and make some adjustments to the namespaces: </p>
                <pre>
                    <code>
&lt;?php

namespace tests\codeception\_support;

use app\tests\codeception\fixtures\CategoryFixture;

use Codeception\Module;
use yii\test\FixtureTrait;
use yii\test\InitDbFixture;

/**
 * This helper is used to populate the database with needed fixtures before any tests are run.
 * In this example, the database is populated with the demo login user, which is used in acceptance
 * and functional tests.  All fixtures will be loaded before the suite is started and unloaded after it
 * completes.
 */
class FixtureHelper extends Module
{

    /**
     * Redeclare visibility because codeception includes all public methods that do not start with "_"
     * and are not excluded by module settings, in actor class.
     */
    use FixtureTrait {
        loadFixtures as public;
        fixtures as public;
        globalFixtures as public;
        createFixtures as public;
        unloadFixtures as protected;
        getFixtures as protected;
        getFixture as protected;
    }

    /**
     * Method called before any suite tests run. Loads User fixture login user
     * to use in acceptance and functional tests.
     * @param array $settings
     */
    public function _beforeSuite($settings = [])
    {
        $this-&gt;loadFixtures();
    }

    /**
     * Method is called after all suite tests run
     */
    public function _afterSuite()
    {
        $this-&gt;unloadFixtures();
    }

    /**
     * @inheritdoc
     */
    public function globalFixtures()
    {
        return [
            InitDbFixture::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function fixtures()
    {
        return [
            'category' =&gt; [
                'class' =&gt; CategoryFixture::className(),
                'dataFile' =&gt; '@tests/codeception/fixtures/data/cal_category.php',
            ],
        ];
    }
}
                        
</code>
                </pre>
                
                
                <p>After making the changes to the yml file and creating the FixtureHelper class, we have to run the build command from our application test folder:</p>
                <pre>
                    <code>
codecept build                        
</code>
                </pre>
                
                
                <p>Now, we create our CategoryFixture class:</p>
                <pre>
                    <code>
&lt;?php
namespace app\tests\codeception\fixtures;
use yii\test\ActiveFixture;
/**
 * Description of CategoryFixture
 *
 * @author Marcio Nido &lt;marcionido@gmail.com&gt;
 */
class CategoryFixture extends ActiveFixture {
    
    public $modelClass = 'app\modules\v1\models\Category';
    
}                       
</code>
                </pre>
                <p>And the category fixture data inside @app/tests/codeception/fixtures/data/cal_category.php:</p>
                <pre>
                    <code>
&lt;?php
/**
 * Fixture data for table cal_category
 */
return [
    [
        'name' => 'General',
        'active' => 1,
    ],
    [
        'name' => 'Test',
        'active' => 1,
    ],
];                        
</code>
                </pre>
                
                <p>Now let's create a new Cept file with codecept command:</p>
                <pre>
                    <code>
codecept generate:cept functional CategoryAPICept                        
</code>
                </pre>
                
                <p>Edit our new CategoryAPICept.php file that will be inside the functional tests folder and create a simple test to see if the test framework is working:</p>
                
                <pre>
                    <code>
&lt;?php 
$I = new FunctionalTester($scenario);
$I->wantTo('test the category API');
$I->sendGet('categories');
$I->seeResponseCodeIs(200);
$I->seeResponseContains('General');
$I->seeResponseContains('Test');
</code>
                </pre>
                
                <p>If you run this little test now you should see it working:</p>
                
                <div class='thumbnail'>
                    <img class='img-responsive' src='images/rest-test-one.png' />
                </div>

                <p>So, now we are ready to create all the API endpoints tests and make the changes necessary to se them pass.</p>
                
            </div>
            
        </div>

    </div>
</div>
