<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Section */

$this->title = 'Create Section';
$this->params['breadcrumbs'][] = ['label' => 'Sections', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="section-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div style="color:red">
        <h3>
            <?= Yii::$app->session->getFlash('noImage'); ?>
            <?= Yii::$app->session->getFlash('noSave'); ?>
        </h3>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
