<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\forms\AddNewsForm */
/* @var $form ActiveForm */
$this->registerJs(
        '$("document").ready(function(){
            $("#update_news").on("pjax:end", function() {
            news_update_form.action=localStorage.getItem("href");
            $("#update_news_modal").modal("show");
        });
    });'
);
?>

<div class="update_news_div">
    <?php
    Pjax::begin(['id' => 'update_news']);
    Modal::begin([
        'id' => 'update_news_modal',
        'header' => '<h2>Добавление новости</h2>',
        
    ]);
    ?>
    <?php
    $form = ActiveForm::begin([
                'id'=>'news_update_form',
                'action' => ['/news/update'],
                'method' => 'post',
                'options' => [
                    ['data' => ['pjax' => true],],
                    ['enctype' => 'multipart/form-data']
                    ],
    ]);
    ?>
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
