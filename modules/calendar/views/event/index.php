<?php

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

?>
<div class="event-index">

    <div class="row">
        <div class="col-md-8" style="min-height: 39px;">
                <?= Html::a("<span class='glyphicon glyphicon-plus'></span> Create Event", ['create'], ['class' => 'btn btn-success']) ?>
                <?= Html::a("<span class='glyphicon glyphicon-filter'></span> Filter", null, ['class' => $filtered ? 'btn btn-danger' : 'btn btn-primary', 'onclick'=>"$('#ph_filter').toggle('fast');", 'id'=>'btn-filter']) ?>
                <?= Html::a("<span class='glyphicon glyphicon-list'></span> Categories", ['//calendar/category'], ['class' => 'btn btn-primary']) ?>
        </div>
        <div class="col-md-4 hidden-xs" style="text-align: right;">
            <?= \yii\widgets\LinkPager::widget([
                'pagination'=>$dataProvider->pagination,
                'options'=>[
                    'style' => 'margin-top: 0; margin-bottom: 0;',
                    'class' => 'pagination',
                    ],
            ]); ?>
        </div>
        
    </div>   
    
    <div class="row" id="ph_filter" style="display: none;">
        <div class="col-md-12">
            <div class="panel panel-success">
                
                    <div class="panel-heading">
                        <b>Filters</b>
                    </div>
                    <div class="panel-body">
                        
                    <?= Html::beginForm('', 'GET', array('id'=>'filter_form', 'autocomplete'=>'off')); ?>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Date</label>
                                    <?=
                                    \yii\jui\DatePicker::widget([
                                    'name'  => 'Filter[date]',
                                    'value'  => $_GET['Filter']['date'],
                                    'options' => ['class'=>'form-control'],
                                    //'language' => 'ru',
                                    'dateFormat' => 'yyyy-MM-dd',
                                    ]);
                                    ?>
                                    <?php //Html::textInput('Filter[date]', $_GET['Filter']['date'], array('class'=>'form-control')); ?>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label>Description</label>
                                    <?= Html::textInput('Filter[description]', $_GET['Filter']['description'], array('class'=>'form-control')); ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12" style="text-align: right;">
                                <?= Html::submitButton('Apply Filter', ['class'=>'btn btn-success']); ?>
                                <?= Html::button('Clear Filters', ['class'=>'btn btn-danger', 'onclick'=>"$('.form-control').val(''); $('#filter_form').submit();"]); ?>
                            </div>
                        </div>
                        
                    <?= Html::endForm(); ?>
                        
                    </div>
                
            </div>
        </div>
    </div>
             
    <div class="row">
        <div class="col-md-12">
            
    <?php  
    $models = $dataProvider->getModels();
    if ($models != null) {
        $date = "";
        foreach($models as $model) {
            
            if ($date != $model->date) {
                
                // closes the panel of this day
                if ($date != "") {
                    echo '</div></div>';
                }
                
                // open a new day panel 
                ?>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <b><?= $model->date_short; ?></b>
                    </div>
                    <div class="panel-body" style="padding: 0 15px;">
                        
    
                <?php 
                $date = $model->date;
            }
       
            ?>
                <div class="row dt-body mn-hover-line">
                    <div class="col-md-1">
                        <h5><?= substr($model->time, 0, 5); ?></h5>
                    </div>
                    
                    <div class="col-md-9">
                        <h5><?= Html::encode($model->description); ?></h5>
                    </div>
                    
                    <div class="col-md-2" style="text-align: right;">
                        <?= Html::a("<span class='glyphicon glyphicon-check'></span>", ['mark-done', 'id' => $model->event_id], ['class' => 'btn btn-success btn-sm', 'title' => 'Mark as Done', 'onclick' => 'return window.confirm("Mark this event as done ?")']) ?>
                        <?= Html::a("<span class='glyphicon glyphicon-pencil'></span>", ['update', 'id' => $model->event_id], ['class' => 'btn btn-primary btn-sm', 'title' => 'Edit Event']) ?>
                        <?= Html::a("<span class='glyphicon glyphicon-trash'></span>", ['delete', 'id' => $model->event_id], ['class' => 'btn btn-danger btn-sm', 'title' => 'Delete Event', 'onclick'=>'return window.confirm("Are you sure you want to delete this event ?")']) ?>
                    </div>
                </div>
            <?php 
            
        }
    }
    ?>
                    </div>
                </div>
            
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12" style="text-align: right;">
            <?= \yii\widgets\LinkPager::widget([
                'pagination'=>$dataProvider->pagination,
            ]); ?>
        </div>
    </div>
    
</div>

