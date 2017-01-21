<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use wadeshuler\jwplayer\JWPlayer;

/* @var $this yii\web\View */
/* @var $model common\models\Video */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Videos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'path',
            'description',
            'status',
            [
                'attribute' => 'topic_name',
                'format' => 'raw',
                'value' => $model->topic->name
            ],
            [
                'attribute' => 'preview_image',
                'format' => ['image', ['width' => '100']],
                'value' => $model->VideoParentFolderLink . $model->previewImage->path
            ],
            [
                'attribute' => 'created_at',
                'format' => 'raw',
                'value' => $model->getDate($model->updated_at)
            ],
            [
                'attribute' => 'created_by',
                'format' => 'raw',
                'value' => $model->getCreatedBy('username')
            ],

            [
                'attribute' => 'updated_by',
                'format' => 'raw',
                'value' => $model->getCreatedBy('username')
            ],
            [
                'attribute' => 'updated_at',
                'format' => 'raw',
                'value' => $model->getDate($model->updated_at)
            ],
        ],
    ]) ?>

    <?= JWPlayer::widget([
        'htmlOptions' => [
            'class' => 'myVideoPlayer',
        ],
        'playerOptions' => [
            'title' => $model->name,
            'file' => $model->VideoParentFolderLink . $model->path,
            'image' => $model->VideoParentFolderLink . $model->previewImage->path,
            'width' => '500px',
            'height' => '300px',
            'controls' => true,
            'autostart' => false,
            'mute' => false,
            'stretching' => "uniform",
        ]
    ]) ?>

</div>
