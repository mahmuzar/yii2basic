<?php
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\bootstrap\ButtonGroup;
use yii\helpers\Url;

$this->title = 'Новсти';
$this->params['breadcrumbs'][] = $this->title;
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
        ]
    ]);
    GridView::end();
    ?>
</div>