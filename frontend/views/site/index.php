<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $activeSections */

$this->title = 'VideoService';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">

    <div class="body-content">

        <?php if (isset($activeSections)): ?>

        <?php foreach ($activeSections as $section): ?>

        <div class="panel panel-default col-lg-4">
<!--            <div class="row">-->
                <div class="panel-heading">
                    <h2 class="panel-title"><a
                            href="<?= yii\helpers\Url::to(['site/section', 'id' => $section->id]) ?>"><?= $section->name ?></a>
                    </h2>
                </div>

                <div class="panel-body">
                    <?= Html::img('backend/web/' . $section->image->path, [
                        'width' => '300px',
                        'high' => '300px',
                    ])
                    ?>


                <div>
                    <a class="btn btn-default"
                       href="<?= yii\helpers\Url::to(['site/section', 'id' => $section->id]) ?>">View &raquo;</a>
                </div>

<!--                </div>-->
            </div>
        </div>
    </div>

    <?php endforeach ?>

    <?php endif ?>

</div>
</div>
