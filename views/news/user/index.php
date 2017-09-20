<?php
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\widgets\ListView;
use yii\grid\GridView;
use yii\grid\CheckboxColumn;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\bootstrap\ButtonGroup;
use yii\helpers\Url;
$this->title = 'Новсти';
$this->params['breadcrumbs'][] = $this->title;

/*
  echo ListView::widget([
  'dataProvider' => $dataProvider,
  'itemView' => '_list',
  'layout' => "{pager}\n{summary}\n{items}\n{pager}",
  ]);

 */
?>
<div class="news">
    <?php
     echo ButtonGroup::widget(
            ['buttons' => [
                    Html::a('5', Url::current(['pageSize' => 5]), ['class' => 'btn btn-default btn-sm']),
                    Html::a('10', Url::current(['pageSize' => 10]), ['class' => 'btn btn-default btn-sm']),
                    Html::a('20', Url::current(['pageSize' => 20]), ['class' => 'btn btn-default btn-sm']),
                    Html::a('30', Url::current(['pageSize' => 30]), ['class' => 'btn btn-default btn-sm']),
                ]
    ]);

    GridView::begin([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            [
                'attribute' => 'logo',
                'value' => function($model) {
                    return Html::img('@web/uploads/' . $model->logo, [
                                'class' => 'img-thumbnail',
                                'style' => 'width: 100px;',
                                    ]
                    );
                },
                'format' => 'html'
            ],
            'title',
            ['attribute' => 'content',
                'value' => function($model) {
                    return mb_substr(strip_tags($model->content), 0, 20) . '...';
                },
                'format' => 'html'
            ],
            'date',
            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'delete' => function () {
                        
                    },
                    'update' => function() {
                        
                    },
                ],
            ]]
    ]);
    GridView::end();
    ?>
</div>