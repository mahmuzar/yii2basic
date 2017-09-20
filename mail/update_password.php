<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


use yii\helpers\Url;
?>
<h1>Новый парль для доступа</h1>
<p>
<h3>Ваш пароль был изменен</h3>
<b>Пароль:</b> <?= $event->getAttribute('password'); ?>
</p>
<p>Для активащии аккаунта перейдите по 
    <a href="<?= Url::to('@example') ?><?= Url::to(['profile/activate', 'token' => $event->getAttribute('token')]) ?>">ссылке</a>
    Ссылка действительная в течении часа.
</p>