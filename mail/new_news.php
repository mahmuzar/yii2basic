<?php

use yii\helpers\Url;
?>
<h1>Здравствуйте. Добавлена новая новость!</h1>

<p>Чтобы прочитать перейдите по 
    <a href="<?= Url::to('@example') ?><?= Url::to(['news/view', 'id' => $event->sender->id]) ?>">ссылке</a>
</p>
