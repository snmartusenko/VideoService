<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $activeSections */

$this->title = 'Topics';
$this->params['breadcrumbs'][] = 'Section \'' . $section->name . '\'';
?>
<div class="site-index">

    <div class="body-content">

        <?php if (isset($activeTopics)): ?>

            <?php foreach ($activeTopics as $topic): ?>

                <div>
                    <div>
                        <h2><?= $topic->name; ?></h2>
                    </div>

                    <div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem delectus doloribus earum eius
                            fuga hic laudantium minima natus nostrum nulla obcaecati perferendis praesentium, qui quos
                            reiciendis sapiente veritatis, voluptas, voluptatum?</p>
                    </div>

                    <div>
                        <a class="btn btn-default"
                           href="<?= yii\helpers\Url::to(['site/topic', 'id' => $topic->id]) ?>">View &raquo;</a>
                    </div>

                </div>

            <?php endforeach ?>

        <?php endif ?>

    </div>
</div>
