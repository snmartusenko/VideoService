<?php

namespace backend\controllers;

use Yii;
use common\models\Video;
use common\models\Image;
use common\models\VideoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;

/**
 * VideoController implements the CRUD actions for Video model.
 */
class VideoController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            //AccessControl
            'access' => [
                'class' => AccessControl::className(),
//                'only' => ['login', 'logout', 'signup'],
                'rules' => [
                    // для админа
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],

                    // блокировка админки от обычного пользователя
                    [
                        'actions' => ['logout', 'login', 'error'],
                        'allow' => true,
                        'roles' => ['user'],
                    ],

                    // блокировка админки от неизвестного посетителя
                    [
                        'actions' => ['logout', 'login', 'error'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],

//                    // для зарегистрированного посетителя
//                    [
//                        'actions' => ['logout', 'index'],
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
                ],
            ],

            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Video models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VideoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Video model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Video model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Video();

        if ($model->load(Yii::$app->request->post())) {

            // загрузить и сохранить изображение, получить Image модель
            $ImageModel = $model->uploadImage();

            if ($ImageModel !== null) {
                $model->preview_image = $ImageModel->id;
            } else {
                Yii::$app->session->setFlash('noImage', "Please select Image and Video");
                return $this->render('create', [
                    'model' => $model]);
            }

            // upload a Video
            if ($model->uploadVideo()) {
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('noVideo', "Please select Image and Video");
                return $this->render('create', [
                    'model' => $model]);
            }

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Video model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            // upload an image
            $ImageModel = $model->uploadImage($model->previewImage->id);

            if ($ImageModel !== null) {
                $model->preview_image = $ImageModel->id;
            }

            // upload a video
            $model->uploadVideo($id);

            // save a model
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);

        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Video model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $model->DeactivateVideo();

        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Video model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Video the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Video::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
