<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\calendar\models\Event */

$this->title = 'Create Event';
$this->params['breadcrumbs'][] = ['label' => 'Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-create">

    <div class="panel panel-info">
        <div class="panel-heading">
            <b>Create Event</b>
        </div>
        <div class="panel-body">    
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
      

</div>
