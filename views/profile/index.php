<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use yii\bootstrap\Tabs;
?>


<div class="container">
    <h1>Настройки профиля</h1>
    <div class="row">
        <?php
        
        echo Tabs::widget([
            'items' => [
                [
                    'label' => 'Главная',
                    'content' => $this->render('_index', ['model'=>$model]),
                    'active' => true
                ],
                [
                    'label' => 'Уведомления',
                    'content' => $this->render('_notifications', ['model'=>$model]),
                    'headerOptions' => [],
                    'options' => ['id' => 'myveryownID'],
                ],
                
            ],
        ]);
        ?>
    </div>

</div>