<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\forms\LoginForm;
use app\models\forms\ContactForm;
use app\common\model\User as UserRoles;
use app\common\components\AccessRule;
use app\models\NewsActiveRecord;
use yii\data\ActiveDataProvider;
use app\models\forms\AddNewsForm;
use yii\web\UploadedFile;
use yii\web\ForbiddenHttpException;
use app\modules\notification\NotificationModule;

class NewsController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'only' => [
                    'create', 'update', 'delete'
                ],
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'delete'],
                        'allow' => TRUE,
                        'roles' => [
                            UserRoles::ROLE_ADMIN,
                            UserRoles::ROLE_MODERATOR
                        ]
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => TRUE,
                        'roles' => [
                            UserRoles::ROLE_ADMIN,
                            UserRoles::ROLE_MODERATOR,
                            UserRoles::ROLE_USER
                        ]
                    ],
                ]
            ]
        ];
    }

    public function __construct($id, $module, $config = array()) {
        parent::__construct($id, $module, $config);
    }

    public function actionCreate() {
        $model = new AddNewsForm();
        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            $model->logo = UploadedFile::getInstance($model, 'logo');
        }

        if ($model->validate() && $model->save()) {

            return $this->redirect(['news/index']);
        }

        return $this->render('_add_news', ['model' => $model]);
    }

    public function actionView($id) {
        $model = NewsActiveRecord::findOne($id);
        return $this->render('read', ['model' => $model]);
    }

    public function actionUpdate($id) {

        $news = NewsActiveRecord::findOne($id);
        $postData = Yii::$app->request->post(); //получим данные формы
        //обновим только тайтл и контент новости, а лого оставим, на случай если
        //в форме нету, чтобы сохранить предыдуший
        if (!empty($postData)) {
            $news->title = $postData['NewsActiveRecord']['title'];
            $news->content = $postData['NewsActiveRecord']['content'];
        }

        $logo = UploadedFile::getInstance($news, 'logo');
        //проверим передан ли файл
        if ($logo instanceof UploadedFile) {
            $logo->saveAs(\Yii::getAlias('@app') . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $logo->baseName . '.' . $logo->extension);
            $news->logo = $logo->baseName . '.' . $logo->extension;
        }


        //обновим данные
        if ($news->update()) {
            return $this->redirect(['news/index']);
        }

        return $this->render('_update_news_modal', ['model' => $news]);
    }

    public function actionDelete($id) {
        $news = NewsActiveRecord::findOne($id);
        if ((Yii::$app->user->getId() == $news->user_id) || (Yii::$app->user->getIdentity()->role >= UserRoles::ROLE_ADMIN)) {
            $news->delete();
            return $this->redirect(['news/index']);
        }
        throw new ForbiddenHttpException("Forbidden access");
    }

    public function actionIndex($pageSize = null) {
        //$model = new NewsActiveRecord();
        if (is_null($pageSize)) {
            $pageSize = 5;
        }

        $dataProvider = new ActiveDataProvider([
            'query' => NewsActiveRecord::find(),
            'pagination' => [
                'pageSize' => $pageSize,
            ],
        ]);
        $addNewsForm = new AddNewsForm();
        if (Yii::$app->user->isGuest) {
            $dataProvider->query->where(['status'=>1]);
            return $this->render('guest/index', ['dataProvider' => $dataProvider]);
        }
        if (Yii::$app->user->getIdentity()->role <= 10) {
            $dataProvider->query->where(['status'=>1]);
            return $this->render('user/index', ['dataProvider' => $dataProvider]);
        }
        return $this->render('index', ['dataProvider' => $dataProvider, 'model' => $addNewsForm]);
    }

    public function actionStatus($id = null) {
        if (!is_null($id)) {
            $news = NewsActiveRecord::findOne(['id' => $id]);
            var_dump($news->status);
            if ($news->status == 1) {
                $news->status = 0;
            } else {
                $news->status = 1;
            }
            $news->save();
        }
        unset($news);
        //var_dump($news->status);

        return TRUE;
    }

}
