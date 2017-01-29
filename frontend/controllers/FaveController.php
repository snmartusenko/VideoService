<?php
namespace frontend\controllers;

use common\models\Section;
use common\models\Topic;
use common\models\Video;
use common\models\Like;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Fave controller
 */
class FaveController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'only' => ['logout', 'signup'],
//                'rules' => [
//                    [
//                        'actions' => ['signup'],
//                        'allow' => true,
//                        'roles' => ['?'],
//                    ],
//                    [
//                        'actions' => ['logout'],
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
//                ],
//            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
//        $AvailableSections = Section::getActiveSectionArray();

        $user = Yii::$app->user;

        if ($user->identity) {
            $AvailableSections = Section::getAvailableForUserSections($user->id);
        } else {
            Yii::$app->session->setFlash('noLogin', "Please login for Section viewing");
            $AvailableSections = null;
        }

        return $this->render('index', ['AvailableSections' => $AvailableSections]);
    }

//    public function actionSection($id)
//    {
//        $section = Section::findOne($id);
//
//        // �������� ������ �������� ���
////        $activeTopics = $section->topics->activeTopicArray();
//        $activeTopics = Topic::find()
//            ->where(['section_id' => $id])
//            ->andWhere(['status' => Topic::STATUS_ACTIVE])
//            ->all();
//
//        // ���������� ����
//        return $this->render('topic', ['activeTopics' => $activeTopics, 'section' => $section]);
//    }
//
//    public function actionTopic($id)
//    {
//        $topic = Topic::findOne($id);
//
//        $section = Section::findOne($topic->section_id);
//
//        $Videos = Video::getActiveVideosInTopic($id);
//
//        return $this->render('view', ['section' => $section, 'topic' => $topic, 'Videos' => $Videos]);
//    }

    public function actionLike($video_id)
    {

        $user_id = Yii::$app->user->id;

        $model = Like::find()
            ->where(['user_id' => $user_id])
            ->andWhere(['video_id' => $video_id])
            ->one();

        if($model == null){
            $model = new Like;
            $model->user_id = $user_id;
            $model->video_id = $video_id;
        }

        $model->status = Like::STATUS_ACTIVE;

        return $model->save();
    }

    public function actionUnlike($video_id)
    {

        $user_id = Yii::$app->user->id;

        $model = Like::find()
            ->where(['user_id' => $user_id])
            ->andWhere(['video_id' => $video_id])
            ->one();

        if($model != null){
            $model->status = Like::STATUS_DELETED;
            return $model->save();
        }

        return false;
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
