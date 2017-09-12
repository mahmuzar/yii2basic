<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

use Yii;
use app\models\NewsActiveRecord;
use app\models\UsersActiveRecord;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\common\components\AccessRule;
use app\common\model\User as UserRoles;

class OptionsController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => TRUE,
                        'roles' => [
                            UserRoles::ROLE_ADMIN
                        ]
                    ]
                ]
            ]
        ];
    }

    public function actionIndex() {
        return $this->render('index');
    }

}
