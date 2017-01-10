<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput() ?>

<!--    --><?//= $form->field($model, 'section_id')->dropDownList(
//        \yii\helpers\ArrayHelper::map(\common\models\Section::getActiveSectionArray(),'id','name'),
//        ['prompt'=>'Select section']
//    ) ?>

    <?= $form->field($model, 'section_id')->widget(Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\common\models\Section::getActiveSectionArray(),'id','name'),
        'options' => [
            'multiple' => true,
            'placeholder' => 'Select a section ...'
        ],
        'pluginOptions' => [
            'tags' => true,
            'allowClear' => true
            ],
        ])
    ?>

    <?= $form->field($model, 'email')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList(
        [
            \common\models\User::STATUS_ACTIVE => 'Active',
            \common\models\User::STATUS_DELETED => 'Deleted',
        ],
        [
            'prompt' => 'Select a status ...'
        ])
    ?>

<!--    --><?//= $form->field($model, 'role')->textInput() ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
