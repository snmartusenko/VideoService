<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $activeSections */

$this->title = 'Topic \'' . $topic->name . '\'' ;
$this->params['breadcrumbs'][] = ['label' => 'Section \'' . $section->name . '\'' , 'url' => '/site/section/' . $section->id];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">

    <div class="body-content">

        Здесь будет плеер

    </div>
</div>
