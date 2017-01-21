<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use common\widgets\Alert;

/* @var $this yii\web\View */
/* @var $model common\models\Video */

$this->title = 'Create Video';
$this->params['breadcrumbs'][] = ['label' => 'Videos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div style="color:red">
        <h3>
        <?= Yii::$app->session->getFlash('noImage'); ?>
        <?= Yii::$app->session->getFlash('noVideo'); ?>
        </h3>
    </div>

<!--    --><?php
//    if(Yii::$app->session->hasFlash('noImage')){
//        echo 'noimage';
//    }; ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]);

//    if ($model->ImageForUpload == null) {
//
//        Alert::begin([
//                'header' => 'Warnig!',
////        'toggleButton' => 'window',
//                'footer' => 'footer'
//            ]
//        );
//        echo 'Can not load preview image';
//        Alert::end();
//    }
    ?>

</div>

<?php


?>
