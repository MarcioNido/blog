<?php

/* @var $this yii\web\View */

$this->title = 'Events';
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
                
                <h2>Creating the Events table, model, crud and tests</h2>
                <p>The same process used to create the categories functionality is used to create the events.</p>
                <p>Create the migration. Go to the application folder and run:</p>
                <pre>
                    <code class='bash'>
php yii migrate/create create_event_table                        
</code>
                </pre>
                <p>Edit the file and add the fields we need:</p>
                <pre>
                    <code class='php'>
&lt;?php

use yii\db\Migration;

/**
 * Handles the creation for table `event`.
 */
class m161018_010248_create_event_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('cal_event', [
            'event_id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'date'=>$this->date()->notNull(),
            'time'=>$this->time()->notNull(),
            'description'=>$this->string(500)->notNull(),
            'active' => $this->integer(1)->defaultValue(1),
            'done' => $this->integer(1)->defaultValue(0),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            'idx-cal_event-user_id',
            'cal_event',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-cal_event-user_id',
            'cal_event',
            'user_id',
            'user',
            'user_id',
            'CASCADE'
        );

        // creates index for column `category_id`
        $this->createIndex(
            'idx-cal_event-category_id',
            'cal_event',
            'category_id'
        );

        // add foreign key for table `cal_category`
        $this->addForeignKey(
            'fk-cal_event-category_id',
            'cal_event',
            'category_id',
            'cal_category',
            'category_id',
            'CASCADE'
        );
        
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-cal_event-user_id',
            'cal_event'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-cal_event-user_id',
            'cal_event'
        );

        // drops foreign key for table `cal_category`
        $this->dropForeignKey(
            'fk-cal_event-category_id',
            'cal_event'
        );

        // drops index for column `category_id`
        $this->dropIndex(
            'idx-cal_event-category_id',
            'cal_event'
        );

        $this->dropTable('cal_event');
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
                
                <p>Generate the model and the CRUD using Gii the same way we did with categories.</p>

                <p>Now, as the events will be our main view and the users will have access, not only administrators, then I will make some changes to make it more easy to use and a better visualization.</p>
                
                <p>First thing, as we are going to use the DatePicker, we need to install the JUI extension for Yii2. For that, use composer. From the application folder:</p>
                <pre>
                    <code class='bash'>
composer require --prefer-dist yiisoft/yii2-jui                        
                    </code>
                </pre>

                <p>Another feature we will use is a dropdown for the categories. For that we will need a method in the Category class to get an array of the active categories. So, add this method to the Category class:</p>
                <pre>
                    <code>
    /**
     * Used in dropdownlists 
     * @return array list of active records
     */
    public static function getDropDownList()
    {
        $array = static::find()->asArray()->where(['active' => 1])->orderBy('name')->all();
        return \yii\helpers\ArrayHelper::map($array, 'category_id', 'name');
    }
                        
</code>
                </pre>
                
                <p>For the index view of the events I removed the GridView and made it manually, only keeping the pagination. Also created a hidden filter that slides down. Here's the code:</p>
                <pre>
                    <code>
&lt;?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Calendar';
$this->params['breadcrumbs'][] = $this->title;
$models = $dataProvider->getModels();

// checks if there is some active filter to change the color of the filter button
$filtered = false;
if (isset($_GET['Filter'])) { 
    foreach($_GET['Filter'] as $value) {
        if ($value !== '') {
            $filtered = true;
        }
    }
}

?&gt;
&lt;div class="event-index"&gt;

    &lt;div class="row"&gt;
        &lt;div class="col-md-8" style="min-height: 39px;"&gt;
                &lt;?= Html::a("&lt;span class='glyphicon glyphicon-plus'&gt;&lt;/span&gt; Create Event", ['create'], ['class' =&gt; 'btn btn-success']) ?&gt;
                &lt;?= Html::a("&lt;span class='glyphicon glyphicon-filter'&gt;&lt;/span&gt; Filter", null, ['class' =&gt; $filtered ? 'btn btn-danger' : 'btn btn-primary', 'onclick'=&gt;"$('#ph_filter').toggle('fast');", 'id'=&gt;'btn-filter']) ?&gt;
                &lt;?= Html::a("&lt;span class='glyphicon glyphicon-list'&gt;&lt;/span&gt; Categories", ['//calendar/category'], ['class' =&gt; 'btn btn-primary']) ?&gt;
        &lt;/div&gt;
        &lt;div class="col-md-4 hidden-xs" style="text-align: right;"&gt;
            &lt;?= \yii\widgets\LinkPager::widget([
                'pagination'=&gt;$dataProvider-&gt;pagination,
                'options'=&gt;[
                    'style' =&gt; 'margin-top: 0; margin-bottom: 0;',
                    'class' =&gt; 'pagination',
                    ],
            ]); ?&gt;
        &lt;/div&gt;
        
    &lt;/div&gt;   
    
    &lt;div class="row" id="ph_filter" style="display: none;"&gt;
        &lt;div class="col-md-12"&gt;
            &lt;div class="panel panel-success"&gt;
                
                    &lt;div class="panel-heading"&gt;
                        &lt;b&gt;Filters&lt;/b&gt;
                    &lt;/div&gt;
                    &lt;div class="panel-body"&gt;
                        
                    &lt;?= Html::beginForm('', 'GET', array('id'=&gt;'filter_form', 'autocomplete'=&gt;'off')); ?&gt;

                        &lt;div class="row"&gt;
                            &lt;div class="col-md-3"&gt;
                                &lt;div class="form-group"&gt;
                                    &lt;label&gt;Date&lt;/label&gt;
                                    &lt;?=
                                    \yii\jui\DatePicker::widget([
                                    'name'  =&gt; 'Filter[date]',
                                    'value'  =&gt; $_GET['Filter']['date'],
                                    'options' =&gt; ['class'=&gt;'form-control'],
                                    //'language' =&gt; 'ru',
                                    'dateFormat' =&gt; 'yyyy-MM-dd',
                                    ]);
                                    ?&gt;
                                    &lt;?php //Html::textInput('Filter[date]', $_GET['Filter']['date'], array('class'=&gt;'form-control')); ?&gt;
                                &lt;/div&gt;
                            &lt;/div&gt;
                            &lt;div class="col-md-9"&gt;
                                &lt;div class="form-group"&gt;
                                    &lt;label&gt;Description&lt;/label&gt;
                                    &lt;?= Html::textInput('Filter[description]', $_GET['Filter']['description'], array('class'=&gt;'form-control')); ?&gt;
                                &lt;/div&gt;
                            &lt;/div&gt;
                        &lt;/div&gt;
                        
                        &lt;div class="row"&gt;
                            &lt;div class="col-md-12" style="text-align: right;"&gt;
                                &lt;?= Html::submitButton('Apply Filter', ['class'=&gt;'btn btn-success']); ?&gt;
                                &lt;?= Html::button('Clear Filters', ['class'=&gt;'btn btn-danger', 'onclick'=&gt;"$('.form-control').val(''); $('#filter_form').submit();"]); ?&gt;
                            &lt;/div&gt;
                        &lt;/div&gt;
                        
                    &lt;?= Html::endForm(); ?&gt;
                        
                    &lt;/div&gt;
                
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
             
    &lt;div class="row"&gt;
        &lt;div class="col-md-12"&gt;
            
    &lt;?php  
    $models = $dataProvider-&gt;getModels();
    if ($models != null) {
        $date = "";
        foreach($models as $model) {
            
            if ($date != $model-&gt;date) {
                
                // closes the panel of this day
                if ($date != "") {
                    echo '&lt;/div&gt;&lt;/div&gt;';
                }
                
                // open a new day panel 
                ?&gt;
                &lt;div class="panel panel-info"&gt;
                    &lt;div class="panel-heading"&gt;
                        &lt;b&gt;&lt;?= $model-&gt;date_short; ?&gt;&lt;/b&gt;
                    &lt;/div&gt;
                    &lt;div class="panel-body" style="padding: 0 15px;"&gt;
                        
    
                &lt;?php 
                $date = $model-&gt;date;
            }
       
            ?&gt;
                &lt;div class="row dt-body mn-hover-line"&gt;
                    &lt;div class="col-md-1"&gt;
                        &lt;h5&gt;&lt;?= substr($model-&gt;time, 0, 5); ?&gt;&lt;/h5&gt;
                    &lt;/div&gt;
                    
                    &lt;div class="col-md-9"&gt;
                        &lt;h5&gt;&lt;?= Html::encode($model-&gt;description); ?&gt;&lt;/h5&gt;
                    &lt;/div&gt;
                    
                    &lt;div class="col-md-2" style="text-align: right;"&gt;
                        &lt;?= Html::a("&lt;span class='glyphicon glyphicon-check'&gt;&lt;/span&gt;", ['mark-done', 'id' =&gt; $model-&gt;event_id], ['class' =&gt; 'btn btn-success btn-sm', 'title' =&gt; 'Mark as Done', 'onclick' =&gt; 'return window.confirm("Mark this event as done ?")']) ?&gt;
                        &lt;?= Html::a("&lt;span class='glyphicon glyphicon-pencil'&gt;&lt;/span&gt;", ['update', 'id' =&gt; $model-&gt;event_id], ['class' =&gt; 'btn btn-primary btn-sm', 'title' =&gt; 'Edit Event']) ?&gt;
                        &lt;?= Html::a("&lt;span class='glyphicon glyphicon-trash'&gt;&lt;/span&gt;", ['delete', 'id' =&gt; $model-&gt;event_id], ['class' =&gt; 'btn btn-danger btn-sm', 'title' =&gt; 'Delete Event', 'onclick'=&gt;'return window.confirm("Are you sure you want to delete this event ?")']) ?&gt;
                    &lt;/div&gt;
                &lt;/div&gt;
            &lt;?php 
            
        }
    }
    ?&gt;
                    &lt;/div&gt;
                &lt;/div&gt;
            
        &lt;/div&gt;
    &lt;/div&gt;
    
    &lt;div class="row"&gt;
        &lt;div class="col-md-12" style="text-align: right;"&gt;
            &lt;?= \yii\widgets\LinkPager::widget([
                'pagination'=&gt;$dataProvider-&gt;pagination,
            ]); ?&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    
&lt;/div&gt;
                        
</code>
                </pre>
                
                <p>Add the css styles of the new grid:</p>
                <pre>
                    <code>
.dt-header { background-color: #286090; color: #e7e7e7;}
.dt-body { padding-top: 8px; padding-bottom: 8px; color: #286090; border-top: 1px solid #ccc; }
.mn-hover-line:hover { background-color: #F2F2F2; }                        
</code>
                </pre>
                
                <p>Ok, that's it. It's a basic Yii2 calendar application. In the next tutorial we will add the RBAC (role based access control) to it. Also, an audit log to register all the actions to the calendar.</p>
                <p>Click below to see the result:</p>
                <p><?= Html::a('Run Project', '/basic-calendar/web/index.php', ['class' => 'btn btn-success']) ?></p>
                
                
            </div>
            
            
            
        </div>

    </div>
    
</div>