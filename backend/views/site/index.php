<?php

/* @var $this yii\web\View */

$this->title = 'VideoService Dashboard';
?>
<div class="site-index">

    <div class="row">
        <div class="col-ms-1", align="center">
            <h1>Hello admin!</h1>
        </div>
    </div>
<!--        <p class="lead">You now are using your Yii-powered application.</p>-->
<!--        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>-->

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Sections</h2>

                <p>You can view, create, update, activate/deactivate</p>

                <p><a class="btn btn-default" href="/backend/section">Sections &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Topics</h2>

                <p>You can view, create, update, activate/deactivate</p>

                <p><a class="btn btn-default" href="/backend/topic">Topics &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Videos</h2>

                <p>You can view, create, update, activate/deactivate</p>

                <p><a class="btn btn-default" href="/backend/video">Videos &raquo;</a></p>
            </div>
<!--            <div class="col-lg-4">-->
<!--                <h2>Images</h2>-->
<!---->
<!--                <p>You can view, create, update, activate/deactivate</p>-->
<!---->
<!--                <p><a class="btn btn-default" href="/backend/image">Images &raquo;</a></p>-->
<!--            </div>-->
            <div class="col-lg-4">
                <h2>Users</h2>

                <p>You can view, create, update, activate/deactivate, delete</p>

                <p><a class="btn btn-default" href="/backend/user">Users &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Go to frontend</h2>

                <p><br></p>

                <p><a class="btn btn-default" href="/">Go!</a></p>
            </div>

        </div>

    </div>
</div>
