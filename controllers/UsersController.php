<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

use Yii;
use yii\web\Controller;
use \yii\filters\AccessControl;
use app\common\components\AccessRule;
use app\common\model\User as UserRoles;
use yii\data\ActiveDataProvider;
use app\models\UsersActiveRecord;
use app\models\forms\UserUpdateForm;

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
            Yii::$app->session->setFlash('userAdded');
            $subscriber = new \app\models\Subscribers;
            $subscriber->user_id = $model->id;
            $subscriber->save();
            return $this->redirect(['users/index']);
        }
        //var_dump($model);
        //die();
        return $this->renderAjax('_add_user_modal', ['model' => $model]);
    }

    function actionRead($id) {
        $result = UsersActiveRecord::findOne($id);
        return $this->renderAjax('_update_user_modal', ['model' => $result]);
    }

    function actionUpdate($id) {
        $model = UsersActiveRecord::findOne($id);
        $form = new UserUpdateForm();
        $form->setAttributes($model->getAttributes());
        $form->password = '';
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $model->setAttributes($form->getAttributes());
            if (!empty($form->password)) {
                $model->passwordUpdate();
                if ($model->save()) {
                    Yii::$app->session->setFlash('userUpdated');
                    return $this->redirect(['users/index']);
                }
            } else {
                return $this->redirect(['users/index']);
            }
        }
        //var_dump($form);
        return $this->renderAjax('_update_user_modal', ['model' => $form]);
    }

    function actionDelete($id) {
        UsersActiveRecord::findOne($id)->delete();
        return $this->redirect(['users/index']);
    }

}
