<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\calendar\models\Event */

$this->title = 'Update Event: ' . $model->event_id;
$this->params['breadcrumbs'][] = ['label' => 'Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="event-update">

    <div class="panel panel-info">
        <div class="panel-heading">
            <b>Update Event</b>
        </div>
        <div class="panel-body">
    
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
            
        </div>
        
    </div>

</div>
