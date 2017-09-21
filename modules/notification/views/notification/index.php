<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\DataColumn;
use app\components\TemplateEngine;

echo yii\grid\GridView::widget([
    'id' => 'grid',
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'class' => 'yii\grid\CheckboxColumn',
            'checkboxOptions' => function ($model, $key, $index, $column) {
                return ['form' => 'test', 'value' => $model['id'] . '_' . $model['subscriber_id']];
            }
        // you may configure additional properties here
        ],
        [
            'class' => 'yii\grid\DataColumn',
            'label' => 'Непрочитанные уведомления',
            'value' => function ($model) {
                $tmpEng = new TemplateEngine();
                $tmpEng->template = $model['template'];
                return $tmpEng->engine($model);
            },
            'format' => 'html'
        ]
    ]
]);

$form = ActiveForm::begin([
            'id' => 'test',
            'action' => ['/notification/notification/mark-as-read'],
            'method' => 'post',
            'options' => ['class' => 'form-horizontal'],
        ])
?>


<?= Html::submitButton('Отметить как прочитанные', ['class' => 'btn btn-primary']) ?>

<?php ActiveForm::end() ?>
