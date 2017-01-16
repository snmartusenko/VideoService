<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Image */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="image-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<!--    --><?//= $form->field($model, 'path')->textInput(['maxlength' => true]) ?>

<!--    --><?//= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

<!--    --><?//= $form->field($model, 'section_id')->dropDownList(
//        \yii\helpers\ArrayHelper::map(\common\models\Section::getActiveSectionArray(),'id','name'),
//        ['prompt'=>'Select section']
//    ) ?>

    <?= $form->field($model, 'description')->textarea()        ?>

    <?= $form->field($model, 'status')->dropDownList(
        [
            \common\models\User::STATUS_ACTIVE => 'Active',
            \common\models\User::STATUS_DELETED => 'Deleted',
        ],
        [
            'prompt' => 'Select a status ...'
        ])
    ?>

    <?= $form->field($model, 'ImageForUpload')->fileInput()      ?>

<!--    --><?//= $form->field($model, 'created_at')->textInput() ?>
<!---->
<!--    --><?//= $form->field($model, 'created_by')->textInput() ?>
<!---->
<!--    --><?//= $form->field($model, 'updated_at')->textInput() ?>
<!---->
<!--    --><?//= $form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
