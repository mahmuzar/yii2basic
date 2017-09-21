<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\notification\controllers;

use yii\web\Controller;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\common\model\User as UserRoles;
use app\common\components\AccessRule;
use app\modules\notification\models\Notifications;
use yii\data\ArrayDataProvider;
use app\models\NotifIdAndSbrId;

class NotificationController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'only' => [
                    'index', 'delete', 'mark-as-read'
                ],
                'rules' => [
                    [
                        'actions' => ['index', 'delete', 'mark-as-read'],
                        'allow' => TRUE,
                        'roles' => ["@"
                        ]
                    ],
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
        $notifications = new Notifications();
        $data = $notifications->notViewedNotifications();
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $data;
        }
        
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => ['id', 'event'],
            ],
        ]);
        //var_dump($notifications->notViewedNotifications());
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionDelete() {
        
    }

    public function actionMarkAsRead() {
        $postData = Yii::$app->request->post();
        if (!empty($postData['selection'])) {
            foreach ($postData['selection'] as $key => $val) {
                $model = new NotifIdAndSbrId();
                $arr = explode('_', $val);
                $model->notification_id = $arr[0];
                $model->subscriber_id = $arr[1];
                $model->save();
            }
        }
        //Yii::$app->db->createCommand()->batchInsert($table, $columns, $rows)

        $this->redirect(['index']);
    }

}
