<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\helpers\Url;
?>
<h1>Подтверждение логина и пароля</h1>

<p>Для активащии аккаунта перейдите по 
    <a href="<?= Url::to('@example') ?><?= Url::to(['profile/activate', 'token' => $event->getAttribute('token')]) ?>">ссылке</a>
</p>