<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Premissions $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="premissions-form">
    <div class="card card-primary">
        <?php $form = ActiveForm::begin(); ?>
            <div class="default-panel">
                <div class="panel-title premission">
                    <span class="non-active">Թույլտվություններ</span>
                </div>
                <div class="form-group col-md-12 col-lg-12 col-sm-12 clientName">
                    <?= $form->field($model, 'role_id')->dropDownList($roles) ?>
                </div>
                <div class="form-group col-md-12 col-lg-12 col-sm-12 clientName">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="card-footer">
                <?= Html::submitButton('Պահպանել', ['class' => 'btn rounded-pill btn-secondary']) ?>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
