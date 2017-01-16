<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Section */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="section-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList(
        [
            \common\models\Section::STATUS_ACTIVE => 'Active',
            \common\models\Section::STATUS_DELETED => 'Deleted',
        ],
        [
            'prompt' => 'Select a status ...'
        ])
    ?>

<!--    --><?//= $form->field($model, 'image_id')->dropDownList(
//        \yii\helpers\ArrayHelper::map(\common\models\Image::getAllImageArray(),'id','name'),
//           ['prompt'=>'Select image for section'])
//    ?>

    <?= $form->field($model, 'ImageForUpload')->fileInput(['accept' => 'image/*'])->label('Image')      ?>

    <!--    --><?//= $form->field($model, 'image_id')->textInput() ?>

    <!--    --><?//= $form->field($model, 'created_at')->textInput() ?>

    <!--    --><?//= $form->field($model, 'created_by')->textInput() ?>

    <!--    --><?//= $form->field($model, 'updated_at')->textInput() ?>

    <!--    --><?//= $form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
