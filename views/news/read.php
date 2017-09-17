<?php
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\widgets\ListView;
use yii\grid\GridView;
use yii\grid\CheckboxColumn;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use yii\helpers\Url;

$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;

/*
  echo ListView::widget([
  'dataProvider' => $dataProvider,
  'itemView' => '_list',
  'layout' => "{pager}\n{summary}\n{items}\n{pager}",
  ]);
  [
  'attribute' => 'logo',
  'value' => function($model) {
  return Html::img('@web/uploads/' . $model->logo,[
  'class'=>'img-thumbnail',
  'style'=>'width: 100px;',
  ]
  );
  },
  'format' => 'html'
  ]
 */
?>
<style>
    .news{


    }
</style>
<div class="news">
    <?php
    echo DetailView::widget([
        'id' => 'df',
        'model' => $model,
        'template' => '<tr><td{contentOptions}>{value}</td></tr>',
        'attributes' => [
            [
                'attribute' => 'title',
                'contentOptions' => [
                    'style' => [
                    ]
                ],
            ],
            'date',
            [
                'attribute' => 'logo',
                'contentOptions' => [
                    'style' => [
                    ]
                ],
                'value' => function($model) {
                    return Html::img('@web/uploads/' . $model->logo, [
                                'class' => 'img-thumbnail',
                                'style' => 'width: 400px;',
                    ]);
                },
                'format' => 'html'
            ],
            [
                'attribute' => 'content',
                'format' => 'html'
            ]
        ],
    ]);
    echo \yii\helpers\Html::a('Back', Yii::$app->request->referrer ? (Yii::$app->request->referrer) : (Url::to(['news/index'])));
    ?>

</div>