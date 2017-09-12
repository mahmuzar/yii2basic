<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

use yii;
use yii\web\Controller;
use \yii\filters\AccessControl;
use app\common\components\AccessRule;
use app\common\model\User as UserRoles;
use yii\data\ActiveDataProvider;
use app\models\UsersActiveRecord;
use app\components\MailSender;
use app\components\EventUser;
use app\components\Handler;
class UsersController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'only' => [
                    'create', 'read', 'update', 'delete', 'index'
                ],
                'rules' => [
                    [
                        'actions' => ['create', 'read', 'update', 'delete', 'index'],
                        'allow' => TRUE,
                        'roles' => [
                            UserRoles::ROLE_ADMIN
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions() {
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
   
    public function actionIndex() {

        $dataProvider = new ActiveDataProvider([
            'query' => UsersActiveRecord::find(),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        $users = UsersActiveRecord::instance();
        return $this->render('index', ['dataProvider' => $dataProvider, 'model' => $users]);
    }

    function actionCreate() {
        
        $model = new UsersActiveRecord();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->trigger($model::EVENT_AFTER_INSERT);
            Yii::$app->session->setFlash('userAdded');
            return $this->redirect(['users/index']);
        }
        return $this->renderAjax('_add_user_modal', ['model' => $model]);
    }

    function actionRead($id) {
        $result = UsersActiveRecord::findOne($id);
        return $this->renderAjax('_update_user_modal', ['model' => $result]);
    }

    function actionUpdate($id) {
        $model = UsersActiveRecord::findOne($id);
        if ($model->load(Yii::$app->request->post()) && $model->update()) {
            Yii::$app->session->setFlash('userUpdated');
            return $this->redirect(['users/index']);
        }
        return $this->renderAjax('_update_user_modal', ['model' => $model]);
    }

    function actionDelete($id) {
        UsersActiveRecord::findOne($id)->delete();
        return $this->redirect(['users/index']);
    }

}