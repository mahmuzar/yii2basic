<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\forms\UsersForm */
/* @var $form ActiveForm */
$this->registerJs(
        '$("document").ready(function(){
            $("#add_user").on("pjax:end", function() {
            $("#modal").modal("show");
        });
    });'
);

?>
<div class="add_user_modal">

    <?php
    Pjax::begin(['id' => 'add_user']);
    Modal::begin([
        'id'=>'modal',
        'header' => '<h2>Добавление нового пользователя</h2>',
        'toggleButton' => [
            'label' => 'Добавить',
            'class' => ['btn', 'btn-default'],
            'title' => 'Добавление нового пользователя',
        ],
    ]);
    ?>
    <?php
    $form = ActiveForm::begin(
                    [
                        'action' => ['/users/create'],
                        'method' => 'post',
                        'options' => ['data' => ['pjax' => true],],
                    ]
    );
    ?>

    <?= $form->field($model, 'username') ?>
    <?= $form->field($model, 'password') ?>
    <?= $form->field($model, 'email') ?>
    <?= $form->field($model, 'role') ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

    <?php Modal::end(); ?>
    <?php Pjax::end(); ?>
</div><!-- _add_user_modal -->