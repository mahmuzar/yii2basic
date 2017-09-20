<?php
/* @var $event app\modules\notification\events\ModuleEvents */

use yii\helpers\Url;
?>
<h1>Учетная запись для сайта example.com</h1>
<p>
<h3>Ваши учетные данные:</h3>
<b>Логин:</b> <?= $event->getAttribute('username'); ?><br>
<b>Пароль:</b> <?= $event->getAttribute('password'); ?>
</p>
<p>Для активащии аккаунта перейдите по 
    <a href="<?= Url::to('@example') ?><?= Url::to(['profile/activate', 'token' => $event->getAttribute('token')]) ?>">ссылке</a>
    Ссылка действительная в течении часа.
</p>