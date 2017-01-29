<?php
/**
 * Created by PhpStorm.
 * User: Serg
 * Date: 23.01.2017
 * Time: 8:56
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use wadeshuler\jwplayer\JWPlayer;

/* @var $this yii\web\View */
/* @var $section */
/* @var $topic */
/* @var $Videos */

$this->title = 'Topic \'' . $topic->name . '\'';
$this->params['breadcrumbs'][] = ['label' => 'Section \'' . $section->name . '\'', 'url' => '/site/section/' . $section->id];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">

    <div class="body-content">

        <h2><?= $topic->name ?></h2>

        <?php if (isset($Videos)): ?>

            <?php foreach ($Videos as $video): ?>

                <?php
                $videoName = $video->name;
                $videoPath = Url::to($video->VideoParentFolderLink . $video->path);
//                $videoPath = Yii::getAlias('@backend') . "/web/" . $video->path;
//                $videoPath = 'http://vjs.zencdn.net/v/oceans.mp4';
                $imagePath = Url::to($video->VideoParentFolderLink . $video->previewImage->path);
//                $imagePath = "http://videoservice/frontend/web/" . $video->previewImage->path // !!!рабочий путь
                ?>

                <h3><?= $videoName ?></h3>

                <?= JWPlayer::widget([
                'htmlOptions' => [
                    'class' => 'myVideoPlayer',
                ],
                'playerOptions' => [
                    'title' => $videoName,
                    'file' => $videoPath,
                    'image' => $imagePath,
                    'width' => '500px',
                    'height' => '300px',
                    'controls' => true,
                    'autostart' => false,
                    'mute' => false,
                    'stretching' => "uniform",
                ]
            ]) ?>

                <!--                <div>-->
                <!--                    --><?//= \wbraganca\videojs\VideoJsWidget::widget([
//                        'options' => [
//                            'class' => 'video-js vjs-default-skin vjs-big-play-centered',
//                            'poster' => $imagePath,
//                            'controls' => true,
//                            'preload' => 'auto',
//                            'width' => '970',
//                            'height' => '800',
//                            'title' => $videoName,
//                            'src' => $videoPath, 'type' => 'video/mp4'
//                        ],
//                    ]);
//                    ?>
                <!--                </div>-->

                <!--                <div id="VideoPlayer_--><?//= $video->id ?><!--">Загрузка плеера...</div>-->
                <!--                <script type="text/javascript">-->
                <!--                    jwplayer("VideoPlayer_--><?//= $video->id ?><!--").setup({-->
                <!--                        file: "--><?//= $videoPath ?><!--",-->
                <!--                        image: "--><?//= $imagePath ?><!--",-->
                <!--                        width: 400,-->
                <!--                        height: 200,-->
                <!--                        controls: true,-->
                <!--                        autostart: false,-->
                <!--                        mute: false,-->
                <!--                        stretching: "uniform",-->
                <!--                        title: "--><?//= $videoName ?><!--"-->
                <!--                    });-->
                <!--//                </script>-->

                <!--            кнопки-лайки-->
                <div>
                    <br/>
                    <?= Html::a('Like', ['site/fave/like', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Unlike', ['site/fave/unlike', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </div>

                <br/><br/><br/>

            <?php endforeach ?>

        <?php endif ?>

    </div>
</div>


