<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\forms\AddNewsForm */
/* @var $form ActiveForm */
?>
<div class="add_news">
    <?php
    $this->registerJs(
            '$("document").ready(function(){
            $("#add_news").on("pjax:end", function() {
            $("#modal").modal("show");
        });
    });'
    );
    Pjax::begin(['id' => 'add_news']);
    Modal::begin([
        'id' => 'modal',
        'header' => '<h2>Добавление новости</h2>',
        'toggleButton' => [
            'label' => 'Добавить',
            'class' => ['btn', 'btn-default'],
            'title' => 'Добавление новости',
        ],
    ]);
    ?>
    <?php $form = ActiveForm::begin([
                        'action' => ['/news/create'],
                        'method' => 'post',
                        'options' => ['data' => ['pjax' => true],],
                    ]); ?>
    <?= $form->field($model, 'title') ?>
    <?= $form->field($model, 'content')->textarea() ?>
<?= $form->field($model, 'logo')->fileInput() ?>

    <div class="form-group">
    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    <?php Modal::end(); ?>
<?php Pjax::end(); ?>
</div><!-- add_news -->
