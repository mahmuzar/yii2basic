<?php

use yii\helpers\Url;
?>
<h1>Здравствуйте. Ваши учетные данные для авторизации на сайте rgk.ru</h1>

<dl>
  <dt>Логин</dt>
   <dd><?= $event->sender->username ?></dd>
  <dt>Пароль</dt>
   <dd><?= $event->data['old_password'] ?></dd>
</dl>

<p>Для активащии аккаунта перейдите по 
    <a href="<?= Url::to('@example') ?><?= Url::to(['profile/activate', 'token' => $event->data['token']]) ?>">ссылке</a>
</p>