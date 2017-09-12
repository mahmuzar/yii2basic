<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\bootstrap\Alert;
if (Yii::$app->session->hasFlash('userAdded')) {
    echo Alert::widget([
        'options' => [
            'class' => 'alert-success',
        ],
        'body' => 'Пользователь успешно добавлен',
    ]);
} else if (Yii::$app->session->hasFlash('userUpdated')) {
    echo Alert::widget([
        'options' => [
            'class' => 'alert-success',
        ],
        'body' => 'Пользовательские данные успешно обновлены',
    ]);
}