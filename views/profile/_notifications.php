<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $model app\models\ProfileModel */
?>
<div class="col-md-12">
    <h2>Настройка уведомлений</h2>
    <?php
    /* @var $model app\models\ProfileModel */


    $form = ActiveForm::begin([
    'id' => 'login-form',
    'options' => ['class' => 'form-horizontal'],
    ]);


    foreach ($model->notificationOptions as $key => $val) {
    echo $form->field($model, "newNotificationOptions[{$val['id']}]")->checkbox(['value' => is_null($val['status']) ? $val['id'] : NULL, 'label' => $val['name']]);
    }
    ?>
    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
<?= Html::submitButton('Login', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
<?php ActiveForm::end() ?>
</div>