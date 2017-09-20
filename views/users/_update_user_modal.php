<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\UsersActiveRecord */
/* @var $form ActiveForm */

$this->registerJs(
        '$("document").ready(function(){
            
            $("#update_user_d").on("pjax:end", function() {
            user_update_form.action=localStorage.getItem("href");
            $("#user_update_form").attr("action", localStorage.getItem("href"));
            $("#update_modal").modal("show");
        });
         $("#update_user_button").on("click", function () {
        
        $("#update_modal").css("display", "none");
    });
    });
   
'
);
?>
<div class="update_user_modal">

    <?php
    Pjax::begin(['id' => 'update_user_d']);
    Modal::begin([
        'id' => 'update_modal',
        'header' => '<h2>Редактирование данных пользователя</h2>',
    ]);
    ?>
    <?php
    $form = ActiveForm::begin(
                    ['id' => 'user_update_form',
                        'action' => ['/users/update'],
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
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'id' => 'update_user_button']) ?>
    </div>
    <?php ActiveForm::end(); ?>

    <?php Modal::end(); ?>
    <?php Pjax::end(); ?>
</div><!-- _add_user_modal -->
