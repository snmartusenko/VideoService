<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Video */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="video-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<!--    --><?//= $form->field($model, 'section_id')->dropDownList(
//        \yii\helpers\ArrayHelper::map(\common\models\Section::getActiveSectionArray(),'id','name'),
//        ['prompt'=>'Select section']
//    ) ?>

    <?= $form->field($model, 'topic_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(\common\models\Topic::getActiveTopicArray(),'id','name'),
        ['prompt'=>'Select topic']
    ) ?>

    <?= $form->field($model, 'description')->textarea()        ?>

    <?= $form->field($model, 'VideoForUpload')->fileInput(['accept' => 'video/*'])->label('Video')     ?>

    <?= $form->field($model, 'ImageForUpload')->fileInput(['accept' => 'image/*'])->label('Image')      ?>

<!--    --><?//= $form->field($model, 'preview_image')->dropDownList(
//        \yii\helpers\ArrayHelper::map(\common\models\Image::getActiveImageArray(),'id','name'),
//        ['prompt'=>'Select image for preview']
//    ) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
