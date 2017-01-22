<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var AvailableSections */

$this->title = 'VideoService';
$this->params['breadcrumbs'][] = ['label' => 'Sections'];
?>
<div class="site-index">
    <div class="body-content">

        <div style="color:red">
            <h3>
                <?= Yii::$app->session->getFlash('noLogin'); ?>
            </h3>
        </div>

        <?php if (isset($AvailableSections)): ?>

            <?php foreach ($AvailableSections as $section): ?>

                <div class="<!--panel panel--->default col-lg-4">
                    <!--            <div class="row">-->
                    <div class="panel-heading">
                        <h2 class="panel-title"><a
                                href="<?= yii\helpers\Url::to(['site/section', 'id' => $section->id]) ?>"><?= $section->name ?></a>
                        </h2>
                    </div>

                    <div class="panel-body">
                        <div>
                            <?= Html::img('backend/web/' . $section->image->path, [
                                'width' => '300px',
                                'high' => '300px',
                            ])
                            ?>
                        </div>

                        <div>
                            <a class="btn btn-default"
                               href="<?= yii\helpers\Url::to(['site/section', 'id' => $section->id]) ?>">View &raquo;</a>
                        </div>

                    </div>
                </div>

            <?php endforeach ?>

        <?php endif ?>

    </div>
</div>
