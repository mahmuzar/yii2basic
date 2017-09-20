<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\UserPasswordConfirm;
use yii\web\ForbiddenHttpException;
use app\models\UsersActiveRecord;
use \yii\filters\AccessControl;
use app\common\components\AccessRule;
use app\models\ProfileModel;

class ProfileController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'only' => [
                    'activate', 'index'
                ],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => TRUE,
                        'roles' => ['@']
                    ],
                    [
                        'actions' => ['activate'],
                        'allow' => TRUE,
                        'roles' => ['?']
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

    public function actionActivate($token) {
        $confirm = UserPasswordConfirm::findOne(['token' => $token, 'confirmed' => 0]);
        if (!empty($confirm)) {
            if ((new \DateTime($confirm->date))->diff(new \DateTime())->i <= 60) {
                $confirm->confirmed = 1;
                $confirm->save();
                $user = UsersActiveRecord::findOne($confirm->user_id);
                $user->status = 1;
                $user->save();
            } else {
                $confirm->not_valid = 1;
                $confirm->save();
                throw new ForbiddenHttpException("Ссылка просрочена. Пожалуйста, запросите заново.");
            }
        } else {
            throw new ForbiddenHttpException("Сылка действительна только для разового подтверждения");
        }
        Yii::$app->user->logout();
        return $this->redirect(['site/login']);
    }

    public function actionIndex() {

        $model = new ProfileModel();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            return $this->redirect(['profile/index']);
        }



        return $this->render('index', ['model' => $model]);
    }

}
