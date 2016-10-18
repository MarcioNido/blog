<?php

/* @var $this yii\web\View */

$this->title = 'Category';
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
                
                <h2>Creating the Category table, model, crud and tests</h2>
                <p>Our calendar's events will have a category, so let's create the category table and all the funcionality necessary.</p>
                <p>First, we use the migration tool to create the new table. We will create a table called cal_category. And insert the General category in it. Go to the application folder and run:</p>
                <pre>
                    <code class='bash'>
php yii migrate/create create_category_table                        
</code>
                </pre>
                <p>Now edit the file and add the fields we need:</p>
                <pre>
                    <code class='php'>
&lt;?php

use yii\db\Migration;

/**
 * Handles the creation for table `category`.
 */
class m161017_225813_create_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('cal_category', [
            'category_id' => $this->primaryKey(),
            'name' => $this->string(30)->notNull(),
            'active' => $this->integer(1)->defaultValue(1),
        ]);
        
        // insert a general category ... 
        $this->insert('cal_category', [
            'name' => 'General',
        ]);
        
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('cal_category');
    }
    
}
                        
</code>
                </pre>
                
                <p>Run the migration tool to create the table in the development and test database:</p>
                <pre>
                    <code class='bash'>
php yii migrate
php tests/codeception/bin/yii migrate
</code>
                </pre>
                
                <p>Now we generate the model using Gii:</p>
                <div class='thumbnail'>
                    <img class='img-responsive' src='images/ss-category-gii-model.png' />
                </div>
                
                <p>Notice that I changed the Model Class to Category and not CalCategory like Gii suggests. And the namespace must be changed so the class can be created inside the module.</p>
                
                <p>Now we generate the CRUD for the category model:</p>
                <div class='thumbnail'>
                    <img class='img-responsive' src='images/ss-category-gii-crud.png' />
                </div>
                
                <p>And that's it. We can already access the categories using the route "calendar/category":</p>
                <div class="thumbnail">
                    <img class="img-responsive" src="images/ss-category-screen.png" />
                </div>
                
                <p>Now we create the unit tests for the category model. I created a folder inside the unit tests folder called calendarUnit to keep them separated. Then create the fixture class in the folder @app/tests/codeception/unit/calendarUnit/fixtures:</p>
                <pre>
                    <code class="php">
&lt;?php
namespace app\tests\codeception\unit\calendarUnit\fixtures;
use yii\test\ActiveFixture;
/**
 * Description of CategoryFixture
 *
 * @author Marcio
 */
class CategoryFixture extends ActiveFixture {
    
    public $modelClass = 'app\modules\calendar\models\Category';
    
}                        
</code>
                </pre>
                <p>The fixture data inside the folder @app/tests/codeception/unit/calendarUnit/fixtures/data:</p>
                
                <pre><code class="php">
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
                </code></pre>
                
                <p>And the test class CategoryTest inside @app/tests/codeception/unit/calendarUnit/models:</p>
                <pre>
<code class="php">
&lt;?php

namespace tests\codeception\unit\calendarUnit\models;

use Yii;
use yii\codeception\DbTestCase;
use app\tests\codeception\unit\calendarUnit\fixtures\CategoryFixture;
use app\tests\codeception\unit\calendarUnit\fixtures\EventFixture;
use app\modules\calendar\models\Category;
use app\modules\calendar\models\Event;

use Codeception\Specify;

/**
 * Test Class for model \app\modules\calendar\models\Category
 * @author Marcio Nido <marcionido@gmail.com>
 */
class CategoryTest extends DbTestCase
{
    use \Codeception\Specify;
    
    /**
     * Load fixtures for the tests
     * @return array fixtures to be loaded
     */
    public function fixtures() 
    {
        return [
            'categories' => CategoryFixture::className(),
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
    
    
    public function testFixturesAreLoaded() { 
        $this->specify('Fixture data should be loaded', function() {
            expect('Category 1 is loaded', Category::findOne(1))->notNull();
        });
    }
    
    /**
     * Tests model validation 
     */
    public function testCategoryValidators() 
    {

        $this->specify('Category model should not accept empty required fields', function () {
            $model = new Category();
            $model->validate();
            expect('name is required', $model->errors)->hasKey('name');
            expect('no more fields required', count($model->errors))->equals(1);
        });
        
        $this->specify('String fields too long', function () {
            $model = new Category();
            $model->name = str_repeat('A', 31);
            expect('name too long', $model->validate(['name']))->false();
       });
        
    }
    
    /**
     * Tests CRUD
     */
    public function testCategoryCrud() 
    {
        $this->specify('Create New Category', function () {
            $model = new Category();
            $model->name = 'New Category';
            expect('Saves successfuly', $model->save())->true();
            expect('Record is in database', $model->findOne(['name'=>'New Category']))->notNull();
        });
        
        $this->specify('Update Category Data', function() { 
            $model = Category::findOne(['name'=>'New Category']);
            $model->name = 'Old Category';
            expect('Saves successfuly', $model->save())->true();
            expect('Updated Record is in database', $model->findOne(['name'=>'Old Category']))->notNull();
        });
        
        $this->specify('Delete Category', function() {
            $model = Category::findOne(['name'=>'Old Category']);
            expect('Deletes record', $model->delete())->equals(1);
            expect('Record no longer exists', $model->findOne(['name'=>'Old Category']))->null();
        });
               
    }
    
}
                        
</code>
                </pre>
                
                <p>Ok, run the tests to see if there is something wrong and that's it.</p>

            </div>
            
        </div>

    </div>
    
</div>