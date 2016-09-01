<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\calendar\models\Event */
/* @var $form yii\widgets\ActiveForm */


//$this->registerJs('$("#event-category_idundefined").css("z-index", 1)');
?>



<div class="event-form">

    <?php $form = ActiveForm::begin(); ?>
    
        <div class="row">
            <div class="col-md-4">
                <?=
                $form->field($model, 'date')->widget(\yii\jui\DatePicker::className(), ['dateFormat' => 'yyyy-MM-dd', 'options'=>['class'=>'form-control', 'style'=>'z-index: 2', 'autocomplete'=>'off']]);
                ?>            
            </div>
            <div class="col-md-2">
                <?= $form->field($model, 'time')->textInput()->widget(yii\widgets\MaskedInput::className(), ['mask' => '99:99']) ?>
            </div>
        </div>

        <?= $form->field($model, 'description')->textarea() ?>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'category_id', ['inputOptions'=>['class'=>'form-control mn-chosen', 'prompt'=>'...', 'data-placeholder'=>'...']])->dropDownList(app\modules\calendar\models\Category::getDropDownList()) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'status')->dropDownList([ 'ACTIVE' => 'ACTIVE', 'DONE' => 'DONE', 'CANCELED' => 'CANCELED', ], ['class'=>'form-control mn-chosen', 'prompt'=>'...', 'data-placeholder'=>'...']) ?>
            </div>
        </div>


        <div class="form-group" style="text-align: right;">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
            <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-danger']) ?>
        </div>


    <?php ActiveForm::end(); ?>

</div>


